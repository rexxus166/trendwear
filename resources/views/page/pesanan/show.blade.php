@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <div class="max-w-5xl mx-auto bg-gray-50/50 min-h-screen relative lg:pt-8 lg:px-8">

        {{-- Header dengan Tombol Back --}}
        <div
            class="px-5 py-4 sticky top-0 z-50 border-b lg:border-none border-gray-200/50 backdrop-blur-md bg-white/80 lg:bg-transparent">
            <div class="flex items-center gap-4">
                <a href="{{ route('pesanan') }}"
                    class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-lg lg:text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                    <p class="text-xs lg:text-sm text-gray-500">ID: #{{ $order->invoice_number ?? $order->order_number }}
                    </p>
                </div>
            </div>
        </div>

        <div class="px-5 pb-20 lg:px-0 mt-4 space-y-6">

            {{-- Section 1: Status & Info Dasar --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-100 pb-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Pemesanan</p>
                        <p class="font-bold text-gray-900">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>

                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'paid' => 'bg-blue-100 text-blue-700',
                            'processing' => 'bg-indigo-100 text-indigo-700',
                            'shipped' => 'bg-purple-100 text-purple-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                        $bgStatus = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-bold {{ $bgStatus }} capitalize">
                        {{ $order->status }}
                    </span>
                </div>

                {{-- Info Pengiriman (Sesuaikan nama kolom di databasemu) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Alamat Pengiriman</h3>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            <p class="font-semibold text-black">{{ $order->recipient_name ?? $order->user->name }}</p>
                            <p>{{ $order->phone_number ?? $order->user->phone }}</p>
                            <p class="mt-1">{{ $order->address_full ?? 'Alamat tidak tersedia' }}</p>
                            {{-- <p>{{ $order->district }}, {{ $order->city }}, {{ $order->province }}</p> --}}
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Info Kurir</h3>
                        <div class="text-sm text-gray-600">
                            <p>Kurir: <span class="font-medium text-black uppercase">{{ $order->courier ?? '-' }}</span></p>
                            <p>Layanan: <span class="font-medium text-black">{{ $order->service ?? '-' }}</span>
                            </p>
                            @if ($order->resi_number)
                                <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                    <p class="text-xs text-gray-500">No. Resi:</p>
                                    <p class="font-mono font-bold text-gray-900 select-all">{{ $order->resi_number }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Daftar Barang --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-4">Daftar Produk</h3>
                <div class="space-y-6">
                    @foreach ($order->items as $item)
                        <div class="flex gap-4">
                            <div
                                class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200">
                                @if ($item->product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->file_path) }}"
                                        class="w-full h-full object-cover" alt="Product">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Img
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 line-clamp-2">{{ $item->product->name }}</h4>
                                <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                    <span>{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                {{-- Jika ada varian (size/color) bisa ditampilkan disini --}}
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">
                                    Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Section 3: Rincian Pembayaran --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8">
                <h3 class="font-bold text-gray-900 mb-4">Rincian Pembayaran</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Total Harga Barang</span>
                        <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span>Rp{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                    </div>
                    {{-- <div class="flex justify-between text-gray-600">
                    <span>Biaya Layanan</span>
                    <span>Rp{{ number_format($order->service_fee ?? 0, 0, ',', '.') }}</span>
                </div> --}}
                    <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between items-center">
                        <span class="font-bold text-gray-900 text-base">Total Belanja</span>
                        <span
                            class="font-bold text-gray-900 text-xl">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
