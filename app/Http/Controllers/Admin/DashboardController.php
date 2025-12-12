<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk DB::raw

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan
        $totalRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered', 'completed'])
            ->sum('grand_total');

        // 2. Total Order
        $totalOrders = Order::count();

        // 3. Total Produk Aktif
        $totalProducts = Product::where('status', 'active')->count();

        // 4. Total Customer (PERBAIKAN DI SINI)
        // Kita hitung user yang kolom role-nya adalah 'user'
        $totalCustomers = User::where('role', 'user')->count();

        // 5. Recent Orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // 6. Top Products
        $topProducts = \App\Models\OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'), 'price')
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid', 'processing', 'shipped', 'delivered', 'completed']);
            })
            ->groupBy('product_name', 'price')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();

        return view('page.admin.dashboard.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'topProducts'
        ));
    }
}
