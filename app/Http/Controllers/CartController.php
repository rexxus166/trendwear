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

    // Update quantity (tetap sama)
    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($request->type === 'increment') {
            if ($cart->product->stock > $cart->quantity) {
                $cart->increment('quantity');
            } else {
                return back()->with('error', 'Stok maksimal tercapai!');
            }
        } elseif ($request->type === 'decrement') {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            }
        }

        return back();
    }

    // Menambah item ke keranjang (UPDATED)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'size'       => 'nullable|string',
            'color'      => 'nullable|string',
            'option'     => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);

        // 2. Cek Stok
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // 3. Cek Item Duplikat di Keranjang
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->where('option', $request->option)
            ->first();

        if ($existingCart) {
            $existingCart->update([
                'quantity' => $existingCart->quantity + $request->quantity
            ]);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'size'       => $request->size,
                'color'      => $request->color,
                'option'     => $request->option,
            ]);
        }

        // ==========================================
        // 4. LOGIKA REDIRECT (UPDATE TERBARU)
        // ==========================================

        // Jika tombol yang ditekan adalah "Beli Sekarang"
        if ($request->input('is_buy_now') == 1) {
            return redirect()->route('checkout.index');
        }

        // Jika tombol "Tambah Keranjang" (Default: Stay di halaman produk biar smooth)
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        // Atau jika ingin ke halaman cart: return redirect()->route('cart.index')->with(...)
    }

    // Hapus item (tetap sama)
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cart->delete();

        return back()->with('success', 'Item removed from cart');
    }
}
