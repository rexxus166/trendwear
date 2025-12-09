@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-6 sticky top-0 z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold mb-1 text-gray-900">Dashboard</h1>
                <p class="text-gray-500 text-sm">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                <button class="px-5 py-2.5 bg-black text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                    + New Product
                </button>
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
                    <span class="text-xs font-bold px-2.5 py-1 bg-green-100 text-green-700 rounded-full">+12.5%</span>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-900">Rp 45.6M</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full">+8.2%</span>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900">1,243</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full">Active</span>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Products</p>
                <p class="text-2xl font-bold text-gray-900">856</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-orange-100 text-orange-700 rounded-full">+15.3%</span>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Customers</p>
                <p class="text-2xl font-bold text-gray-900">2,847</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-lg mb-6">Sales Overview</h3>
                <div class="h-64 flex items-end gap-3 md:gap-6 px-2">
                    <div class="flex-1 bg-gray-100 hover:bg-black transition-colors rounded-t-lg relative group" style="height: 45%">
                        <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-xs py-1 px-2 rounded transition-opacity">45%</div>
                    </div>
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
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">View All</a>
                </div>
                <div class="space-y-5">
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1648483098902-7af8f711498f?w=100&h=100&fit=crop" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 truncate">Essential White Tee</p>
                            <p class="text-xs text-gray-500">234 sold this week</p>
                        </div>
                        <p class="font-bold text-sm text-gray-900">Rp 299k</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1588011025378-15f4778d2558?w=100&h=100&fit=crop" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 truncate">Classic Black Jacket</p>
                            <p class="text-xs text-gray-500">187 sold this week</p>
                        </div>
                        <p class="font-bold text-sm text-gray-900">Rp 899k</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1631984564919-1f6b2313a71c?w=100&h=100&fit=crop" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 truncate">Urban Sneakers</p>
                            <p class="text-xs text-gray-500">156 sold this week</p>
                        </div>
                        <p class="font-bold text-sm text-gray-900">Rp 1.2M</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-lg">Recent Orders</h3>
                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">View All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#TW742891</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Alex Johnson</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Essential White Tee</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp 299.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Delivered
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#TW742890</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Sarah Mitchell</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Black Jacket</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp 899.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Shipped
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#TW742889</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Michael Chen</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Urban Sneakers</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp 1.299.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Processing
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection