<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        // 1. Ambil Keranjang User beserta relasi produk dan gambarnya
        $carts = Cart::with(['product.images'])->where('user_id', Auth::id())->get();

        // Jika keranjang kosong, lempar balik ke halaman keranjang
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // 2. Ambil Data Alamat
        // Ambil SEMUA alamat untuk modal ganti alamat, urutkan primary paling atas
        $allAddresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_primary', 'desc')
            ->latest()
            ->get();

        // Tentukan alamat yang aktif saat ini (Default: Primary, kalau gak ada ambil yang pertama)
        $currentAddress = $allAddresses->firstWhere('is_primary', true) ?? $allAddresses->first();

        // 3. Hitung Subtotal (Server Side Calculation)
        // Kita ulangi logika "Delta Calculation" di sini untuk keamanan data
        $subtotal = 0;

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

                // Jika ketemu, tambahkan selisihnya (Harga Varian - Harga Dasar)
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

            // Simpan harga final sementara ke object cart (agar bisa dipakai di View)
            $cart->final_price = $finalUnitPrice;

            // Tambahkan ke total perhitungan
            $subtotal += ($finalUnitPrice * $cart->quantity);
        }

        // 4. Hitung Biaya Lain-lain
        $shippingCost = 0; // Nanti bisa diintegrasikan dengan API RajaOngkir
        $tax = 0;

        $grandTotal = $subtotal + $shippingCost + $tax;

        return view('page.checkout.index', compact(
            'carts',
            'allAddresses',
            'currentAddress',
            'subtotal',
            'shippingCost',
            'grandTotal'
        ));
    }
}
