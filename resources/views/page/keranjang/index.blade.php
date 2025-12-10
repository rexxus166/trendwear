@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="px-5 py-8 lg:px-12 max-w-7xl mx-auto min-h-[60vh]">
        
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        @if($carts->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                             class="bg-green-100 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @php $subtotal = 0; @endphp

                    @foreach($carts as $cart)
                        {{-- =================================================== --}}
                        {{-- LOGIKA HITUNG HARGA VARIAN (DELTA CALCULATION) --}}
                        {{-- =================================================== --}}
                        @php 
                            $basePrice = $cart->product->price;
                            $finalUnitPrice = $basePrice;
                            
                            // Ambil data varian JSON dari produk
                            // Format di DB: [{"type":"size", "key":"XL", "price":150000}, ...]
                            $variantsData = $cart->product->variants_data ?? []; 

                            // 1. Cek Selisih Harga Option (Jika user memilih option)
                            if ($cart->option) {
                                // Cari data option yang sesuai di JSON
                                $optData = collect($variantsData)->first(function($item) use ($cart) {
                                    return isset($item['type']) && $item['type'] === 'option' && $item['key'] === $cart->option;
                                });
                                
                                // Jika ketemu, hitung selisihnya (Harga Varian - Harga Dasar)
                                if ($optData) {
                                    $finalUnitPrice += ($optData['price'] - $basePrice);
                                }
                            }

                            // 2. Cek Selisih Harga Size (Jika user memilih size)
                            if ($cart->size) {
                                $sizeData = collect($variantsData)->first(function($item) use ($cart) {
                                    return isset($item['type']) && $item['type'] === 'size' && $item['key'] === $cart->size;
                                });

                                if ($sizeData) {
                                    $finalUnitPrice += ($sizeData['price'] - $basePrice);
                                }
                            }

                            // Hitung Total Baris ini
                            $lineTotal = $finalUnitPrice * $cart->quantity;
                            
                            // Tambahkan ke Subtotal Global
                            $subtotal += $lineTotal;
                        @endphp
                        {{-- =================================================== --}}

                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 p-4 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative group">
                            
                            <div class="w-full sm:w-28 h-28 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($cart->product->images->isNotEmpty())
                                    @if($cart->product->images->first()->file_type == 'video')
                                        <video src="{{ asset('storage/' . $cart->product->images->first()->file_path) }}" class="w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $cart->product->images->first()->file_path) }}" alt="{{ $cart->product->name }}" class="w-full h-full object-cover">
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>

                            <div class="flex-1 flex flex-col justify-between w-full">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 line-clamp-2 pr-8">{{ $cart->product->name }}</h3>
                                        
                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <p class="text-sm text-gray-500 mb-2">{{ $cart->product->category->name ?? 'Uncategorized' }}</p>

                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @if($cart->option)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $cart->option }}
                                            </span>
                                        @endif
                                        @if($cart->size)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                Size: {{ $cart->size }}
                                            </span>
                                        @endif
                                        @if($cart->color)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                Color: {{ $cart->color }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-3 sm:mt-0">
                                    <div class="flex items-center border border-gray-300 rounded-lg h-9">
                                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                            @csrf @method('PATCH') <input type="hidden" name="type" value="decrement">
                                            <button type="submit" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-l-lg transition-colors {{ $cart->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                        </form>
                                        <div class="w-10 h-full flex items-center justify-center text-sm font-bold border-x border-gray-300 bg-white">{{ $cart->quantity }}</div>
                                        <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                            @csrf @method('PATCH') <input type="hidden" name="type" value="increment">
                                            <button type="submit" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-r-lg transition-colors {{ $cart->quantity >= $cart->product->stock ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}>+</button>
                                        </form>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-black">Rp {{ number_format($lineTotal, 0, ',', '.') }}</p>
                                        @if($cart->quantity > 1)
                                            <p class="text-xs text-gray-400">@ {{ number_format($finalUnitPrice, 0, ',', '.') }} / item</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-lg sticky top-24">
                        <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium text-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600 font-medium text-sm">Calculated at Checkout</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax</span>
                                <span class="font-medium text-black">Rp 0</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-8">
                            <span class="text-lg font-bold">Total</span>
                            <span class="text-2xl font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <button class="w-full py-4 bg-black text-white rounded-xl font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-xl flex items-center justify-center gap-2">
                            Checkout
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>

                        <div class="mt-6 flex items-center justify-center gap-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span class="text-xs">Secure Checkout</span>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center min-h-[50vh]">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-black text-white rounded-full font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg">
                    Start Shopping
                </a>
            </div>
        @endif

    </div>
@endsection