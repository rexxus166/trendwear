<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100">
    <div class="px-5 py-4 lg:px-8">
        <div class="flex items-center justify-between gap-4">
            
            <div class="flex items-center gap-8">
                <div>
                    <p class="text-gray-500 text-xs lg:text-sm">Welcome back,</p>
                    <h1 class="text-xl lg:text-2xl tracking-tight font-bold text-gray-900">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </h1>
                </div>

                <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-gray-600">
    
                    <a href="{{ route('dashboard') }}" 
                    class="transition-colors {{ request()->routeIs('dashboard') ? 'text-black font-bold' : 'hover:text-black' }}">
                    Home
                    </a>

                    <a href="{{ route('shop') }}" 
                    class="transition-colors {{ request()->routeIs('shop') || request()->routeIs('category.show') || request()->routeIs('product.detail') ? 'text-black font-bold' : 'hover:text-black' }}">
                    Shop
                    </a>

                    <a href="#" class="hover:text-black transition-colors">
                        Collections
                    </a>

                    <a href="{{ route('trending') }}" 
                    class="transition-colors {{ request()->routeIs('trending') ? 'text-black font-bold' : 'hover:text-black' }}">
                    New Arrivals
                    </a>

                </nav>
            </div>

            <div class="flex items-center gap-4 flex-1 justify-end max-w-md">
                
                <div class="relative w-full hidden md:block">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Search styles, brands..."
                        class="w-full pl-11 pr-4 py-2.5 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-black text-sm transition-all hover:bg-gray-200">
                </div>

                @php
                    // Menghitung jumlah item di keranjang user saat ini
                    $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                @endphp
                
                <a href="{{ route('cart.index') }}" class="relative cursor-pointer hover:scale-105 transition-transform group">
                    <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center border-2 border-white font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <div class="hidden lg:relative lg:block" x-data="{ open: false }">
                    <button @click="open = ! open" class="flex items-center focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden cursor-pointer hover:ring-2 hover:ring-gray-300 transition-all">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=000&color=fff"
                                alt="Profile" class="w-full h-full object-cover">
                        </div>
                    </button>

                    <div x-show="open" x-cloak 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 z-50 origin-top-right"
                        @click.outside="open = false">

                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                            <p class="text-xs text-gray-500">Signed in as</p>
                            <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black transition-colors">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                Keluar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 relative md:hidden">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" placeholder="Search styles..."
                class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
        </div>
    </div>
</header>