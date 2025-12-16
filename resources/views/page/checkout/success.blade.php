@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center bg-white">
        <div class="max-w-md w-full mx-auto px-5 py-12 text-center">

            <div class="relative mb-8 group">
                <div class="w-32 h-32 mx-auto bg-green-50 rounded-full flex items-center justify-center relative z-10">
                    <svg class="w-16 h-16 text-green-500 animate-[bounce_1s_infinite]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="absolute inset-0 w-32 h-32 mx-auto bg-green-400 rounded-full animate-ping opacity-20"></div>
            </div>

            <h1 class="text-3xl font-bold mb-3 text-gray-900">Pembayaran Berhasil!</h1>
            <p class="text-gray-500 mb-8 leading-relaxed">
                Terima kasih telah berbelanja di TrendWear.<br>Pesananmu sudah kami terima dan akan segera diproses.
            </p>

            <div class="mb-8 p-6 bg-gray-50 border border-gray-100 rounded-3xl text-left shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">No. Pesanan</span>
                    <span class="font-bold tracking-wide text-gray-900 font-mono">
                        #{{ $order->invoice_number ?? ($order->order_number ?? $order->id) }}
                    </span>
                </div>

                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Metode Pembayaran</span>
                    <span class="font-bold text-gray-900 uppercase">{{ $order->payment_type ?? 'Midtrans' }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-gray-500 text-sm">Total Bayar</span>
                    <span class="font-bold text-green-600 text-lg">Rp
                        {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="space-y-3">
                {{-- Tombol Lihat Pesanan (Ke Halaman Detail Order) --}}
                <a href="{{ route('pesanan', $order->id) }}"
                    class="w-full px-6 py-4 bg-black text-white rounded-2xl hover:bg-gray-800 transition-transform active:scale-95 flex items-center justify-center gap-2 font-bold shadow-xl shadow-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Lihat Pesanan Saya
                </a>

                {{-- Tombol Lanjut Belanja --}}
                <a href="{{ route('shop') }}"
                    class="w-full px-6 py-4 border-2 border-gray-100 rounded-2xl hover:border-black hover:text-black text-gray-500 transition-colors flex items-center justify-center gap-2 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Lanjut Belanja
                </a>
            </div>

            <p class="text-xs text-gray-400 mt-8">Bukti pembayaran otomatis dikirim ke email kamu.</p>
        </div>
    </div>
@endsection
