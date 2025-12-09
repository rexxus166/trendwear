@extends('layouts.app')

@section('title', $title)

@section('content')
    
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="px-5 py-12 lg:px-12 max-w-7xl mx-auto text-center">
            <h1 class="text-3xl lg:text-5xl font-bold mb-3">{{ $title }}</h1>
            <p class="text-gray-500">{{ $subtitle }}</p>
        </div>
    </div>

    <div class="px-5 py-12 lg:px-12 max-w-7xl mx-auto min-h-[50vh]">
        
        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach($products as $product)
                    <a href="{{ route('product.detail', $product->slug) }}" class="group cursor-pointer block">
                        
                        <div class="relative mb-4 overflow-hidden rounded-2xl bg-gray-100 aspect-[3/4]">
                            @if($product->images->isNotEmpty())
                                @if($product->images->first()->file_type == 'video')
                                    <video src="{{ asset('storage/' . $product->images->first()->file_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" autoplay muted loop></video>
                                @else
                                    <img src="{{ asset('storage/' . $product->images->first()->file_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif

                            @if($product->stock < 10 && $product->stock > 0)
                                <span class="absolute top-3 left-3 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">Limited</span>
                            @elseif($product->stock == 0)
                                <span class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold tracking-wider">SOLD OUT</span>
                            @endif
                            
                            <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm transition-all hover:scale-110 hover:text-red-500 z-10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>

                            @if($product->stock > 0)
                            <div class="absolute bottom-4 left-4 right-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 hidden lg:block">
                                <button class="w-full py-3 bg-white/95 backdrop-blur text-black font-bold rounded-xl hover:bg-black hover:text-white transition-colors shadow-lg">
                                    Add to Cart
                                </button>
                            </div>
                            @endif
                        </div>
                        
                        <div>
                            <h4 class="text-base font-medium text-gray-900 group-hover:text-gray-600 transition-colors truncate">{{ $product->name }}</h4>
                            <p class="text-lg font-bold mt-1 text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>

        @else
            <div class="flex flex-col items-center justify-center text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">No Products Found</h3>
                <p class="text-gray-500 mb-6">We couldn't find any products in this category.</p>
                <a href="{{ route('shop') }}" class="px-6 py-3 bg-black text-white rounded-full font-bold hover:bg-gray-800 transition-colors">
                    Browse All Products
                </a>
            </div>
        @endif

    </div>
@endsection