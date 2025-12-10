<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $carts = Cart::with('product.images')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('page.keranjang.index', compact('carts'));
    }

    // Tambahkan method ini
    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Cek tipe aksi (increment / decrement)
        if ($request->type === 'increment') {
            // Cek stok dulu sebelum nambah
            if ($cart->product->stock > $cart->quantity) {
                $cart->increment('quantity');
            } else {
                return back()->with('error', 'Stok maksimal tercapai!');
            }
        } elseif ($request->type === 'decrement') {
            // Minimal sisa 1, kalau mau hapus pakai tombol sampah
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            }
        }

        return back(); // Kembali ke halaman cart tanpa refresh data manual
    }

    // Menambah item ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'option' => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);

        // Cek stok dulu
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // Cek apakah produk sudah ada di keranjang user ini?
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)     // Cek Size
            ->where('color', $request->color)   // Cek Color
            ->where('option', $request->option) // Cek Option
            ->first();

        if ($existingCart) {
            // Kalau sudah ada, update quantity-nya saja
            $existingCart->update([
                'quantity' => $existingCart->quantity + $request->quantity
            ]);
        } else {
            // Kalau belum, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color,
                'option' => $request->option,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Menghapus item dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cart->delete();

        return back()->with('success', 'Item removed from cart');
    }
}
