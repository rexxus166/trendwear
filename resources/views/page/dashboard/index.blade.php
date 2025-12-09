@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <section class="relative h-80 lg:h-[500px] overflow-hidden lg:m-6 lg:rounded-3xl">
        <img src="https://images.unsplash.com/photo-1614975059536-2df3b404d53c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1920" alt="Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent lg:bg-gradient-to-r lg:from-black/80 lg:via-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-16 text-white lg:w-1/2 lg:top-0 lg:flex lg:flex-col lg:justify-center">
            <div class="animate-fade-in-up">
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm mb-3 border border-white/30">Winter Collection 2025</span>
                <h2 class="text-4xl lg:text-6xl font-bold mb-4 leading-tight">Street <br/>Essentials</h2>
                <p class="text-white/80 mb-6 text-lg max-w-sm">Define your style with our curated pieces designed for the modern urban explorer.</p>
                <button class="px-8 py-3 bg-white text-black rounded-full inline-flex items-center gap-2 hover:bg-gray-100 transition-colors font-semibold group">
                    Shop Collection
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <section class="px-5 py-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">Categories</h3>
            <a href="#" class="text-sm font-medium text-gray-500 hover:text-black flex items-center gap-1 group">
                View All 
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            <button class="group relative p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-all text-left overflow-hidden hover:shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-black/5 rounded-full -translate-y-8 translate-x-8 transition-transform group-hover:scale-150 duration-500"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">Outerwear</h4>
                    <p class="text-sm text-gray-500">234 items</p>
                </div>
                <svg class="absolute bottom-4 right-4 w-5 h-5 text-gray-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            <button class="group relative p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-all text-left overflow-hidden hover:shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-black/5 rounded-full -translate-y-8 translate-x-8 transition-transform group-hover:scale-150 duration-500"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">T-Shirts</h4>
                    <p class="text-sm text-gray-500">567 items</p>
                </div>
                <svg class="absolute bottom-4 right-4 w-5 h-5 text-gray-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            <button class="group relative p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-all text-left overflow-hidden hover:shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-black/5 rounded-full -translate-y-8 translate-x-8 transition-transform group-hover:scale-150 duration-500"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">Denim</h4>
                    <p class="text-sm text-gray-500">189 items</p>
                </div>
                <svg class="absolute bottom-4 right-4 w-5 h-5 text-gray-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            <button class="group relative p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-all text-left overflow-hidden hover:shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-black/5 rounded-full -translate-y-8 translate-x-8 transition-transform group-hover:scale-150 duration-500"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-1">Footwear</h4>
                    <p class="text-sm text-gray-500">321 items</p>
                </div>
                <svg class="absolute bottom-4 right-4 w-5 h-5 text-gray-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </section>

    <section class="px-5 py-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">Trending Now</h3>
            <a href="#" class="text-sm font-medium text-gray-500 hover:text-black">See More</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-8 lg:gap-8">
            
            <a href="#" class="product-card group cursor-pointer">
                <div class="relative mb-3 overflow-hidden rounded-2xl bg-gray-50 aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1648483098902-7af8f711498f?w=800" alt="Essential White Tee" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 px-3 py-1 bg-black text-white text-xs font-bold rounded-full">Best Seller</span>
                    <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 hidden lg:block">
                        <button class="w-full py-3 bg-white/90 backdrop-blur-sm text-black font-semibold rounded-xl hover:bg-black hover:text-white transition-colors">Add to Cart</button>
                    </div>
                </div>
                <div>
                    <h4 class="text-base font-medium group-hover:text-gray-600 transition-colors">Essential White Tee</h4>
                    <p class="text-lg font-bold mt-1">Rp 299.000</p>
                </div>
            </a>

            <a href="#" class="product-card group cursor-pointer">
                <div class="relative mb-3 overflow-hidden rounded-2xl bg-gray-50 aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1588011025378-15f4778d2558?w=800" alt="Classic Black Jacket" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 px-3 py-1 bg-black text-white text-xs font-bold rounded-full">New</span>
                    <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div>
                    <h4 class="text-base font-medium group-hover:text-gray-600 transition-colors">Classic Black Jacket</h4>
                    <p class="text-lg font-bold mt-1">Rp 899.000</p>
                </div>
            </a>

            <a href="#" class="product-card group cursor-pointer">
                <div class="relative mb-3 overflow-hidden rounded-2xl bg-gray-50 aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1761891873744-eb181eb1334a?w=800" alt="Vintage Denim" class="w-full h-full object-cover">
                    <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div>
                    <h4 class="text-base font-medium group-hover:text-gray-600 transition-colors">Vintage Denim</h4>
                    <p class="text-lg font-bold mt-1">Rp 649.000</p>
                </div>
            </a>

            <a href="#" class="product-card group cursor-pointer">
                <div class="relative mb-3 overflow-hidden rounded-2xl bg-gray-50 aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1631984564919-1f6b2313a71c?w=800" alt="Urban Sneakers" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">Sale</span>
                    <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div>
                    <h4 class="text-base font-medium group-hover:text-gray-600 transition-colors">Urban Sneakers</h4>
                    <p class="text-lg font-bold mt-1">Rp 1.299.000</p>
                </div>
            </a>

        </div>
    </section>

    <section class="mx-5 my-6 lg:mx-8 lg:my-12">
        <div class="bg-gradient-to-br from-black to-gray-800 rounded-3xl p-8 lg:p-12 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-16 translate-x-16 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-12 -translate-x-12 blur-2xl"></div>
            
            <div class="relative z-10 max-w-lg">
                <p class="text-white/60 text-sm lg:text-base mb-2 font-medium tracking-wide">LIMITED TIME OFFER</p>
                <h3 class="text-3xl lg:text-5xl font-bold mb-4">Get 30% Off Everything</h3>
                <p class="text-white/80 text-sm lg:text-lg mb-6">Use code <span class="text-white font-mono bg-white/20 px-2 py-1 rounded">FIRST30</span> at checkout. Valid for new customers only.</p>
                <button class="w-full md:w-auto px-8 py-3 bg-white text-black rounded-full text-sm lg:text-base hover:bg-gray-100 transition-colors font-bold shadow-lg">Claim Offer Now</button>
            </div>
        </div>
    </section>

@endsection