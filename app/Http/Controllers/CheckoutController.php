<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

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
}
