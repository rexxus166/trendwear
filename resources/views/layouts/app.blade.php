<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Home') - {{ config('app.name', 'TrendWear') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-card img {
            transition: transform 0.5s ease;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen bg-white max-w-7xl mx-auto shadow-sm relative">

        @if (request()->routeIs(
                'profile.edit',
                'cart.index',
                'address.index',
                'checkout.index',
                'pesanan',
                'orders.show',
                'wishlist'))
            <div class="hidden lg:block">
                @include('components.header')
            </div>
        @else
            @include('components.header')
        @endif

        <main class="pb-24 lg:pb-12">
            @yield('content')
        </main>

        @unless (request()->routeIs('cart.index', 'address.index', 'checkout.index', 'product.detail'))
            @include('components.mobile-nav')
        @endunless

        @include('components.footer')

    </div>

    <script>
        function toggleWishlist(event, btn, productId) {
            // 1. MATIKAN Default Action & Bubbling
            // Supaya link produk tidak terbuka saat tombol love diklik
            event.preventDefault();
            event.stopPropagation();

            // 2. Cek apakah user tamu (Guest)? Kalau iya, lempar ke login
            @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        // 3. Ambil elemen SVG di dalam tombol untuk dimanipulasi warnanya
        let svg = btn.querySelector('svg');

        // 4. Kirim Request ke Server (AJAX) tanpa reload
        fetch("{{ route('wishlist.toggle') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Wajib ada di Laravel
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'added') {
                    // Jika Server bilang "Ditambahkan": Ubah jadi Merah
                    btn.classList.remove('text-gray-400', 'hover:text-red-500'); // Hapus class lama
                    btn.classList.add('text-red-500'); // Tambah warna merah
                    svg.setAttribute('fill', 'currentColor'); // Isi warna penuh

                    // (Opsional) Efek animasi kecil biar membal
                    btn.style.transform = "scale(1.2)";
                    setTimeout(() => btn.style.transform = "scale(1)", 200);

                } else {
                    // Jika Server bilang "Dihapus": Ubah jadi Abu-abu/Kosong
                    btn.classList.remove('text-red-500');
                    btn.classList.add('text-gray-400', 'hover:text-red-500');
                    svg.setAttribute('fill', 'none'); // Kosongkan isi
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memproses wishlist. Silakan coba lagi.');
            });
        }
    </script>

    <!-- AI Chat Floating Button (Hidden on Mobile) -->
    <button onclick="toggleChat()" class="hidden md:flex fixed bottom-6 right-6 z-50 bg-black text-white p-4 rounded-full shadow-lg hover:scale-110 transition-transform items-center justify-center group">
        <!-- Icon Chat -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
    </button>

    <!-- AI Chat Box -->
    <div id="aiChatBox" class="fixed left-4 right-4 bottom-28 md:left-auto md:right-6 md:bottom-24 w-auto md:w-96 bg-white rounded-2xl shadow-2xl z-50 transform translate-y-[120%] transition-transform duration-300 ease-in-out flex flex-col max-h-[60vh] md:max-h-[500px] border border-gray-100 hidden">
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
            
            // Limit history to last 20 messages to avoid token limits
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
