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
                <p class="text-2xl font-bold">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Processing</p>
                <p class="text-2xl font-bold">{{ $stats['processing'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Shipped</p>
                <p class="text-2xl font-bold">{{ $stats['shipped'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Completed</p>
                <p class="text-2xl font-bold">{{ $stats['delivered'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-col md:flex-row gap-4">
                
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID or Name..." 
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <select name="status" onchange="this.form.submit()" class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black cursor-pointer">
                    <option value="All Status" {{ request('status') == 'All Status' ? 'selected' : '' }}>All Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered/Completed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select name="sort" onchange="this.form.submit()" class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black cursor-pointer">
                    <option value="Latest" {{ request('sort') == 'Latest' ? 'selected' : '' }}>Latest</option>
                    <option value="Oldest" {{ request('sort') == 'Oldest' ? 'selected' : '' }}>Oldest</option>
                </select>

                @if(request()->has('search') || request()->has('status'))
                    <a href="{{ route('admin.orders') }}" class="px-4 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition text-center">Reset</a>
                @endif
            </form>
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
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Update Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50" x-data="{ currentStatus: '{{ $order->status }}', isLoading: false }">
                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $order->order_number }}
                                    <div class="text-[10px] text-gray-400 font-normal mt-0.5 uppercase">{{ $order->courier }} - {{ $order->service }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-sm">{{ $order->recipient_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <p class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </td>
                                
                                {{-- PAYMENT STATUS (Badge Warna-warni) --}}
                                <td class="px-6 py-4">
                                    @php
                                        $payClass = match($order->status) {
                                            'paid', 'processing', 'shipped', 'delivered', 'completed' => 'bg-green-100 text-green-700',
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'cancelled', 'failed', 'expired' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                        
                                        // Label untuk payment status (Beda dengan status pengiriman)
                                        $payLabel = ($order->status == 'pending') ? 'Unpaid' : (in_array($order->status, ['cancelled', 'failed']) ? 'Failed' : 'Paid');
                                    @endphp
                                    <span class="px-3 py-1 text-xs rounded-full font-bold {{ $payClass }}">
                                        {{ $payLabel }}
                                    </span>
                                </td>

                                {{-- UPDATE STATUS DROPDOWN (AJAX AlpineJS) --}}
                                <td class="px-6 py-4">
                                    <div class="relative">
                                        <select x-model="currentStatus" 
                                                @change="
                                                    isLoading = true;
                                                    fetch('/admin/orders/{{ $order->id }}/status', {
                                                        method: 'PATCH',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        body: JSON.stringify({ status: currentStatus })
                                                    })
                                                    .then(res => {
                                                        if(res.ok) alert('Status updated!');
                                                        else alert('Failed to update.');
                                                    })
                                                    .finally(() => isLoading = false);
                                                "
                                                class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-black cursor-pointer shadow-sm disabled:opacity-50"
                                                :disabled="isLoading">
                                            
                                            <option value="pending">Pending</option>
                                            <option value="paid">Paid / Processing</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                        
                                        <div x-show="isLoading" class="absolute right-[-20px] top-2">
                                            <svg class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- ACTION BUTTON (Link ke Detail) --}}
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-600 hover:text-black inline-block" title="View Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        <p class="text-lg font-medium">Belum ada pesanan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection