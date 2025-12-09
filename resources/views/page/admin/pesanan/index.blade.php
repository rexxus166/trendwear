@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-1">Orders</h1>
                <p class="text-gray-600">Manage customer orders and fulfillment</p>
            </div>
            <button class="px-6 py-3 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium">
                Export Orders
            </button>
        </div>
    </header>

    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Pending</p>
                <p class="text-2xl font-bold">48</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Processing</p>
                <p class="text-2xl font-bold">127</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Shipped</p>
                <p class="text-2xl font-bold">234</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Delivered</p>
                <p class="text-2xl font-bold">834</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Search orders..." class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
                <select class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Shipped</option>
                    <option>Delivered</option>
                </select>
                <select class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    <option>Last 30 days</option>
                    <option>Last 7 days</option>
                    <option>Today</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">#TW742891</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-sm">Alex Johnson</p>
                                    <p class="text-xs text-gray-500">alex.j@email.com</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">Dec 9, 2025</td>
                            <td class="px-6 py-4 text-sm font-semibold">Rp 2.522.000</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Paid</span>
                            </td>
                            <td class="px-6 py-4">
                                <select class="px-3 py-1 bg-gray-50 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-black">
                                    <option>Pending</option>
                                    <option>Processing</option>
                                    <option>Shipped</option>
                                    <option selected>Delivered</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">#TW742890</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-sm">Sarah Mitchell</p>
                                    <p class="text-xs text-gray-500">sarah.m@email.com</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">Dec 9, 2025</td>
                            <td class="px-6 py-4 text-sm font-semibold">Rp 899.000</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Paid</span>
                            </td>
                            <td class="px-6 py-4">
                                <select class="px-3 py-1 bg-gray-50 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-black">
                                    <option>Pending</option>
                                    <option>Processing</option>
                                    <option selected>Shipped</option>
                                    <option>Delivered</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">#TW742889</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-sm">Michael Chen</p>
                                    <p class="text-xs text-gray-500">michael.c@email.com</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">Dec 8, 2025</td>
                            <td class="px-6 py-4 text-sm font-semibold">Rp 1.299.000</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Paid</span>
                            </td>
                            <td class="px-6 py-4">
                                <select class="px-3 py-1 bg-gray-50 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-black">
                                    <option>Pending</option>
                                    <option selected>Processing</option>
                                    <option>Shipped</option>
                                    <option>Delivered</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">#TW742888</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-sm">Emma Davis</p>
                                    <p class="text-xs text-gray-500">emma.d@email.com</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">Dec 8, 2025</td>
                            <td class="px-6 py-4 text-sm font-semibold">Rp 649.000</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-600 text-xs rounded-full font-medium">Unpaid</span>
                            </td>
                            <td class="px-6 py-4">
                                <select class="px-3 py-1 bg-gray-50 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-black">
                                    <option selected>Pending</option>
                                    <option>Processing</option>
                                    <option>Shipped</option>
                                    <option>Delivered</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <p class="text-sm text-gray-600">Showing 1-4 of 1,243 orders</p>
                <div class="flex gap-2">
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Previous</button>
                    <button class="px-3 py-2 bg-black text-white rounded-lg">1</button>
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection