<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // ... (kode index yang lama biarkan saja) ...
        $categories = Category::withCount('products')->take(4)->get();
        $trendingProducts = Product::with('images')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('page.dashboard.index', compact('categories', 'trendingProducts'));
    }

    // TAMBAHKAN METHOD INI
    public function show($slug)
    {
        // Cari produk berdasarkan slug, sertakan relasi kategori dan gambar
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // (Opsional) Ambil produk terkait untuk bagian "You might also like"
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('page.produk.detail', compact('product', 'relatedProducts'));
    }
}
