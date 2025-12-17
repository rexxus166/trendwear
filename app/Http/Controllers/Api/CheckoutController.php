<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Config; // Import Midtrans
use Midtrans\Snap;   // Import Midtrans

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string',
            'phone_number'   => 'required|string',
            'address_full'   => 'required|string',
            'city'           => 'required|string',
            'province'       => 'required|string',
            'postal_code'    => 'required|string',
            'courier'        => 'required|string',
            'service'        => 'required|string',
            'shipping_cost'  => 'required|integer',
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

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $totalWeight = 0;

            // --- HITUNG SUBTOTAL ---
            foreach ($carts as $cart) {
                $price = $cart->product->price; // Default harga dasar

                // Logic Harga Varian
                if ($cart->size && !empty($cart->product->variants_data)) {
                    $variants = $cart->product->variants_data;
                    foreach ($variants as $v) {
                        if (isset($v['key']) && $v['key'] == $cart->size && isset($v['price'])) {
                            $price = (int) $v['price'];
                            break;
                        }
                    }
                }

                $subtotal += $price * $cart->quantity;
                $totalWeight += $cart->product->weight * $cart->quantity;

                // Cek Stok
                if ($cart->product->stock < $cart->quantity) {
                    throw new \Exception("Stok produk {$cart->product->name} tidak cukup!");
                }
            }

            $grandTotal = $subtotal + $request->shipping_cost;

            // 3. Buat Data Order
            $orderNumber = 'TRX-' . date('YmdHis') . '-' . $user->id;

            $order = Order::create([
                'user_id'        => $user->id,
                'order_number'   => $orderNumber,
                'recipient_name' => $request->recipient_name,
                'phone_number'   => $request->phone_number,
                'address_full'   => $request->address_full,
                'city'           => $request->city,
                'province'       => $request->province,
                'postal_code'    => $request->postal_code,
                'courier'        => $request->courier,
                'service'        => $request->service,
                'shipping_cost'  => $request->shipping_cost,
                'total_weight'   => $totalWeight,
                'subtotal'       => $subtotal,
                'grand_total'    => $grandTotal,
                'status'         => 'pending',
                // snap_token nanti diupdate di bawah
            ]);

            // 4. Pindahkan Cart ke Order Item
            foreach ($carts as $cart) {
                // Hitung ulang harga per item untuk snapshot
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
                    'product_name' => $cart->product->name,
                    'variant_info' => $cart->size,
                    'quantity'     => $cart->quantity,
                    'price'        => $price,
                    'subtotal'     => $price * $cart->quantity,
                ]);

                // Kurangi Stok
                $cart->product->decrement('stock', $cart->quantity);
            }

            // --- INTEGRASI MIDTRANS ---
            // Set konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key'); // Ambil dari config/services atau .env
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => (int) $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $request->phone_number,
                ],
            ];

            // Minta Snap Token
            $snapToken = Snap::getSnapToken($midtransParams);

            // Update token ke database
            $order->update(['snap_token' => $snapToken]);

            // 5. Hapus Keranjang
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return response()->json([
                'message'    => 'Checkout berhasil!',
                'data'       => $order,
                'snap_token' => $snapToken // <--- Token dikirim ke Flutter
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal Checkout: ' . $e->getMessage()
            ], 500);
        }
    }
}
