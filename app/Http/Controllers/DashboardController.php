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

    public function search(Request $request)
    {
        // 1. Ambil kata kunci dari input 'q'
        $keyword = $request->input('q');

        // 2. Cari Produk (Nama ATAU Deskripsi mirip dengan keyword)
        $products = Product::where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->with(['images', 'category']) // Load relasi gambar & kategori biar cepat
            ->latest()
            ->get(); // Kalau mau pakai halaman, ganti ->paginate(12);

        // 3. Kirim data ke View yang baru kamu buat
        return view('page.search.hasil', [
            'products' => $products,
            'keyword' => $keyword
        ]);
    }

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

    public function shop()
    {
        $products = Product::with('images')
            ->where('status', 'active')
            ->latest()
            ->paginate(12); // Pakai pagination biar ga berat

        return view('page.produk.index', [
            'title' => 'Shop All Products',
            'subtitle' => 'Explore our complete collection',
            'products' => $products
        ]);
    }

    // 2. Menampilkan Produk berdasarkan Kategori
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
            ->with('images')
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('page.produk.index', [
            'title' => $category->name,
            'subtitle' => 'Browse products in ' . $category->name,
            'products' => $products
        ]);
    }

    // Nanti bisa diupdate logicnya berdasarkan jumlah 'sold' dari tabel order_items
    public function trending()
    {
        $products = Product::with('images')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            // ->orderBy('sold_count', 'desc') // Nanti kalau sudah ada fitur penjualan
            ->latest()
            ->paginate(12);

        return view('page.produk.index', [
            'title' => 'Trending Now',
            'subtitle' => 'Most popular items this week',
            'products' => $products
        ]);
    }
}
