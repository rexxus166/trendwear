@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <section class="relative h-80 lg:h-[500px] overflow-hidden lg:m-6 lg:rounded-3xl shadow-sm group">
        <img src="https://images.unsplash.com/photo-1614975059536-2df3b404d53c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1920" 
             alt="Hero" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent lg:bg-gradient-to-r lg:from-black/90 lg:via-black/40 lg:to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-20 text-white lg:w-2/3 lg:top-0 lg:flex lg:flex-col lg:justify-center">
            <div class="animate-fade-in-up">
                <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-xs lg:text-sm mb-4 border border-white/30 tracking-wider uppercase font-medium">Winter Collection 2025</span>
                <h2 class="text-4xl lg:text-7xl font-bold mb-6 leading-tight">Street <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">Essentials</span></h2>
                <p class="text-gray-200 mb-8 text-lg lg:text-xl max-w-lg leading-relaxed">Define your style with our curated pieces designed for the modern urban explorer.</p>
                <button class="px-8 py-4 bg-white text-black rounded-full inline-flex items-center gap-3 hover:bg-gray-100 transition-all font-bold shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:scale-105 active:scale-95">
                    Shop Collection
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </button>
            </div>
        </div>
    </section>

    <section class="px-5 py-8 lg:px-12 lg:py-16">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold tracking-tight">Shop by Category</h3>
            <a href="#" class="text-sm font-semibold text-gray-500 hover:text-black flex items-center gap-2 group transition-colors">
                View All <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors"><svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-8">
            @forelse($categories as $category)
                <button class="group relative h-48 lg:h-64 bg-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition-all text-left">
                    <div class="absolute inset-0 bg-gray-200 transition-colors group-hover:bg-gray-300"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/30 rounded-full -translate-y-10 translate-x-10 transition-transform group-hover:scale-150 duration-700 blur-2xl"></div>
                    
                    <div class="absolute inset-0 p-6 flex flex-col justify-end z-10">
                        <h4 class="text-xl font-bold mb-1 group-hover:translate-x-1 transition-transform">{{ $category->name }}</h4>
                        <p class="text-sm text-gray-500 group-hover:translate-x-1 transition-transform delay-75">{{ $category->products_count }} items</p>
                    </div>
                    
                    <div class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center opacity-0 -translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </button>
            @empty
                <div class="col-span-full text-center text-gray-500 py-10">No categories found.</div>
            @endforelse
        </div>
    </section>

    <section class="px-5 py-8 lg:px-12">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold tracking-tight">Trending Now</h3>
            <a href="#" class="text-sm font-semibold text-gray-500 hover:text-black flex items-center gap-2 group transition-colors">
                See More <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors"><svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10 lg:gap-y-12">
            
            @forelse($trendingProducts as $product)
                <a href="{{ route('product.detail', $product->slug) }}" class="group cursor-pointer block">
                    
                    <div class="relative mb-4 overflow-hidden rounded-2xl bg-gray-100 aspect-[3/4]">
                        
                        @if($product->images->isNotEmpty())
                            @if($product->images->first()->file_type == 'video')
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        @if($product->stock < 10)
                            <span class="absolute top-3 left-3 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">
                                Limited
                            </span>
                        @elseif($loop->iteration <= 2) 
                            <span class="absolute top-3 left-3 px-3 py-1 bg-black text-white text-xs font-bold rounded-full shadow-sm">
                                Best Seller
                            </span>
                        @endif
                        
                        <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm transition-all hover:scale-110 hover:text-red-500 z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>

                        <div class="absolute bottom-4 left-4 right-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 hidden lg:block">
                            <button class="w-full py-3 bg-white/95 backdrop-blur text-black font-bold rounded-xl hover:bg-black hover:text-white transition-colors shadow-lg">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-base font-medium text-gray-900 group-hover:text-gray-600 transition-colors truncate">
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
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <p class="text-gray-500 font-medium">No products available at the moment.</p>
                    <p class="text-sm text-gray-400">Please check back later.</p>
                </div>
            @endforelse

        </div>
    </section>

    <section class="mx-5 my-8 lg:mx-12 lg:my-16">
        <div class="bg-gradient-to-br from-black to-gray-800 rounded-3xl p-8 lg:p-16 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between shadow-2xl">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-32 translate-x-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-20 -translate-x-20 blur-2xl"></div>
            <div class="relative z-10 max-w-xl text-center md:text-left">
                <p class="text-white/70 text-sm lg:text-base mb-3 font-semibold tracking-widest uppercase">Limited Time Offer</p>
                <h3 class="text-3xl lg:text-5xl font-bold mb-4 leading-tight">Get 30% Off Everything</h3>
                <p class="text-white/80 text-sm lg:text-lg mb-8 leading-relaxed">Join the TrendWear community today. Use code <span class="text-white font-mono bg-white/20 px-2 py-1 rounded mx-1">FIRST30</span> at checkout.</p>
                <button class="w-full md:w-auto px-10 py-4 bg-white text-black rounded-full text-base font-bold hover:bg-gray-100 transition-all hover:scale-105 shadow-lg active:scale-95">Claim Offer Now</button>
            </div>
        </div>
    </section>

@endsection