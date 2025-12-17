<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // 1. Validasi Input Alamat (Data ini dikirim dari Flutter)
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string',
            'phone_number'   => 'required|string',
            'address_full'   => 'required|string',
            'city'           => 'required|string',
            'province'       => 'required|string',
            'postal_code'    => 'required|string',
            'courier'        => 'required|string', // JNE, JNT, dll
            'service'        => 'required|string', // REG, YES, dll
            'shipping_cost'  => 'required|integer', // Ongkir
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();

        // 2. Ambil Keranjang User
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong, tidak bisa checkout'], 400);
        }

        // 3. Mulai Transaksi Database (Biar aman kalau error di tengah)
        DB::beginTransaction();

        try {
            $subtotal = 0;
            $totalWeight = 0;

            // --- HITUNG SUBTOTAL ---
            foreach ($carts as $cart) {
                // Logic Harga: Cek apakah item ini punya varian size?
                $price = $cart->product->price; // Default harga dasar

                // Cek harga varian spesifik (Logic Backend)
                if ($cart->size && !empty($cart->product->variants_data)) {
                    $variants = $cart->product->variants_data;
                    // Cari varian yg key-nya sama dengan size di cart (misal "L")
                    foreach ($variants as $v) {
                        if (isset($v['key']) && $v['key'] == $cart->size && isset($v['price'])) {
                            $price = (int) $v['price']; // Update harga jadi harga varian
                            break;
                        }
                    }
                }

                // Tambahkan ke subtotal
                $subtotal += $price * $cart->quantity;
                $totalWeight += $cart->product->weight * $cart->quantity;

                // Cek Stok sekalian
                if ($cart->product->stock < $cart->quantity) {
                    throw new \Exception("Stok produk {$cart->product->name} tidak cukup!");
                }
            }

            $grandTotal = $subtotal + $request->shipping_cost;

            // 4. Buat Data Order (Header)
            $orderNumber = 'TRX-' . date('YmdHis') . '-' . $user->id;

            $order = Order::create([
                'user_id'        => $user->id,
                'order_number'   => $orderNumber,

                // Snapshot Alamat
                'recipient_name' => $request->recipient_name,
                'phone_number'   => $request->phone_number,
                'address_full'   => $request->address_full,
                'city'           => $request->city,
                'province'       => $request->province,
                'postal_code'    => $request->postal_code,

                // Info Pengiriman
                'courier'        => $request->courier,
                'service'        => $request->service,
                'shipping_cost'  => $request->shipping_cost,
                'total_weight'   => $totalWeight,

                // Info Bayar
                'subtotal'       => $subtotal,
                'grand_total'    => $grandTotal,
                'status'         => 'pending',
            ]);

            // 5. Pindahkan Cart ke Order Item (Detail)
            foreach ($carts as $cart) {
                // Hitung ulang harga per item untuk snapshot (sama kayak logic di atas)
                $price = $cart->product->price;
                if ($cart->size && !empty($cart->product->variants_data)) {
                    $variants = $cart->product->variants_data;
                    foreach ($variants as $v) {
                        if (isset($v['key']) && $v['key'] == $cart->size && isset($v['price'])) {
                            $price = (int) $v['price'];
                            break;
                        }
                    }
                }

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $cart->product_id,
                    'product_name' => $cart->product->name, // Simpan nama saat beli
                    'variant_info' => $cart->size,          // Simpan size ke variant_info
                    'quantity'     => $cart->quantity,
                    'price'        => $price,               // Simpan harga saat beli
                    'subtotal'     => $price * $cart->quantity,
                ]);

                // Kurangi Stok Produk
                $cart->product->decrement('stock', $cart->quantity);
            }

            // 6. Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();

            // Commit (Simpan Permanen)
            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil!',
                'data'    => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal Checkout: ' . $e->getMessage()
            ], 500);
        }
    }
}
