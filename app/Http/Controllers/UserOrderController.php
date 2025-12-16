<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        // Ambil order milik user yang sedang login
        // Diurutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->with(['items.product.images'])
            ->latest()
            ->get();

        return view('page.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        // Cari order berdasarkan ID, TAPI pastikan punya user yang sedang login
        $order = Order::where('user_id', Auth::id())
            ->where('order_number', $id)
            ->with(['items.product.images']) // Load items + produk + gambar
            ->firstOrFail(); // Kalau tidak ketemu (atau punya orang lain), tampilkan 404

        return view('page.pesanan.show', compact('order'));
    }
}
