<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendWear - Redefine Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        
        /* Custom Animation for Text Reveal */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fadeUp 0.8s ease-out forwards;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-white text-black">

    <nav class="absolute top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-6 lg:px-12">
        <div class="text-white font-bold text-2xl tracking-tighter">TrendWear.</div>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-white text-sm font-medium hover:opacity-80 transition-opacity px-4 py-2">Log In</a>
            <a href="{{ route('register') }}" class="bg-white text-black text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-gray-100 transition-colors">Sign Up</a>
        </div>
    </nav>

    <section class="relative h-screen w-full overflow-hidden bg-black">
        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop" 
             alt="Fashion Hero" 
             class="absolute inset-0 w-full h-full object-cover opacity-60">
        
        <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4">
            <span class="text-white/80 text-sm tracking-[0.2em] uppercase mb-4 animate-fade-up">New Collection 2025</span>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 tracking-tight animate-fade-up delay-100 leading-tight">
                WEAR THE <br/> MOMENT.
            </h1>
            <p class="text-white/70 text-lg max-w-lg mb-8 animate-fade-up delay-200">
                Discover the latest trends in street fashion. Curated styles for the modern individual.
            </p>
            <div class="flex flex-col md:flex-row gap-4 animate-fade-up delay-300">
                <a href="register.html" class="px-8 py-4 bg-white text-black rounded-full font-bold hover:bg-gray-200 transition-colors min-w-[160px]">
                    Start Shopping
                </a>
                <a href="#collections" class="px-8 py-4 border border-white/30 backdrop-blur-sm text-white rounded-full font-bold hover:bg-white/10 transition-colors min-w-[160px]">
                    View Lookbook
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <div class="bg-black text-white border-t border-white/10 overflow-hidden py-4">
        <div class="flex justify-around items-center opacity-50 text-sm font-medium tracking-widest uppercase">
            <span>Free Shipping Worldwide</span>
            <span class="hidden md:inline">•</span>
            <span>Premium Quality</span>
            <span class="hidden md:inline">•</span>
            <span>Sustainable Materials</span>
        </div>
    </div>

    <section id="collections" class="py-20 px-6 lg:px-12 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
            <div class="order-2 lg:order-1">
                <div class="relative rounded-2xl overflow-hidden aspect-[4/5] group">
                    <img src="https://images.unsplash.com/photo-1550614000-4b9519e02d48?q=80&w=1856&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Men Collection">
                    <div class="absolute bottom-6 left-6">
                        <span class="bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-wider">Street Series</span>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2 lg:pl-10">
                <h2 class="text-4xl font-bold mb-4">Urban Essentials</h2>
                <p class="text-gray-500 mb-6 text-lg leading-relaxed">
                    Designed for the city life. Our newest collection brings comfort and style together. Minimalism meets functionality in every stitch.
                </p>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 font-semibold border-b border-black pb-1 hover:text-gray-600 transition-colors">
                    Shop The Collection 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:pr-10">
                <h2 class="text-4xl font-bold mb-4">Seasonal Drops</h2>
                <p class="text-gray-500 mb-6 text-lg leading-relaxed">
                    Don't miss out on our limited edition releases. Once they're gone, they're gone. Sign up now to get early access.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 font-semibold border-b border-black pb-1 hover:text-gray-600 transition-colors">
                    Get Early Access
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            <div>
                <div class="relative rounded-2xl overflow-hidden aspect-[4/5] group">
                    <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1888&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Women Collection">
                    <div class="absolute bottom-6 left-6">
                        <span class="bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-wider">Limited Edition</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-24 px-6 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6">Ready to upgrade your look?</h2>
            <p class="text-gray-600 mb-8 text-lg">Join 10,000+ others who have redefined their style with TrendWear.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-black text-white rounded-full font-bold hover:scale-105 transition-transform shadow-lg">Create Account</a>
                <a href="{{ route('login') }}" class="px-10 py-4 bg-white text-black border border-gray-200 rounded-full font-bold hover:bg-gray-50 transition-colors">Log In</a>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-12 px-6 lg:px-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-xl font-bold tracking-tight">TrendWear.</div>
            <div class="flex gap-6 text-sm text-gray-500">
                <a href="#" class="hover:text-black">Instagram</a>
                <a href="#" class="hover:text-black">Twitter</a>
                <a href="#" class="hover:text-black">TikTok</a>
            </div>
            <div class="text-sm text-gray-400">© 2025 TrendWear Inc.</div>
        </div>
    </footer>

</body>
</html>