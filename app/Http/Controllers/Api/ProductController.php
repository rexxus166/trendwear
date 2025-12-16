<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru beserta relasi images & category
        $products = Product::with(['images', 'category'])->latest()->get();

        return response()->json([
            'message' => 'List Product',
            'data' => $products
        ]);
    }
}
