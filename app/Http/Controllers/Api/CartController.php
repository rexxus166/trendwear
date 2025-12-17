<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // 1. LIHAT ISI KERANJANG (API)
    public function index(Request $request)
    {
        // Ambil cart punya user yg login via Token
        $carts = Cart::with('product.images')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        // Bedanya disini: Return JSON, bukan View
        return response()->json([
            'message' => 'List Keranjang',
            'data' => $carts
        ]);
    }

    // 2. TAMBAH KE KERANJANG (API)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string', // Pastikan size dikirim sebagai string
            'color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::find($request->product_id);

        // 2. Cek Stok Produk
        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Stok tidak mencukupi!'], 400);
        }

        // 3. LOGIC PENTING: Cek Duplikasi berdasarkan SIZE
        $existingCart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->where('size', $request->size) // <--- PASTIKAN INI ADA & BENAR
            ->where('color', $request->color) // Opsional, kalau ada fitur warna
            ->first();

        // 4. Eksekusi
        if ($existingCart) {
            // Skenario A: Barang persis sama (Produk sama + Size sama) -> Update Qty
            $newQty = $existingCart->quantity + $request->quantity;

            if ($product->stock < $newQty) {
                return response()->json(['message' => 'Total stok tidak mencukupi!'], 400);
            }

            $existingCart->update(['quantity' => $newQty]);
        } else {
            // Skenario B: Barang beda varian (Produk sama TAPI Size beda) -> Buat Baru
            Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $request->size,   // Simpan size M
                'color' => $request->color,
                'option' => $request->option,
            ]);
        }

        return response()->json(['message' => 'Berhasil masuk keranjang!']);
    }

    // 3. HAPUS ITEM (API)
    public function destroy(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)->where('id', $id)->first();

        if (!$cart) {
            return response()->json(['message' => 'Item tidak ditemukan'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Item dihapus dari keranjang']);
    }
}
