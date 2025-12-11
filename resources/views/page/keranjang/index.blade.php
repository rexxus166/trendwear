@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

    <div
        class="fixed top-0 left-0 right-0 bg-white z-50 border-b border-gray-100 px-4 h-16 flex items-center gap-4 lg:hidden">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-black">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-lg font-bold text-gray-900">Keranjang Belanja <span
                class="text-gray-400 text-sm font-normal">({{ $carts->count() }})</span></h1>
    </div>

    <div class="px-0 sm:px-5 py-8 lg:px-12 max-w-7xl mx-auto min-h-[60vh] pt-20 lg:pt-8 pb-32 lg:pb-8">

        <h1 class="text-3xl font-bold mb-8 hidden lg:block">Ringkasan Pemesanan</h1>

        @if ($carts->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative">

                <div class="lg:col-span-2 space-y-4 sm:space-y-6 px-4 sm:px-0">

                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                            class="bg-green-100 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 mb-4 text-sm sm:text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @php $subtotal = 0; @endphp

                    @foreach ($carts as $cart)
                        @php
                            $basePrice = $cart->product->price;
                            $finalUnitPrice = $basePrice;
                            $variantsData = $cart->product->variants_data ?? [];

                            if ($cart->option) {
                                $optData = collect($variantsData)->first(function ($item) use ($cart) {
                                    return isset($item['type']) &&
                                        $item['type'] === 'option' &&
                                        $item['key'] === $cart->option;
                                });
                                if ($optData) {
                                    $finalUnitPrice += $optData['price'] - $basePrice;
                                }
                            }
                            if ($cart->size) {
                                $sizeData = collect($variantsData)->first(function ($item) use ($cart) {
                                    return isset($item['type']) &&
                                        $item['type'] === 'size' &&
                                        $item['key'] === $cart->size;
                                });
                                if ($sizeData) {
                                    $finalUnitPrice += $sizeData['price'] - $basePrice;
                                }
                            }

                            $lineTotal = $finalUnitPrice * $cart->quantity;
                            $subtotal += $lineTotal;
                        @endphp

                        <div
                            class="flex gap-3 sm:gap-6 p-3 sm:p-4 bg-white border border-gray-100 rounded-xl sm:rounded-2xl shadow-sm relative group">

                            <div
                                class="w-24 h-24 sm:w-28 sm:h-28 bg-gray-100 rounded-lg sm:rounded-xl overflow-hidden flex-shrink-0">
                                @if ($cart->product->images->isNotEmpty())
                                    @if ($cart->product->images->first()->file_type == 'video')
                                        <video src="{{ asset('storage/' . $cart->product->images->first()->file_path) }}"
                                            class="w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $cart->product->images->first()->file_path) }}"
                                            alt="{{ $cart->product->name }}" class="w-full h-full object-cover">
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No
                                        Image</div>
                                @endif
                            </div>

                            <div class="flex-1 flex flex-col justify-between w-full">
                                <div>
                                    <div class="flex justify-between items-start gap-2">
                                        <h3 class="text-sm sm:text-lg font-bold text-gray-900 line-clamp-2">
                                            {{ $cart->product->name }}</h3>

                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="flex flex-wrap gap-1 mt-1 mb-2">
                                        @if ($cart->option)
                                            <span
                                                class="px-1.5 py-0.5 rounded text-[10px] sm:text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100 truncate max-w-[100px]">{{ $cart->option }}</span>
                                        @endif
                                        @if ($cart->size)
                                            <span
                                                class="px-1.5 py-0.5 rounded text-[10px] sm:text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">Size:
                                                {{ $cart->size }}</span>
                                        @endif
                                        @if ($cart->color)
                                            <span
                                                class="px-1.5 py-0.5 rounded text-[10px] sm:text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">Color:
                                                {{ $cart->color }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between items-end">
                                    <p class="text-sm sm:text-lg font-bold text-black">Rp
                                        {{ number_format($lineTotal, 0, ',', '.') }}</p>

                                    <div class="flex items-center border border-gray-300 rounded-lg h-7 sm:h-9">
                                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                            @csrf @method('PATCH') <input type="hidden" name="type" value="decrement">
                                            <button type="submit"
                                                class="w-6 sm:w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-l-lg {{ $cart->quantity <= 1 ? 'opacity-50' : '' }}">-</button>
                                        </form>
                                        <div
                                            class="w-8 sm:w-10 h-full flex items-center justify-center text-xs sm:text-sm font-bold border-x border-gray-300 bg-white">
                                            {{ $cart->quantity }}</div>
                                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                            @csrf @method('PATCH') <input type="hidden" name="type" value="increment">
                                            <button type="submit"
                                                class="w-6 sm:w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-r-lg {{ $cart->quantity >= $cart->product->stock ? 'opacity-50' : '' }}">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="hidden lg:block lg:col-span-1">
                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-lg sticky top-24">
                        <h2 class="text-xl font-bold mb-6">Ringkasan Pemesanan</h2>
                        <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                            <div class="flex justify-between text-gray-600"><span>Subtotal</span><span
                                    class="font-medium text-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600"><span>Biaya Pengiriman</span><span
                                    class="text-green-600 font-medium text-sm">Dihitung saat Checkout</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Pajak</span>
                                <span class="font-medium text-black">Rp 0</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-8">
                            <span class="text-lg font-bold">Total</span>
                            <span class="text-2xl font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}"
                            class="w-full py-4 bg-black text-white rounded-xl font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-xl flex items-center justify-center gap-2">
                            Checkout <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:hidden z-50 pb-safe">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500">Total Pembayaran</span>
                            <span class="text-xl font-bold text-black">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}"
                            class="px-8 py-3 bg-red-500 text-white rounded-lg font-bold text-sm hover:bg-red-600 transition-colors shadow-lg active:scale-95 flex-1 max-w-[180px]">
                            Checkout
                        </a>
                    </div>
                </div>

            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center min-h-[50vh] px-4">
                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold mb-2">Keranjang kamu kosong</h2>
                <p class="text-gray-500 mb-8 max-w-sm text-sm sm:text-base">Sepertinya kamu belum menambahkan apapun. Yuk
                    mulai belanja!</p>
                <a href="{{ route('shop') }}"
                    class="px-8 py-3 bg-black text-white rounded-full font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg text-sm sm:text-base">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </div>
@endsection
