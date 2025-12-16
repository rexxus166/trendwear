<?php

namespace App\Models; // Hati-hati namespace, sesuaikan jika beda
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Menampilkan halaman wishlist user
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product.images') // Load produk & gambarnya
            ->latest()
            ->get();

        return view('page.wishlist.index', compact('wishlists'));
    }

    // Logic Like / Unlike
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            // Return JSON: action 'removed'
            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari wishlist']);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            // Return JSON: action 'added'
            return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke wishlist']);
        }
    }
}
