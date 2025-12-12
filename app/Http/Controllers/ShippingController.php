<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\UserAddress;

class ShippingController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    }

    public function checkCost(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'courier' => 'required|in:jne,pos,tiki',
            'weight' => 'required|integer|min:1'
        ]);

        $address = UserAddress::find($request->address_id);

        // 1. CARI ID KOTA TUJUAN (DINAMIS)
        // Kita mencari berdasarkan nama KOTA (City) user.
        $queryLocation = $address->city;

        $destinationId = $this->getCityDestinationId($queryLocation);

        // Fallback: Jika gagal, coba gabungkan dengan provinsi
        if (!$destinationId) {
            $destinationId = $this->getCityDestinationId($address->city . ', ' . $address->province);
        }

        if (!$destinationId) {
            return response()->json(['success' => false, 'error' => "Kota '{$address->city}' tidak ditemukan."], 400);
        }

        try {
            $originId = env('RAJAONGKIR_ORIGIN_SUBDISTRICT'); // ID Kota Asal (4816 - Indramayu)

            // --- FITUR HEMAT KUOTA (BACKEND CACHE) ---
            // Kita buat "Key Unik" berdasarkan kombinasi: Asal + Tujuan + Berat + Kurir
            // Contoh: cost_4816_78_1000_jne
            $cacheKey = "cost_{$originId}_{$destinationId}_{$request->weight}_{$request->courier}";

            // Simpan data di cache selama 24 jam (86400 detik)
            $data = Cache::remember($cacheKey, 86400, function () use ($originId, $destinationId, $request) {

                $payload = [
                    'origin' => (int) $originId,
                    'destination' => (int) $destinationId,
                    'weight' => (int) $request->weight,
                    'courier' => strtolower($request->courier)
                ];

                // Log hanya saat melakukan Request asli (bukan dari cache)
                Log::info("API Request (No Cache): " . json_encode($payload));

                $response = Http::withoutVerifying()
                    ->asForm()
                    ->withHeaders(['key' => $this->apiKey])
                    ->post("{$this->baseUrl}/calculate/domestic-cost", $payload);

                return $response->json();
            });

            // Cek Status Response
            if (isset($data['meta']['status']) && $data['meta']['status'] === 'success') {
                return response()->json([
                    'rajaongkir' => [
                        'results' => [
                            [
                                'code' => strtoupper($request->courier),
                                'name' => strtoupper($request->courier),
                                // Format dan Filter hasil di sini
                                'costs' => $this->formatKomerceCosts($data['data'])
                            ]
                        ]
                    ]
                ]);
            } else {
                // Jika error, jangan simpan di cache (hapus key yg baru dibuat)
                Cache::forget($cacheKey);

                return response()->json([
                    'success' => false,
                    'error' => $data['meta']['message'] ?? 'Gagal cek ongkir'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error' => 'Koneksi Gagal'], 500);
        }
    }

    // Helper: Cari ID Kota
    private function getCityDestinationId($queryString)
    {
        return Cache::remember('city_id_v2_' . md5(strtolower($queryString)), 86400, function () use ($queryString) {
            try {
                $response = Http::withoutVerifying()->withHeaders(['key' => $this->apiKey])
                    ->get("{$this->baseUrl}/destination/domestic-destination", [
                        'search' => $queryString,
                        'limit' => 1
                    ]);

                $data = $response->json();
                if (isset($data['data']) && count($data['data']) > 0) {
                    return $data['data'][0]['id'];
                }
                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    // Helper: Format, Rename, dan Filter Layanan
    private function formatKomerceCosts($services)
    {
        if (empty($services)) return [];

        $results = [];

        foreach ($services as $item) {
            $code = strtoupper($item['service_code'] ?? $item['service'] ?? '');

            // --- 1. FILTER BLACKLIST (Hapus Layanan Kirim Motor) ---
            if (str_contains($code, 'JTR<') || str_contains($code, 'JTR>')) continue; // JNE Motor
            if (in_array($code, ['T15', 'T25', 'T60', 'TRC'])) continue; // TIKI Motor

            // --- 2. RENAME (Ubah Kode Jadi Nama Bagus) ---
            $displayName = $code;
            $description = $item['service_name'] ?? 'Estimasi sampai tujuan';

            switch ($code) {
                // JNE
                case 'REG':
                case 'CTC':
                    $displayName = 'Reguler';
                    $description = 'Layanan standar (Cepat & Terjangkau)';
                    break;
                case 'YES':
                    $displayName = 'JNE YES (Besok Sampai)';
                    $description = 'Yakin Esok Sampai';
                    break;
                case 'OKE':
                    $displayName = 'JNE OKE (Ekonomis)';
                    $description = 'Ongkos Kirim Ekonomis (Agak Lama)';
                    break;
                case 'JTR':
                    $displayName = 'JNE Kargo (JTR)';
                    $description = 'Cocok untuk berat > 10kg';
                    break;

                // TIKI
                case 'ECO':
                    $displayName = 'TIKI ECO (Hemat)';
                    $description = 'Layanan Ekonomi';
                    break;
                case 'REG':
                    $displayName = 'TIKI Reguler';
                    $description = 'Layanan Standar';
                    break;
                case 'ONS':
                    $displayName = 'TIKI ONS (Besok Sampai)';
                    $description = 'Over Night Service';
                    break;

                // POS
                case 'POS':
                case 'PKH':
                    $displayName = 'POS Kilat Khusus';
                    break;
            }

            $results[] = [
                'service' => $displayName,
                'description' => $description,
                'cost' => [
                    [
                        'value' => $item['cost'] ?? $item['price'] ?? 0,
                        'etd' => $item['etd'] ?? '-'
                    ]
                ]
            ];
        }

        return $results;
    }
}
