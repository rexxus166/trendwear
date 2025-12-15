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
}
