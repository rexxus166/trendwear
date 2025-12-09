@extends('layouts.app')

@section('title', $product->name)

@section('content')
    
    <div class="px-5 py-4 lg:px-12 border-b border-gray-100 bg-white">
        <div class="flex items-center gap-2 text-sm text-gray-500 overflow-hidden whitespace-nowrap">
            <a href="{{ route('dashboard') }}" class="hover:text-black transition-colors">Home</a>
            
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            
            <a href="#" class="hover:text-black transition-colors font-medium">
                {{ $product->category->name }}
            </a>
            
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            
            <span class="text-black font-medium truncate">{{ $product->name }}</span>
        </div>
    </div>

    <div class="px-5 py-8 lg:px-12 max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
            
            <div x-data="{ 
                activeImage: '{{ $product->images->isNotEmpty() 
                    ? ($product->images->first()->file_type == 'video' ? $product->images->first()->file_path : asset('storage/' . $product->images->first()->file_path)) 
                    : 'https://via.placeholder.com/500' }}',
                isVideo: {{ $product->images->isNotEmpty() && $product->images->first()->file_type == 'video' ? 'true' : 'false' }}
            }">
                
                <div class="aspect-[4/5] lg:aspect-square bg-gray-100 rounded-3xl overflow-hidden mb-4 relative group border border-gray-100">
                    <template x-if="!isVideo">
                        <img :src="activeImage" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </template>
                    <template x-if="isVideo">
                        <video :src="'/storage/' + activeImage" class="w-full h-full object-cover" controls autoplay muted loop></video>
                    </template>
                    
                    @if($product->stock < 5)
                        <span class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">
                            Only {{ $product->stock }} left!
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-3">
                    @foreach($product->images as $image)
                        <button @click="activeImage = '{{ $image->file_type == 'video' ? $image->file_path : asset('storage/' . $image->file_path) }}'; isVideo = {{ $image->file_type == 'video' ? 'true' : 'false' }}" 
                                class="aspect-square rounded-xl overflow-hidden border-2 border-transparent hover:border-black transition-all bg-gray-50 relative cursor-pointer ring-1 ring-gray-100">
                            @if($image->file_type == 'video')
                                <video src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-full object-cover"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-full object-cover">
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase tracking-wider">{{ $product->category->name }}</span>
                    <span class="text-xs text-gray-400 font-mono">SKU: {{ $product->sku }}</span>
                </div>

                <h1 class="text-2xl lg:text-4xl font-bold mb-4 leading-tight text-gray-900">{{ $product->name }}</h1>
                <p class="text-3xl font-bold mb-8 text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="prose prose-sm text-gray-500 mb-8 leading-relaxed">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mt-auto pt-8 border-t border-gray-100">
                    
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center gap-6 mb-8">
                            <div class="flex items-center border border-gray-300 rounded-full px-2" x-data="{ qty: 1 }">
                                <button type="button" @click="qty > 1 ? qty-- : null" class="w-10 h-10 flex items-center justify-center hover:text-gray-500 text-xl">-</button>
                                <input type="number" name="quantity" x-model="qty" readonly class="w-12 text-center border-none focus:ring-0 p-0 text-base font-bold bg-transparent appearance-none">
                                <button type="button" @click="qty < {{ $product->stock }} ? qty++ : null" class="w-10 h-10 flex items-center justify-center hover:text-gray-500 text-xl">+</button>
                            </div>
                            <div class="text-sm text-gray-500">
                                Available Stock: <span class="font-bold text-black">{{ $product->stock }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="flex-1 py-4 border-2 border-black text-black bg-white rounded-full font-bold hover:bg-gray-50 transition-transform active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Add to Cart
                            </button>

                            <a href="#" class="flex-1 py-4 bg-black text-white border-2 border-black rounded-full font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg flex items-center justify-center gap-2 text-center">
                                Buy Now
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>

                            <button type="button" class="w-14 h-14 border border-gray-200 rounded-full flex items-center justify-center hover:bg-red-50 hover:border-red-200 hover:text-red-500 transition-colors text-gray-400 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="mt-24 border-t border-gray-100 pt-16">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold">You might also like</h3>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-black">View Category</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('product.detail', $related->slug) }}" class="group cursor-pointer">
                        <div class="relative mb-3 overflow-hidden rounded-2xl bg-gray-100 aspect-[3/4]">
                            @if($related->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $related->images->first()->file_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">No Image</div>
                            @endif
                            
                            <div class="absolute bottom-4 left-4 right-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 hidden lg:block">
                                <button class="w-full py-2 bg-white/90 backdrop-blur-sm text-black text-sm font-bold rounded-xl hover:bg-black hover:text-white transition-colors">View Product</button>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-base font-medium group-hover:text-gray-600 transition-colors truncate">{{ $related->name }}</h4>
                            <p class="text-sm font-bold mt-1">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
@endsection