@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-6 sticky top-0 z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold mb-1 text-gray-900">Dashboard</h1>
                <p class="text-gray-500 text-sm">Selamat datang kembali, {{ Auth::user()->name }}! Berikut kabar terbaru hari ini.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.store') }}" class="px-5 py-2.5 bg-black text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200 flex items-center gap-2">
                    <span>+</span> New Product
                </a>
            </div>
        </div>
    </header>

    <div class="p-8 max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full">Active</span>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Products</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Customers</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-lg mb-6">Sales Overview</h3>
                <div class="h-64 flex items-end gap-3 md:gap-6 px-2">
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 45%"></div>
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 60%"></div>
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 35%"></div>
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 75%"></div>
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 55%"></div>
                    <div class="flex-1 bg-black rounded-t-lg relative group" style="height: 85%"></div>
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 40%"></div>
                </div>
                <div class="flex justify-between mt-4 text-xs font-medium text-gray-400">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg">Top Products</h3>
                    <a href="{{ route('admin.products') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">View All</a>
                </div>
                <div class="space-y-5">
                    @forelse($topProducts as $product)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-400 font-bold">
                                {{ substr($product->product_name, 0, 2) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-900 truncate">{{ $product->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->total_sold }} sold</p>
                            </div>
                            <p class="font-bold text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada penjualan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-lg">Recent Orders</h3>
                <a href="{{ route('admin.orders') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">View All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $order->recipient_name ?? ($order->user->name ?? 'Guest') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($order->status) {
                                            'paid', 'processing', 'shipped', 'delivered', 'completed' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'cancelled', 'failed' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection