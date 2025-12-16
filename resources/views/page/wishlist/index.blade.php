@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
    <div class="max-w-5xl mx-auto bg-gray-50/50 min-h-screen relative lg:pt-8 lg:px-8">

        {{-- Header --}}
        <div
            class="px-5 py-4 sticky top-0 z-50 border-b lg:border-none border-gray-200/50 backdrop-blur-md bg-white/80 lg:bg-transparent">
            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}"
                    class="w-10 h-10 rounded-full bg-white shadow-sm border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-lg lg:text-2xl font-bold text-gray-900">Wishlist Saya</h1>
                    <p class="text-xs lg:text-sm text-gray-500">Barang yang kamu sukai ({{ $wishlists->count() }})</p>
                </div>
            </div>
        </div>

        <div class="px-5 pb-20 lg:px-0 mt-4">
            @if ($wishlists->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($wishlists as $item)
                        <div
                            class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm hover:shadow-md transition-all group relative">

                            {{-- Tombol Hapus (Silang) --}}
                            <form action="{{ route('wishlist.toggle') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <button type="submit"
                                    class="absolute top-2 right-2 p-1.5 bg-gray-100 rounded-full text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('product.detail', $item->product->slug) }}">
                                <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden mb-3">
                                    @if ($item->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->file_path) }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 line-clamp-2 text-sm mb-1">{{ $item->product->name }}
                                </h3>
                                <p class="font-bold text-black text-sm">
                                    Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Tampilan Kosong --}}
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Wishlist Kosong</h3>
                    <p class="text-gray-500 mt-1 mb-6 text-sm">Simpan barang favoritmu disini biar gampang dicari.</p>
                    <a href="{{ route('shop') }}" class="px-6 py-2.5 bg-black text-white font-bold rounded-xl text-sm">Cari
                        Barang</a>
                </div>
            @endif
        </div>
    </div>
@endsection
