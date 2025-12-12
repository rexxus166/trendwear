@extends('layouts.admin')

@section('title', 'Order Detail #' . $order->order_number)

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-6 sticky top-0 z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders') }}" class="p-2 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold mb-1 flex items-center gap-3">
                        Order #{{ $order->order_number }}
                        @php
                            $statusClass = match($order->status) {
                                'paid', 'processing', 'shipped', 'delivered', 'completed' => 'bg-green-100 text-green-700 border-green-200',
                                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'cancelled', 'failed', 'expired' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="px-3 py-1 text-xs rounded-full font-bold border {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h1>
                    <p class="text-gray-500 text-sm">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button onclick="window.print()" class="px-4 py-2 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2 font-medium text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2-4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Invoice
                </button>
            </div>
        </div>
    </header>

    <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="font-bold text-gray-800">Order Items ({{ $order->items->count() }})</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="p-6 flex gap-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0">
                                    @if($item->product && $item->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->file_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="font-bold text-gray-900 text-sm md:text-base">{{ $item->product_name }}</h4>
                                        <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    @if($item->variant_info)
                                        <div class="inline-block px-2 py-1 bg-gray-100 rounded text-xs text-gray-600 mb-2">
                                            {{ $item->variant_info }}
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between items-end text-sm text-gray-500">
                                        <p>Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }} pcs</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Shipping Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Courier Service</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 uppercase">{{ $order->courier }} - {{ $order->service }}</p>
                                    <p class="text-sm text-gray-500">Weight: {{ $order->total_weight }} gram</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Tracking Number (Resi)</p>
                            <p class="text-gray-400 italic text-sm">Not updated yet</p> 
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Customer Details</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-sm">
                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Contact Info</p>
                            <p class="text-sm text-gray-800">{{ $order->phone_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold mb-1">Shipping Address</p>
                            <p class="text-sm text-gray-800 leading-relaxed">
                                <span class="font-bold block mb-1">{{ $order->recipient_name }}</span>
                                {{ $order->address_full }}<br>
                                {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Payment Summary</h3>
                    <div class="space-y-3 text-sm border-b border-gray-100 pb-4 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping Cost</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Service Fee</span>
                            <span>Rp 0</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900">Total</span>
                        <span class="font-bold text-lg text-black">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection