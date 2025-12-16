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

        @unless (request()->routeIs('cart.index', 'address.index', 'checkout.index'))
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
</body>

</html>
