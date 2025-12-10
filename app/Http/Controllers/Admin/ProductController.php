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
use Illuminate\Validation\Rule; // Tambahkan ini untuk validasi unique ignore ID

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        // Ambil produk beserta relasi kategori dan gambar
        $products = Product::with(['category', 'images'])->latest()->paginate(10);
        $categories = Category::all(); // Untuk dropdown di modal

        return view('page.admin.produk.index', compact('products', 'categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'options' => 'nullable|string',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            // Validasi file (gambar/video), support jpg, png, webp, mp4, mov. Max 10MB.
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:10240'
        ]);

        DB::transaction(function () use ($request) {
            // Konversi String "S,M,L" menjadi Array ["S", "M", "L"]
            $optionsArray = $request->options ? array_map('trim', explode(',', $request->options)) : [];
            $sizesArray = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : [];
            $colorsArray = $request->colors ? array_map('trim', explode(',', $request->colors)) : [];
            // 2. Simpan Data Produk Utama
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'options' => $optionsArray,
                'sizes' => $sizesArray,
                'colors' => $colorsArray,
                'sku' => $request->sku,
                'description' => $request->description,
                // Status otomatis: Jika stok > 0 maka active, jika 0 maka out_of_stock
                'status' => $request->stock > 0 ? 'active' : 'out_of_stock',
            ]);

            // 3. Handle Upload Multiple Files (Gambar/Video)
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    // Simpan file ke storage/app/public/products
                    $path = $file->store('products', 'public');

                    // Deteksi tipe file (image atau video)
                    $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                    // Simpan info file ke tabel product_images
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

    /**
     * Mengupdate data produk yang sudah ada.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi Update
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'options' => 'nullable|string',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'sku' => ['required', 'string', Rule::unique('products', 'sku')->ignore($product->id)],
            'description' => 'nullable|string',
            'status' => 'required|in:active,draft,out_of_stock', // Validasi status manual dari user
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:10240'
        ]);

        DB::transaction(function () use ($request, $product) {
            // 2. Update Data Produk
            $product->update([
                'name' => $request->name,
                // Slug opsional: Update jika nama berubah (comment jika tidak ingin slug berubah)
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'options' => $request->options,
                'sizes' => $request->sizes,
                'colors' => $request->colors,
                'sku' => $request->sku,
                'description' => $request->description,
                'status' => $request->status, // Status diambil dari input form edit
            ]);

            // 3. Handle Tambah Media Baru (Jika ada upload baru saat edit)
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

    /**
     * Menghapus produk secara permanen (termasuk gambar-gambarnya).
     */
    public function destroy(Product $product)
    {
        // 1. Hapus semua file gambar fisik dari storage
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }
        }

        // 2. Hapus data produk dari database
        // (Tabel product_images otomatis terhapus karena on delete cascade di migration)
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    /**
     * Menghapus SATU gambar spesifik dari produk (via AJAX di Modal Edit).
     */
    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // 1. Hapus file fisik
        if (Storage::disk('public')->exists($image->file_path)) {
            Storage::disk('public')->delete($image->file_path);
        }

        // 2. Hapus record database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted']);
    }
}
