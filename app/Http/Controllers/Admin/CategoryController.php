<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:categories,name'
    //     ]);

    //     Category::create([
    //         'name' => $request->name,
    //         'slug' => Str::slug($request->name)
    //     ]);

    //     return back()->with('success', 'Category added successfully!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            // Validasi gambar kategori (opsional, max 5MB)
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        // Handle Upload Gambar Kategori
        if ($request->hasFile('image')) {
            // Simpan di folder public/categories
            $path = $request->file('image')->store('categories', 'public');
            $data['image_path'] = $path;
        }

        Category::create($data);

        // Ubah redirectnya agar kembali ke halaman produk dan buka modal kategori lagi (opsional, biar UX enak)
        return redirect()->route('admin.products')->with('success', 'Category created successfully!');
    }
}
