@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <section class="relative h-80 lg:h-[500px] overflow-hidden lg:m-6 lg:rounded-3xl shadow-sm group">
        <img src="https://images.unsplash.com/photo-1614975059536-2df3b404d53c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1920"
            alt="Hero" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent lg:bg-gradient-to-r lg:from-black/90 lg:via-black/40 lg:to-transparent">
        </div>

        <div
            class="absolute bottom-0 left-0 right-0 p-8 lg:p-20 text-white lg:w-2/3 lg:top-0 lg:flex lg:flex-col lg:justify-center">
            <div class="animate-fade-in-up">
                <h2 class="text-4xl lg:text-7xl font-bold mb-6 leading-tight">Street <br /><span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">Essentials</span></h2>
                <p class="text-gray-200 mb-8 text-lg lg:text-xl max-w-lg leading-relaxed">Define your style with our curated
                    pieces designed for the modern urban explorer.</p>
                <a href="{{ route('shop') }}"
                    class="px-8 py-4 bg-white text-black rounded-full inline-flex items-center gap-3 hover:bg-gray-100 transition-all font-bold shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:scale-105 active:scale-95">
                    Shop Collection
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section class="px-5 py-8 lg:px-12 lg:py-12">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl lg:text-2xl font-bold tracking-tight text-gray-900">Kategori</h3>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-y-8 gap-x-4">
            @forelse($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}"
                    class="group flex flex-col items-center cursor-pointer">

                    <div
                        class="w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center mb-3 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-md group-hover:border-gray-200 overflow-hidden relative">

                        @if ($category->image_path)
                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="bg-gray-50 w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400 group-hover:text-black transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </div>
                        @endif

                    </div>

                    <h4
                        class="text-xs md:text-sm font-medium text-center text-gray-600 group-hover:text-black transition-colors line-clamp-2 px-1 leading-snug">
                        {{ $category->name }}
                    </h4>

                </a>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8 text-sm">Belum ada kategori.</div>
            @endforelse
        </div>
    </section>

    <section class="px-5 py-8 lg:px-12">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold tracking-tight">Produk Terlaris</h3>
            <a href="{{ route('trending') }}"
                class="text-sm font-semibold text-gray-500 hover:text-black flex items-center gap-2 group transition-colors">
                Lihat Lebih Lanjut<div
                    class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors">
                    <svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10 lg:gap-y-12">

            @forelse($trendingProducts as $product)
                <a href="{{ route('product.detail', $product->slug) }}" class="group cursor-pointer block">

                    <div class="relative mb-4 overflow-hidden rounded-2xl bg-gray-100 aspect-[3/4]">

                        @if ($product->images->isNotEmpty())
                            @if ($product->images->first()->file_type == 'video')
                                <video src="{{ asset('storage/' . $product->images->first()->file_path) }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    autoplay muted loop playsinline>
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $product->images->first()->file_path) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif

                        @if ($product->stock < 10)
                            <span
                                class="absolute top-3 left-3 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">
                                Limited
                            </span>
                        @elseif($loop->iteration <= 2)
                            <span
                                class="absolute top-3 left-3 px-3 py-1 bg-black text-white text-xs font-bold rounded-full shadow-sm">
                                Best Seller
                            </span>
                        @endif

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
                    </div>

                    <div>
                        <h4
                            class="text-base font-medium text-gray-900 group-hover:text-gray-600 transition-colors truncate">
                            {{ $product->name }}
                        </h4>
                        <p class="text-lg font-bold mt-1 text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Tidak ada produk yang tersedia saat ini.</p>
                    <p class="text-sm text-gray-400">Silahkan cek kembali nanti.</p>
                </div>
            @endforelse

        </div>
    </section>

@endsection
