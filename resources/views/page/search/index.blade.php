<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - {{ config('app.name', 'TrendWear') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>

<body class="bg-white">
    <div class="min-h-screen bg-white max-w-md mx-auto relative pb-24 shadow-2xl">

        <header class="sticky top-0 z-50 bg-white border-b border-gray-100">
            <div class="px-5 py-4">
                <div class="flex items-center gap-3">
                    {{-- Tombol Back --}}
                    <button onclick="window.history.back()"
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    {{-- Form Pencarian --}}
                    <form action="{{ route('search') }}" method="GET" class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>

                        <input type="text" name="q" id="searchInput" placeholder="Cari produk..."
                            class="w-full pl-11 pr-10 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black"
                            autofocus autocomplete="off">

                        {{-- Tombol Clear --}}
                        <button type="button" onclick="clearSearch()" id="clearBtn"
                            class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="px-5 py-6">
            <section id="recentSection">
                <h3 class="text-lg font-semibold mb-4">Pencarian Populer</h3>
                <div class="space-y-3 mb-8">
                    @php
                        $popularSearches = ['Kemeja Sekolah', 'Celana Panjang', 'Dasi', 'Topi'];
                    @endphp

                    @foreach ($popularSearches as $term)
                        <button onclick="searchFor('{{ $term }}')" class="flex items-center gap-3 w-full group">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <span class="flex-1 text-left font-medium">{{ $term }}</span>
                        </button>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- Bottom Navigation (Re-use component mobile-nav biar konsisten) --}}
        @include('components.mobile-nav')
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearBtn');

        // Focus otomatis pas halaman dibuka
        window.onload = function() {
            searchInput.focus();
        };

        searchInput.addEventListener('input', (e) => {
            if (e.target.value) {
                clearBtn.classList.remove('hidden');
                clearBtn.classList.add('flex');
            } else {
                clearBtn.classList.add('hidden');
                clearBtn.classList.remove('flex');
            }
        });

        function searchFor(query) {
            searchInput.value = query;
            // Submit form secara otomatis
            searchInput.closest('form').submit();
        }

        function clearSearch() {
            searchInput.value = '';
            searchInput.focus();
            clearBtn.classList.add('hidden');
            clearBtn.classList.remove('flex');
        }
    </script>
</body>

</html>
