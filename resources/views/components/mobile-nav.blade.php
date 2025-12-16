<nav class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 lg:hidden z-50">
    <div class="flex items-center justify-around px-2 py-3 max-w-md mx-auto">

        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center gap-1 px-4 py-1 rounded-xl {{ request()->routeIs('dashboard') ? 'text-black' : 'text-gray-400 hover:text-black' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        <a href="{{ route('search.mobile') }}"
            class="flex flex-col items-center gap-1 px-4 py-1 rounded-xl {{ request()->routeIs('search.mobile', 'search') ? 'text-black' : 'text-gray-400 hover:text-black' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="text-[10px] font-medium">Search</span>
        </a>

        <a href="{{ route('wishlist') }}"
            class="flex flex-col items-center gap-1 px-4 py-1 rounded-xl {{ request()->routeIs('wishlist') ? 'text-black' : 'text-gray-400 hover:text-black' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
            <span class="text-[10px] font-medium">Wishlist</span>
        </a>

        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 px-4 py-1 rounded-xl {{ request()->routeIs('profile.edit', 'pesanan', 'orders.show') ? 'text-black' : 'text-gray-400 hover:text-black' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-[10px] font-medium">Profile</span>
        </a>

    </div>
</nav>
