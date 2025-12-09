<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil produk beserta relasi kategori dan gambar
        $products = Product::with(['category', 'images'])->latest()->paginate(10);
        $categories = Category::all(); // Untuk dropdown di modal

        return view('page.admin.produk.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:10240' // Max 10MB per file
        ]);

        DB::transaction(function () use ($request) {
            // 2. Simpan Data Produk
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'description' => $request->description,
                'status' => $request->stock > 0 ? 'active' : 'out_of_stock',
            ]);

            // 3. Handle Upload Multiple Files
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    // Simpan file ke storage/app/public/products
                    $path = $file->store('products', 'public');

                    // Tentukan tipe (image atau video)
                    $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                    ProductImage::create([
                        'product_id' => $product->id,
                        'file_path' => $path,
                        'file_type' => $type
                    ]);
                }
            }
        });

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    // Tambahkan method ini di paling bawah class
    public function update(Request $request, Product $product)
    {
        // 1. Validasi (Sedikit beda, SKU harus ignore ID produk ini sendiri)
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            // Unique SKU kecuali punya diri sendiri
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:10240'
        ]);

        DB::transaction(function () use ($request, $product) {
            // 2. Update Data Produk
            $product->update([
                'name' => $request->name,
                // Slug opsional mau diupdate atau tidak, biasanya biarkan saja atau update jika nama berubah
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'description' => $request->description,
                'status' => $request->stock > 0 ? 'active' : 'out_of_stock',
            ]);

            // 3. Handle Tambah Media Baru (Opsional)
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('products', 'public');
                    $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                    ProductImage::create([
                        'product_id' => $product->id,
                        'file_path' => $path,
                        'file_type' => $type
                    ]);
                }
            }
        });

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);

        if (Storage::disk('public')->exists($image->file_path)) {
            Storage::disk('public')->delete($image->file_path);
        }
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted']);
    }
}
