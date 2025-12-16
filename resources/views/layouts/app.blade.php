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

        @if (request()->routeIs('profile.edit', 'cart.index', 'address.index', 'checkout.index', 'pesanan', 'orders.show'))
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
</body>

</html>
