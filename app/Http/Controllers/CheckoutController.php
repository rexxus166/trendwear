<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Midtrans\Config;
use App\Models\Order;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout dengan kalkulasi harga & berat.
     */
    public function index()
    {
        // 1. Ambil Keranjang User
        // Menggunakan eager loading (with) untuk performa query yang lebih baik
        $carts = Cart::with(['product.images'])->where('user_id', Auth::id())->get();

        // Jika keranjang kosong, tendang balik ke halaman keranjang
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 2. Ambil Data Alamat
        // Ambil SEMUA alamat user untuk ditampilkan di Modal Ganti Alamat
        $allAddresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_primary', 'desc') // Alamat utama paling atas
            ->latest()
            ->get();

        // Tentukan alamat aktif saat ini (Default: Primary, jika tidak ada ambil yang pertama)
        $currentAddress = $allAddresses->firstWhere('is_primary', true) ?? $allAddresses->first();

        // 3. Kalkulasi Subtotal & Total Berat
        $subtotal = 0;
        $totalWeight = 0; // Dalam gram

        foreach ($carts as $cart) {
            $basePrice = $cart->product->price;
            $finalUnitPrice = $basePrice;
            $variantsData = $cart->product->variants_data ?? [];

            // A. Cek Selisih Harga Option (Jika user memilih option)
            if ($cart->option) {
                // Cari data varian yang cocok di JSON
                $optData = collect($variantsData)->first(function ($item) use ($cart) {
                    return isset($item['type']) && $item['type'] === 'option' && $item['key'] === $cart->option;
                });

                // Jika ketemu, tambahkan selisihnya
                if ($optData) {
                    $finalUnitPrice += ($optData['price'] - $basePrice);
                }
            }

            // B. Cek Selisih Harga Size (Jika user memilih size)
            if ($cart->size) {
                $sizeData = collect($variantsData)->first(function ($item) use ($cart) {
                    return isset($item['type']) && $item['type'] === 'size' && $item['key'] === $cart->size;
                });

                if ($sizeData) {
                    $finalUnitPrice += ($sizeData['price'] - $basePrice);
                }
            }

            // Simpan harga final sementara ke object cart (agar bisa ditampilkan di View)
            $cart->final_price = $finalUnitPrice;

            // Tambahkan ke Total Harga
            $subtotal += ($finalUnitPrice * $cart->quantity);

            // Tambahkan ke Total Berat
            // Jika berat produk kosong/null, kita default ke 1000 gram (1 kg)
            $itemWeight = $cart->product->weight ?? 1000;
            $totalWeight += ($itemWeight * $cart->quantity);
        }

        // 4. Inisialisasi Biaya Lain
        $shippingCost = 0; // Nanti diupdate via Ajax (RajaOngkir) di Frontend
        $tax = 0; // Pajak (jika ada)

        $grandTotal = $subtotal + $shippingCost + $tax;

        return view('page.checkout.index', compact(
            'carts',
            'allAddresses',
            'currentAddress',
            'subtotal',
            'shippingCost',
            'grandTotal',
            'totalWeight' // Penting untuk dikirim ke API Ongkir
        ));
    }

    public function process(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'courier' => 'required',
            'shipping_cost' => 'required|numeric',
            'shipping_service' => 'required'
        ]);

        try {
            $user = Auth::user();
            // Ambil keranjang beserta data produk
            $carts = Cart::with('product')->where('user_id', $user->id)->get();

            if ($carts->isEmpty()) {
                return response()->json(['success' => false, 'error' => 'Keranjang kosong'], 400);
            }

            // 2. Snapshot Alamat
            $address = UserAddress::find($request->address_id);
            $fullAddress = "{$address->address_line1}, {$address->district}, {$address->city}, {$address->province}";

            // 3. HITUNG ULANG TOTAL & ITEM DETAILS (DENGAN VARIAN)
            $itemsTotal = 0;
            $item_details = [];

            foreach ($carts as $cart) {
                // --- LOGIKA HITUNG HARGA VARIAN (Copy dari method index) ---
                $basePrice = $cart->product->price;
                $finalUnitPrice = $basePrice;

                // Pastikan variants_data berupa Array (Decode jika perlu)
                $variantsData = $cart->product->variants_data;
                if (is_string($variantsData)) {
                    $variantsData = json_decode($variantsData, true);
                }
                $variantsData = $variantsData ?? [];

                // A. Cek Option
                if ($cart->option) {
                    $optData = collect($variantsData)->first(function ($item) use ($cart) {
                        return isset($item['type']) && $item['type'] === 'option' && $item['key'] === $cart->option;
                    });
                    if ($optData) {
                        $finalUnitPrice += ($optData['price'] - $basePrice);
                    }
                }

                // B. Cek Size
                if ($cart->size) {
                    $sizeData = collect($variantsData)->first(function ($item) use ($cart) {
                        return isset($item['type']) && $item['type'] === 'size' && $item['key'] === $cart->size;
                    });
                    if ($sizeData) {
                        $finalUnitPrice += ($sizeData['price'] - $basePrice);
                    }
                }
                // -----------------------------------------------------------

                // Hitung Subtotal Item ini
                $lineTotal = $finalUnitPrice * $cart->quantity;
                $itemsTotal += $lineTotal;

                // Buat Nama Produk + Varian untuk Midtrans (Biar jelas di struk)
                $productName = $cart->product->name;
                $variantLabel = [];
                if ($cart->size) $variantLabel[] = $cart->size;
                if ($cart->option) $variantLabel[] = $cart->option;

                if (!empty($variantLabel)) {
                    $productName .= " (" . implode(', ', $variantLabel) . ")";
                }

                // Masukkan ke Item Details Midtrans
                $item_details[] = [
                    'id' => $cart->product_id, // Atau SKU
                    'price' => (int) $finalUnitPrice, // HARGA YANG SUDAH DITAMBAH VARIAN
                    'quantity' => $cart->quantity,
                    'name' => substr($productName, 0, 50), // Midtrans max 50 chars
                ];
            }

            $shippingCost = (int) $request->shipping_cost;
            $grandTotal = $itemsTotal + $shippingCost;

            // Tambahkan Ongkir ke Item Details
            $item_details[] = [
                'id' => 'SHIPPING',
                'price' => $shippingCost,
                'quantity' => 1,
                'name' => "Ongkir " . strtoupper($request->courier) . " - " . $request->shipping_service,
            ];

            // 4. Generate Order Number
            $orderNumber = 'TRX-' . date('YmdHis') . '-' . mt_rand(100, 999);

            // 5. Simpan ke Database
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'recipient_name' => $address->recipient_name ?? $user->name,
                'phone_number' => $address->phone_number ?? $user->phone,
                'address_full' => $fullAddress,
                'city' => $address->city,
                'province' => $address->province,
                'postal_code' => $address->postal_code,
                'courier' => $request->courier,
                'service' => $request->shipping_service,
                'shipping_cost' => $shippingCost,
                'total_weight' => $request->weight ?? 1000,
                'subtotal' => $itemsTotal,     // Subtotal yang benar
                'grand_total' => $grandTotal,  // Grand total yang benar
                'status' => 'pending',
            ]);

            // Simpan Item (Dengan Harga Varian juga)
            foreach ($carts as $cart) {
                // ... (Ulangi logika hitung harga atau ambil dari loop sebelumnya) ...
                // Agar code rapi, kita hitung ulang sedikit di sini atau simpan di array temporary
                // Tapi untuk aman, kita hitung ulang cepat:

                $basePrice = $cart->product->price;
                $finalUnitPrice = $basePrice;
                $variantsData = $cart->product->variants_data;
                if (is_string($variantsData)) $variantsData = json_decode($variantsData, true);

                if ($cart->option) {
                    $optData = collect($variantsData)->first(function ($item) use ($cart) {
                        return isset($item['type']) && $item['type'] === 'option' && $item['key'] === $cart->option;
                    });
                    if ($optData) $finalUnitPrice += ($optData['price'] - $basePrice);
                }
                if ($cart->size) {
                    $sizeData = collect($variantsData)->first(function ($item) use ($cart) {
                        return isset($item['type']) && $item['type'] === 'size' && $item['key'] === $cart->size;
                    });
                    if ($sizeData) $finalUnitPrice += ($sizeData['price'] - $basePrice);
                }

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    'variant_info' => trim(($cart->size ? "Size: {$cart->size} " : "") . ($cart->option ? "{$cart->option}" : "")),
                    'quantity' => $cart->quantity,
                    'price' => $finalUnitPrice, // Simpan harga final per item
                    'subtotal' => $finalUnitPrice * $cart->quantity,
                ]);
            }

            // 6. Request Snap Token
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => $grandTotal, // Jumlah yang benar
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $address->phone_number ?? '08123456789',
                ],
                'item_details' => $item_details, // Detail yang benar
            ];

            $snapToken = Snap::getSnapToken($params);

            $order->update(['snap_token' => $snapToken]);
            Cart::where('user_id', $user->id)->delete();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderNumber
            ]);
        } catch (\Exception $e) {
            Log::error("Midtrans Error: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function success($order_id)
    {
        // Cari order milik user yang sedang login (biar aman ga diintip orang lain)
        $order = Order::where('order_number', $order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('page.checkout.success', compact('order'));
    }
}
