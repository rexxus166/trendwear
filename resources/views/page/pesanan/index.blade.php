@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="max-w-5xl mx-auto bg-gray-50/50 min-h-screen relative lg:pt-8 lg:px-8">

        <div class="px-5 py-4 lg:hidden sticky top-0 z-50 border-b border-gray-200/50 backdrop-blur-md bg-white/80">
            <div class="flex items-center justify-between">
                <a href="{{ route('profile.edit') }}"
                    class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-900">Pesanan Saya</h1>
                <div class="w-10"></div>
            </div>
        </div>

        <div class="hidden lg:flex items-center gap-4 mb-8">
            <a href="{{ route('profile.edit') }}"
                class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
                <p class="text-gray-500 text-sm mt-1">Lacak status dan riwayat belanjaanmu di sini.</p>
            </div>
        </div>

        <div class="px-5 pb-20 lg:px-0">
            @forelse ($orders as $order)
                <div
                    class="bg-white rounded-2xl p-5 mb-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">

                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 pb-4 mb-4 gap-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">No. Pesanan</p>
                                <p class="text-sm font-bold text-gray-900">
                                    #{{ $order->invoice_number ?? $order->order_number }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-3">
                            <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</span>

                            {{-- Logika Badge Status (Sesuaikan dengan value di databasemu) --}}
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'paid' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'processing' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                    'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                ];
                                $classes = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $classes }} capitalize">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex gap-4">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200">
                                    {{-- LOGIC BARU: Cek relasi images seperti di keranjang --}}
                                    @if ($item->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->file_path) }}"
                                            class="w-full h-full object-cover" alt="{{ $item->product->name }}">
                                    @else
                                        {{-- Fallback jika tidak ada gambar --}}
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gray-50 text-xs text-gray-400">
                                            No Img
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item->product->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }} barang x
                                        Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="mt-5 pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-500">Total Belanja</p>
                            <p class="text-lg font-bold text-gray-900">
                                Rp{{ number_format($order->grand_total, 0, ',', '.') }}</p>
                        </div>

                        {{-- Tombol Detail / Bayar --}}
                        @if ($order->status == 'pending')
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 bg-black text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                                Bayar Sekarang
                            </button>
                        @else
                            <a href="{{ route('orders.show', $order->order_number) }}"
                                class="w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors inline-block text-center">
                                Lihat Detail
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada pesanan</h3>
                    <p class="text-gray-500 mt-2 mb-6 max-w-xs">Yuk mulai belanja dan temukan outfit favoritmu di TrendWear!
                    </p>
                    <a href="{{ route('shop') }}"
                        class="px-6 py-3 bg-black text-white font-bold rounded-xl hover:scale-105 transition-transform">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
