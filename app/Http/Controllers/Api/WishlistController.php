<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * GET /api/wishlist
     * Menampilkan daftar wishlist user dalam format JSON.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data wishlist milik user yang sedang login
        // 'product.images' => Ambil data produk beserta gambarnya (penting untuk UI)
        $wishlists = Wishlist::with(['product.images'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List Data Wishlist'
            ],
            // Flutter mengambil data dari key 'data' ini
            'data' => $wishlists
        ], 200);
    }

    /**
     * POST /api/wishlist/toggle
     * Menambah atau Menghapus item dari wishlist (Like/Unlike).
     */
    public function toggle(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Cek apakah user sudah pernah like produk ini?
        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            // Jika SUDAH ADA, maka HAPUS (Unlike)
            $existing->delete();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Product removed from wishlist'
                ],
                'data' => null
            ], 200);
        } else {
            // Jika BELUM ADA, maka TAMBAH (Like)
            $wishlist = Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Product added to wishlist'
                ],
                'data' => $wishlist
            ], 200);
        }
    }
}
