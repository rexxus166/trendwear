@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
    <div x-data="{ showEditModal: false }" class="max-w-5xl mx-auto bg-white min-h-[80vh] relative lg:pt-8 lg:px-8">

        @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-5 left-1/2 -translate-x-1/2 z-[60] bg-black text-white px-6 py-3 rounded-full shadow-xl flex items-center gap-2 text-sm font-medium animate-fade-in-up">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Profile updated successfully!
            </div>
        @endif

        <div class="px-5 py-4 lg:hidden sticky top-0 bg-white z-50 border-b border-gray-50/50 backdrop-blur-sm bg-white/90">
            <div class="flex items-center justify-between">
                <button onclick="window.history.back()"
                    class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold">My Profile</h1>
                <div class="w-10"></div>
            </div>
        </div>

        <div class="hidden lg:block mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-500">Kelola informasi pribadi, pesanan, dan keamanan.</p>
        </div>

        <div class="px-5 pb-12 lg:px-0 pt-6">

            <div
                class="flex flex-col md:flex-row items-center gap-6 mb-8 p-6 lg:p-10 bg-gradient-to-br from-black to-gray-800 rounded-3xl text-white shadow-xl relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-10 translate-x-10 blur-3xl">
                </div>

                <div
                    class="w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-white/20 p-1 flex items-center justify-center relative z-10 flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=128"
                        alt="Avatar" class="w-full h-full object-cover rounded-full">

                    <button
                        class="absolute bottom-0 right-0 w-6 h-6 lg:w-8 lg:h-8 bg-white text-black rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform cursor-pointer z-20">
                        <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 text-center md:text-left relative z-10 overflow-hidden w-full">
                    <h2 class="text-2xl lg:text-3xl font-bold mb-1 truncate">{{ $user->name }}</h2>
                    <div class="flex flex-col md:block">
                        <span class="text-white/70 text-sm lg:text-base truncate">{{ $user->email }}</span>
                        @if ($user->phone)
                            <span class="hidden md:inline mx-2 text-white/40">•</span>
                            <span class="text-white/70 text-sm lg:text-base">{{ $user->phone }}</span>
                        @endif
                    </div>
                </div>

                <button @click="showEditModal = true"
                    class="absolute top-4 right-4 md:static md:bg-white/10 md:px-4 md:py-2 md:rounded-lg md:hover:bg-white/20 transition-colors text-white text-sm font-medium flex items-center gap-2 cursor-pointer z-20">
                    <span class="hidden md:inline">Edit Profile</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-3 gap-3 lg:gap-6 mb-8 lg:mb-12">
                <a href="{{ route('pesanan') }}" class="block">
                    <div
                        class="p-4 lg:p-6 bg-gray-50 rounded-2xl text-center hover:bg-gray-100 transition-colors cursor-pointer border border-transparent hover:border-gray-200">
                        <p class="text-2xl lg:text-3xl font-bold mb-1 text-gray-900">{{ $orderCount }}</p>
                        <p class="text-xs lg:text-sm text-gray-500 font-medium uppercase tracking-wide">Pesanan</p>
                    </div>
                </a>
                <a href="{{ route('wishlist') }}" class="block"> {{-- Bungkus pakai link --}}
                    <div
                        class="p-4 lg:p-6 bg-gray-50 rounded-2xl text-center hover:bg-gray-100 transition-colors cursor-pointer border border-transparent hover:border-gray-200">
                        <p class="text-2xl lg:text-3xl font-bold mb-1 text-gray-900">{{ $wishlistCount }}</p>
                        {{-- Panggil Variable --}}
                        <p class="text-xs lg:text-sm text-gray-500 font-medium uppercase tracking-wide">Wishlist</p>
                    </div>
                </a>
                <div
                    class="p-4 lg:p-6 bg-gray-50 rounded-2xl text-center hover:bg-gray-100 transition-colors cursor-pointer border border-transparent hover:border-gray-200">
                    <p class="text-2xl lg:text-3xl font-bold mb-1 text-gray-900">8</p>
                    <p class="text-xs lg:text-sm text-gray-500 font-medium uppercase tracking-wide">Review</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-6 mb-8 lg:mb-12">

                <a href="{{ route('pesanan') }}"
                    class="flex items-center gap-4 p-4 lg:p-6 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-black/10 transition-all group text-left">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors">
                        <svg class="w-6 h-6 text-gray-700 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-lg">Pesanan Saya</p>
                        <p class="text-sm text-gray-500">Lacak pesanan</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('address.index') }}"
                    class="flex items-center gap-4 p-4 lg:p-6 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-black/10 transition-all group text-left">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors">
                        <svg class="w-6 h-6 text-gray-700 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-lg">Alamat Tersimpan</p>
                        <p class="text-sm text-gray-500">Kelola lokasi pengiriman</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <button
                    class="flex items-center gap-4 p-4 lg:p-6 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-black/10 transition-all group text-left">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors">
                        <svg class="w-6 h-6 text-gray-700 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-lg">Metode Pembayaran</p>
                        <p class="text-sm text-gray-500">Metode pembayaran yang tersimpan</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <button
                    class="flex items-center gap-4 p-4 lg:p-6 bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md hover:border-black/10 transition-all group text-left">
                    <div
                        class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors">
                        <svg class="w-6 h-6 text-gray-700 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-lg">Pengaturan Akun</p>
                        <p class="text-sm text-gray-500">Password, keamanan & preferensi</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div class="border-t border-gray-100 pt-8 lg:pt-0 lg:border-none">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 p-4 lg:p-5 border-2 border-red-100 bg-red-50 rounded-2xl text-red-600 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-gray-400 mt-8 mb-8 lg:hidden">TrendWear v1.0.0</p>
        </div>

        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">

            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" @click="showEditModal = false">
            </div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showEditModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg w-full">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title">Edit Profile</h3>
                            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="p-6">
                        @csrf
                        @method('patch')

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full
                                    Name</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $user->name) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                    Number</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-500 text-sm font-medium">+62</span>
                                    <input type="text" name="phone" id="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-3">
                            <button type="button" @click="showEditModal = false"
                                class="px-5 py-2.5 rounded-xl text-gray-600 font-medium hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-black text-white font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
