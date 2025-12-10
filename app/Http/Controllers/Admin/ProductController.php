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
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->paginate(10);
        $categories = Category::all();
        return view('page.admin.produk.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
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
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:10240',
            // Validasi Array Harga
            'variants_prices_options' => 'nullable|array',
            'variants_prices_sizes' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {

            // --- LOGIC VARIAN HARGA BARU ---
            $variantsData = [];

            // 1. Handle Options Price
            $optionsArray = $request->options ? array_map('trim', explode(',', $request->options)) : [];
            foreach ($optionsArray as $opt) {
                // Ambil harga dari input variants_prices_options, default ke base price
                $price = isset($request->variants_prices_options[$opt]) ? $request->variants_prices_options[$opt] : $request->price;
                $variantsData[] = [
                    'type' => 'option', // Penanda tipe
                    'key' => $opt,      // Nama varian (misal: "1 Stel + Dasi")
                    'price' => $price
                ];
            }

            // 2. Handle Sizes Price
            $sizesArray = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : [];
            foreach ($sizesArray as $size) {
                // Ambil harga dari input variants_prices_sizes, default ke base price
                $price = isset($request->variants_prices_sizes[$size]) ? $request->variants_prices_sizes[$size] : $request->price;
                $variantsData[] = [
                    'type' => 'size',
                    'key' => $size,
                    'price' => $price
                ];
            }

            $colorsArray = $request->colors ? array_map('trim', explode(',', $request->colors)) : [];

            // 3. Simpan Produk
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'options' => $optionsArray,
                'sizes' => $sizesArray,
                'colors' => $colorsArray,
                'variants_data' => $variantsData, // Simpan JSON lengkap
                'sku' => $request->sku,
                'description' => $request->description,
                'status' => $request->stock > 0 ? 'active' : 'out_of_stock',
            ]);

            // 4. Media Upload
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('products', 'public');
                    $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                    ProductImage::create(['product_id' => $product->id, 'file_path' => $path, 'file_type' => $type]);
                }
            }
        });

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function update(Request $request, Product $product)
    {
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
            'status' => 'required|in:active,draft,out_of_stock',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:10240',
            'variants_prices_options' => 'nullable|array',
            'variants_prices_sizes' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $product) {

            // --- LOGIC VARIAN HARGA UPDATE ---
            $variantsData = [];

            // 1. Handle Options
            $optionsArray = $request->options ? array_map('trim', explode(',', $request->options)) : [];
            foreach ($optionsArray as $opt) {
                $price = isset($request->variants_prices_options[$opt]) ? $request->variants_prices_options[$opt] : $request->price;
                $variantsData[] = ['type' => 'option', 'key' => $opt, 'price' => $price];
            }

            // 2. Handle Sizes
            $sizesArray = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : [];
            foreach ($sizesArray as $size) {
                $price = isset($request->variants_prices_sizes[$size]) ? $request->variants_prices_sizes[$size] : $request->price;
                $variantsData[] = ['type' => 'size', 'key' => $size, 'price' => $price];
            }

            $colorsArray = $request->colors ? array_map('trim', explode(',', $request->colors)) : [];

            // 3. Update Produk
            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'options' => $optionsArray,
                'sizes' => $sizesArray,
                'colors' => $colorsArray,
                'variants_data' => $variantsData, // Update JSON
                'sku' => $request->sku,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            // 4. Media Upload
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('products', 'public');
                    $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                    ProductImage::create(['product_id' => $product->id, 'file_path' => $path, 'file_type' => $type]);
                }
            }
        });

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
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
