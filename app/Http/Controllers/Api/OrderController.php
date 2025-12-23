<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang sedang login.
     */
    public function index(Request $request)
    {
        // Ambil order milik user yang sedang login
        // Diurutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                    ->with(['items.product']) // Load relasi items & product (sesuaikan nama relasi di Model Order kamu)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List pesanan berhasil diambil',
            ],
            'data' => $orders
        ]);
    }

    /**
     * Menampilkan detail pesanan spesifik.
     */
    public function show($id)
    {
        // Cari order berdasarkan ID (atau order_number) & pastikan milik user
        $order = Order::where('user_id', Auth::id())
                    ->where(function($query) use ($id) {
                        $query->where('id', $id)
                              ->orWhere('order_number', $id);
                    })
                    ->with(['items.product', 'address']) // Load detail item & alamat
                    ->first();

        if (!$order) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Pesanan tidak ditemukan',
                ],
                'data' => null
            ], 404);
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Detail pesanan berhasil diambil',
            ],
            'data' => $order
        ]);
    }
}