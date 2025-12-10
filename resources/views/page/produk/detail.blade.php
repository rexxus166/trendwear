@extends('layouts.app')

@section('title', $product->name)

@section('content')
    
    <div class="px-5 py-4 lg:px-12 border-b border-gray-100 bg-white">
        <div class="flex items-center gap-2 text-sm text-gray-500 overflow-hidden whitespace-nowrap">
            <a href="{{ route('dashboard') }}" class="hover:text-black transition-colors">Home</a>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-black transition-colors font-medium">
                {{ $product->category->name }}
            </a>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-black font-medium truncate">{{ $product->name }}</span>
        </div>
    </div>

    <div class="px-5 py-8 lg:px-12 max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16" 
             x-data="{ 
                activeImage: '{{ $product->images->isNotEmpty() ? ($product->images->first()->file_type == 'video' ? $product->images->first()->file_path : asset('storage/' . $product->images->first()->file_path)) : 'https://via.placeholder.com/500' }}',
                isVideo: {{ $product->images->isNotEmpty() && $product->images->first()->file_type == 'video' ? 'true' : 'false' }},
                qty: 1,
                selectedOption: '',
                selectedSize: '',
                selectedColor: ''
             }">
            
            <div>
                <div class="aspect-[4/5] lg:aspect-square bg-gray-100 rounded-3xl overflow-hidden mb-4 relative group border border-gray-100">
                    <template x-if="!isVideo">
                        <img :src="activeImage" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </template>
                    <template x-if="isVideo">
                        <video :src="'/storage/' + activeImage" class="w-full h-full object-cover" controls autoplay muted loop></video>
                    </template>
                    @if($product->stock < 5 && $product->stock > 0)
                        <span class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">Only {{ $product->stock }} left!</span>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-3">
                    @foreach($product->images as $image)
                        <button @click="activeImage = '{{ $image->file_type == 'video' ? $image->file_path : asset('storage/' . $image->file_path) }}'; isVideo = {{ $image->file_type == 'video' ? 'true' : 'false' }}" 
                                class="aspect-square rounded-xl overflow-hidden border-2 border-transparent hover:border-black transition-all bg-gray-50 relative cursor-pointer ring-1 ring-gray-100">
                            @if($image->file_type == 'video')
                                <video src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-full object-cover"></video>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/20"><svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></div>
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
                <p class="text-3xl font-bold mb-6 text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="mb-8 border-b border-gray-100 pb-8" x-data="{ expanded: false }">
                    <h3 class="text-sm font-bold text-gray-900 mb-3">Description</h3>
                    
                    <div class="prose prose-sm text-gray-500 leading-relaxed relative transition-all duration-300"
                         :class="!expanded ? 'max-h-24 overflow-hidden' : ''">
                        <p>{!! nl2br(e($product->description)) !!}</p>
                        
                        <div x-show="!expanded" class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white to-transparent"></div>
                    </div>

                    @if(strlen($product->description) > 200)
                        <button @click="expanded = !expanded" class="text-sm font-bold underline mt-2 cursor-pointer hover:text-gray-700 focus:outline-none">
                            <span x-text="expanded ? 'Show Less' : 'Read More'"></span>
                        </button>
                    @endif
                </div>

                <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="option" :value="selectedOption">
                    <input type="hidden" name="size" :value="selectedSize">
                    <input type="hidden" name="color" :value="selectedColor">

                    @if(!empty($product->options))
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-900 mb-3">Select Option</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->options as $option)
                                    <button type="button" 
                                            @click="selectedOption = '{{ $option }}'"
                                            :class="selectedOption === '{{ $option }}' ? 'bg-black text-white border-black ring-2 ring-black ring-offset-2' : 'bg-white text-gray-900 border-gray-200 hover:border-black'"
                                            class="h-10 min-w-[40px] px-4 rounded-lg border font-medium text-sm transition-all">
                                        {{ $option }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="text" x-model="selectedOption" required class="opacity-0 absolute w-0 h-0" oninvalid="this.setCustomValidity('Please select a size')" oninput="this.setCustomValidity('')">
                        </div>
                    @endif

                    @if(!empty($product->sizes))
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-900 mb-3">Select Size</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->sizes as $size)
                                    <button type="button" 
                                            @click="selectedSize = '{{ $size }}'"
                                            :class="selectedSize === '{{ $size }}' ? 'bg-black text-white border-black ring-2 ring-black ring-offset-2' : 'bg-white text-gray-900 border-gray-200 hover:border-black'"
                                            class="h-10 min-w-[40px] px-4 rounded-lg border font-medium text-sm transition-all">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="text" x-model="selectedSize" required class="opacity-0 absolute w-0 h-0" oninvalid="this.setCustomValidity('Please select a size')" oninput="this.setCustomValidity('')">
                        </div>
                    @endif

                    @if(!empty($product->colors))
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-900 mb-3">Select Color</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->colors as $color)
                                    <button type="button" 
                                            @click="selectedColor = '{{ $color }}'"
                                            :class="selectedColor === '{{ $color }}' ? 'bg-black text-white border-black ring-2 ring-black ring-offset-2' : 'bg-white text-gray-900 border-gray-200 hover:border-black'"
                                            class="h-10 px-4 rounded-lg border font-medium text-sm transition-all flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full border border-gray-300" style="background-color: {{ strtolower($color) }}"></span>
                                        {{ $color }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="text" x-model="selectedColor" required class="opacity-0 absolute w-0 h-0" oninvalid="this.setCustomValidity('Please select a color')" oninput="this.setCustomValidity('')">
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="flex items-center border border-gray-300 rounded-full px-2 h-14 w-fit">
                            <button type="button" @click="qty > 1 ? qty-- : null" class="w-10 h-full flex items-center justify-center hover:text-gray-500 text-xl">-</button>
                            <input type="number" name="quantity" x-model="qty" readonly class="w-12 text-center border-none focus:ring-0 p-0 text-base font-bold bg-transparent appearance-none">
                            <button type="button" @click="qty < {{ $product->stock }} ? qty++ : null" class="w-10 h-full flex items-center justify-center hover:text-gray-500 text-xl">+</button>
                        </div>

                        <button type="submit" 
                                class="flex-1 h-14 border-2 border-black text-black bg-white rounded-full font-bold hover:bg-gray-50 transition-transform active:scale-95 flex items-center justify-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            {{ $product->stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                        </button>

                        @if($product->stock > 0)
                        <a href="#" class="flex-1 h-14 bg-black text-white border-2 border-black rounded-full font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg flex items-center justify-center gap-2">
                            Buy Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="mt-24 border-t border-gray-100 pt-16">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold">You might also like</h3>
                <a href="{{ route('category.show', $product->category->slug) }}" class="text-sm font-medium text-gray-500 hover:text-black">View Category</a>
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