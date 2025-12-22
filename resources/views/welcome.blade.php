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


    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6289661175419?text=Saya%20ingin%20bertanya%20tentang%20Produk%20di%20TrendWear" 
       target="_blank" 
       class="fixed bottom-4 left-4 md:bottom-6 md:left-6 z-50 bg-[#25D366] text-white p-3 md:p-4 rounded-full shadow-lg hover:bg-[#128C7E] transition-all hover:scale-110 flex items-center justify-center group"
       aria-label="Chat on WhatsApp">
        <svg class="w-6 h-6 md:w-8 md:h-8 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>


    <!-- AI Chat Floating Button -->
    <button onclick="toggleChat()" class="fixed bottom-4 right-4 md:bottom-6 md:right-6 z-50 bg-black text-white p-3 md:p-4 rounded-full shadow-lg hover:scale-110 transition-transform flex items-center justify-center group">
        <!-- Icon Chat -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-8 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
    </button>

    <!-- AI Chat Box -->
    <div id="aiChatBox" class="fixed bottom-20 right-4 md:right-6 w-[90%] md:w-96 bg-white rounded-2xl shadow-2xl z-50 transform translate-y-[120%] transition-transform duration-300 ease-in-out flex flex-col max-h-[500px] border border-gray-100 hidden">
        <!-- Header -->
        <div class="bg-black text-white px-5 py-4 rounded-t-2xl flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <h3 class="font-bold text-lg">TrendAi Assistant</h3>
            </div>
            <button onclick="toggleChat()" class="text-white/70 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 text-sm h-80">
            <!-- Initial Greeting -->
            <div class="flex items-start gap-2.5">
                <div class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0">AI</div>
                <div class="flex flex-col gap-1 w-full max-w-[320px]">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <span class="text-sm font-semibold text-gray-900">TrendAi</span>
                        <span class="text-xs font-normal text-gray-500">Just now</span>
                    </div>
                    <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-white rounded-e-xl rounded-es-xl shadow-sm">
                        <p class="text-sm font-normal text-gray-900">Halo! Saya asisten pribadi Anda. Ada yang bisa saya bantu cari hari ini? 😊</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-gray-100 bg-white rounded-b-2xl">
            <form onsubmit="sendMessage(event)" class="flex items-center gap-2">
                <input type="text" id="userMessage" class="flex-1 bg-gray-100 border-0 rounded-full px-4 py-2.5 text-sm focus:ring-2 focus:ring-black focus:outline-none" placeholder="Tanya tentang produk..." autocomplete="off">
                <button type="submit" id="sendBtn" class="bg-black text-white p-2.5 rounded-full hover:bg-gray-800 transition-colors disabled:opacity-50">
                    <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleChat() {
            const box = document.getElementById('aiChatBox');
            if (box.classList.contains('hidden')) {
                box.classList.remove('hidden');
                setTimeout(() => box.classList.remove('translate-y-[120%]'), 10);
            } else {
                box.classList.add('translate-y-[120%]');
                setTimeout(() => box.classList.add('hidden'), 300);
            }
        }

        let chatHistory = [];

        async function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('userMessage');
            const message = input.value.trim();
            const btn = document.getElementById('sendBtn');
            const messagesDiv = document.getElementById('chatMessages');

            if (!message) return;

            // 1. Add User Message
            appendMessage('user', message);
            input.value = '';
            input.disabled = true;
            btn.disabled = true;

            // 2. Add Loading State
            const loadingId = 'loading-' + Date.now();
            appendLoading(loadingId);
            scrollToBottom();

            try {
                // Send history along with new message
                const response = await fetch("{{ route('ai.chat') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ 
                        message: message,
                        history: chatHistory 
                    })
                });

                const data = await response.json();
                
                // Remove loading
                removeElement(loadingId);

                if (data.status === 'success') {
                    appendMessage('ai', data.reply);
                } else {
                    appendMessage('ai', "Maaf, sistem sedang sibuk. Coba lagi nanti.");
                }

            } catch (error) {
                removeElement(loadingId);
                appendMessage('ai', "Terjadi kesalahan koneksi. Silakan periksa internet Anda.");
                console.error(error);
            } finally {
                input.disabled = false;
                btn.disabled = false;
                input.focus();
                scrollToBottom();
            }
        }

        function appendMessage(role, text) {
            // Add to history
            chatHistory.push({ role: role, parts: [{ text: text }] });
            
            // Limit history to last 10 messages to avoid token limits
            if (chatHistory.length > 20) {
                chatHistory = chatHistory.slice(-20);
            }

            const div = document.getElementById('chatMessages');
            let html = '';
            
            if (role === 'ai') {
                html = `
                <div class="flex items-start gap-2.5 animate-fade-up">
                    <div class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0">AI</div>
                    <div class="flex flex-col gap-1 w-full max-w-[320px]">
                        <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-white rounded-e-xl rounded-es-xl shadow-sm">
                            <p class="text-sm font-normal text-gray-900 whitespace-pre-line">${text}</p>
                        </div>
                    </div>
                </div>`;
            } else {
                html = `
                <div class="flex items-start gap-2.5 justify-end animate-fade-up">
                    <div class="flex flex-col gap-1 w-full max-w-[320px]">
                        <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-900 text-white rounded-s-xl rounded-ee-xl shadow-sm">
                            <p class="text-sm font-normal whitespace-pre-line">${text}</p>
                        </div>
                    </div>
                </div>`;
            }
            
            div.insertAdjacentHTML('beforeend', html);
        }

        function appendLoading(id) {
            const div = document.getElementById('chatMessages');
            const html = `
            <div id="${id}" class="flex items-start gap-2.5 animate-pulse">
                <div class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold shrink-0">AI</div>
                <div class="flex flex-col gap-1 w-full max-w-[320px]">
                    <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-white rounded-e-xl rounded-es-xl shadow-sm">
                        <div class="flex gap-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-100"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-200"></div>
                        </div>
                    </div>
                </div>
            </div>`;
            div.insertAdjacentHTML('beforeend', html);
        }

        function removeElement(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        function scrollToBottom() {
            const div = document.getElementById('chatMessages');
            div.scrollTop = div.scrollHeight;
        }
    </script>
</body>
</html>