@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

        {{-- Header Hasil --}}
        <div class="mb-8">
            <p class="text-sm text-gray-500 mb-1">Hasil pencarian untuk:</p>
            <h1 class="text-3xl font-bold text-gray-900">"{{ $keyword }}"</h1>
            <p class="text-gray-500 mt-2">{{ $products->count() }} produk ditemukan</p>
        </div>

        @if ($products->count() > 0)
            {{-- Grid Produk (Copas style dari halaman Shop kamu) --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
                @foreach ($products as $product)
                    {{-- COMPONENT CARD PRODUK --}}
                    <div class="group relative">
                        <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-3 relative product-card">

                            {{-- Button Wishlist (Code yang udah kita bikin sebelumnya) --}}
                            @php
                                $isWishlisted =
                                    Auth::check() &&
                                    \App\Models\Wishlist::where('user_id', Auth::id())
                                        ->where('product_id', $product->id)
                                        ->exists();
                            @endphp
                            <button onclick="toggleWishlist(event, this, {{ $product->id }})"
                                class="absolute top-3 right-3 w-10 h-10 rounded-full flex items-center justify-center shadow-sm transition-all hover:scale-110 z-10 bg-white group-btn
                            {{ $isWishlisted ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                                <svg class="w-5 h-5 transition-colors duration-300"
                                    fill="{{ $isWishlisted ? 'currentColor' : 'none' }}" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>

                            <a href="{{ route('product.detail', $product->slug) }}">
                                @if ($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->file_path) }}"
                                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                                @endif
                            </a>
                        </div>

                        <a href="{{ route('product.detail', $product->slug) }}">
                            <h3 class="font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm mb-2 truncate">
                                {{ $product->category->name ?? 'Uncategorized' }}</p>
                            <p class="font-bold text-black">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Tampilan Kalau Tidak Ada Hasil --}}
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Produk tidak ditemukan</h2>
                <p class="text-gray-500 max-w-md mx-auto mb-8">
                    Maaf, kami tidak dapat menemukan produk dengan kata kunci "<strong>{{ $keyword }}</strong>". Coba
                    gunakan kata kunci lain.
                </p>
                <a href="{{ route('shop') }}"
                    class="px-8 py-3 bg-black text-white rounded-full font-bold hover:bg-gray-800 transition-transform active:scale-95">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>
@endsection
