@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

    <div
        class="fixed top-0 left-0 right-0 bg-white z-50 border-b border-gray-100 px-4 h-16 flex items-center gap-4 lg:hidden">
        <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-black">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-lg font-bold text-gray-900">Checkout</h1>
    </div>

    <div class="px-5 py-8 lg:px-12 max-w-7xl mx-auto min-h-[80vh] pt-24 lg:pt-12 pb-32 lg:pb-12" x-data="checkoutData">

        <h1 class="text-3xl font-bold mb-8 hidden lg:block">Checkout</h1>

        <form @submit.prevent="processPayment">
            @csrf

            <input type="hidden" name="address_id" :value="activeAddress ? activeAddress.id : ''">
            <input type="hidden" name="shipping_service" x-model="selectedService">
            <input type="hidden" name="shipping_cost" x-model="shippingCost">
            <input type="hidden" name="courier" x-model="selectedCourier">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 relative">

                <div class="lg:col-span-2 space-y-8">

                    <section class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold flex items-center gap-2">
                                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat Pengiriman
                            </h2>
                            <button type="button" @click="showAddressModal = true"
                                class="text-sm font-semibold text-blue-600 hover:underline">
                                Ubah Alamat
                            </button>
                        </div>

                        <template x-if="activeAddress">
                            <div class="space-y-1 text-sm sm:text-base cursor-pointer hover:opacity-70 transition-opacity"
                                @click="showAddressModal = true">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-gray-900"
                                        x-text="activeAddress.recipient_name || activeAddress.name"></span>
                                    <span class="text-gray-400">|</span>
                                    <span class="text-gray-600"
                                        x-text="activeAddress.phone_number || activeAddress.phone"></span>
                                    <span
                                        class="px-2 py-0.5 bg-gray-100 text-xs font-bold rounded text-gray-600 border border-gray-200"
                                        x-text="activeAddress.label || (activeAddress.is_primary ? 'Utama' : 'Lainnya')"></span>
                                </div>
                                <p class="text-gray-600" x-text="activeAddress.address_line1 || activeAddress.address"></p>
                                <p class="text-gray-600">
                                    <span
                                        x-text="[activeAddress.village, activeAddress.district, activeAddress.city, activeAddress.province, activeAddress.postal_code].filter(Boolean).join(', ')"></span>
                                </p>
                            </div>
                        </template>

                        <template x-if="!activeAddress">
                            <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <p class="text-gray-500 mb-3 text-sm">Belum ada alamat pengiriman.</p>
                                <a href="{{ route('address.index') }}"
                                    class="px-4 py-2 bg-black text-white text-sm font-bold rounded-lg">Tambah Alamat
                                    Baru</a>
                            </div>
                        </template>
                    </section>

                    <section class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <h2 class="text-lg font-bold mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Rincian Pesanan
                        </h2>

                        <div class="divide-y divide-gray-100">
                            @foreach ($carts as $cart)
                                <div class="flex gap-4 py-4 first:pt-0 last:pb-0">
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                        @if ($cart->product->images->isNotEmpty())
                                            @if ($cart->product->images->first()->file_type == 'video')
                                                <video
                                                    src="{{ asset('storage/' . $cart->product->images->first()->file_path) }}"
                                                    class="w-full h-full object-cover"></video>
                                            @else
                                                <img src="{{ asset('storage/' . $cart->product->images->first()->file_path) }}"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 mb-1">
                                            {{ $cart->product->name }}</h4>
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            @if ($cart->option)
                                                <span
                                                    class="px-1.5 py-0.5 bg-blue-50 text-blue-700 text-[10px] rounded border border-blue-100">{{ $cart->option }}</span>
                                            @endif
                                            @if ($cart->size)
                                                <span
                                                    class="px-1.5 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded border border-gray-200">Size:
                                                    {{ $cart->size }}</span>
                                            @endif
                                            @if ($cart->color)
                                                <span
                                                    class="px-1.5 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded border border-gray-200">{{ $cart->color }}</span>
                                            @endif
                                        </div>
                                        <div class="flex justify-between items-end">
                                            <p class="text-xs text-gray-500">{{ $cart->quantity }}x Barang (@
                                                {{ $cart->product->weight ?? 1000 }}g)</p>
                                            <p class="text-sm font-bold text-black">Rp
                                                {{ number_format(($cart->final_price ?? 0) * ($cart->quantity ?? 1), 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold">Metode Pengiriman</h2>
                            <div x-show="isLoading" class="text-xs font-medium text-gray-500 flex items-center gap-1"
                                style="display: none;">
                                <svg class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Cek Ongkir...
                            </div>
                        </div>

                        <div class="flex gap-3 mb-4">
                            <template x-for="courier in ['jne', 'pos', 'tiki']">
                                <button type="button" @click="checkShipping(courier)"
                                    :class="selectedCourier === courier ? 'bg-black text-white border-black' :
                                        'bg-white text-gray-600 border-gray-200 hover:border-black'"
                                    class="flex-1 py-2 rounded-xl border font-bold text-sm uppercase transition-all"
                                    x-text="courier" :disabled="!activeAddress || isLoading"></button>
                            </template>
                        </div>

                        <div class="space-y-3">
                            <template x-if="shippingResults.length === 0 && !isLoading && selectedCourier">
                                <p class="text-sm text-center text-red-500 py-4 bg-red-50 rounded-xl">
                                    <span
                                        x-text="'Layanan ' + selectedCourier.toUpperCase() + ' tidak ditemukan untuk rute ini.'"></span>
                                </p>
                            </template>

                            <template x-if="isLoading">
                                <div class="text-center py-8">
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-black">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Sedang mengecek ongkir...</p>
                                </div>
                            </template>

                            <template x-for="service in shippingResults" :key="service.service">
                                <label
                                    class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-black transition-all"
                                    :class="selectedService === service.service ? 'border-black ring-1 ring-black bg-gray-50' :
                                        'border-gray-200'">

                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="shipping_option" :value="service.service"
                                            @click="selectService(service)"
                                            class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                                        <div>
                                            <p class="font-bold text-gray-900" x-text="service.service"></p>
                                            <p class="text-xs text-gray-500">Estimasi <span
                                                    x-text="service.cost[0].etd"></span> hari</p>
                                            <p class="text-xs text-gray-400" x-text="service.description || ''"></p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-gray-900" x-text="formatRupiah(service.cost[0].value)"></p>
                                </label>
                            </template>
                        </div>
                    </section>

                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg sticky top-24">
                        <h2 class="text-lg font-bold mb-6">Rincian Pembayaran</h2>

                        <div class="space-y-3 text-sm lg:mb-6 lg:pb-6 lg:border-b lg:border-gray-100">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span x-text="formatRupiah(subtotal)"></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span x-text="formatRupiah(shippingCost)"></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Layanan</span>
                                <span>Rp 0</span>
                            </div>
                        </div>

                        <div class="hidden lg:block">
                            <div class="flex justify-between items-center mb-8">
                                <span class="text-lg font-bold text-gray-900">Total Pembayaran</span>
                                <span class="text-xl font-bold text-black" x-text="formatRupiah(grandTotal)"></span>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-black text-white rounded-xl font-bold hover:bg-gray-800 transition-all shadow-xl flex items-center justify-center gap-2 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="!activeAddress || !selectedService || isLoading">
                                Buat Pesanan
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>

                            <template x-if="!activeAddress">
                                <p class="text-xs text-red-500 text-center mt-3">* Mohon pilih alamat pengiriman.</p>
                            </template>
                            <template x-if="activeAddress && !selectedService && selectedCourier">
                                <p class="text-xs text-red-500 text-center mt-3">* Pilih layanan pengiriman.</p>
                            </template>
                            <template x-if="activeAddress && !selectedCourier">
                                <p class="text-xs text-red-500 text-center mt-3">* Pilih kurir pengiriman.</p>
                            </template>

                            <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Pembayaran Aman & Terenkripsi
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div
                class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:hidden z-40 pb-safe shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Total Pembayaran</span>
                        <span class="text-lg font-bold text-black" x-text="formatRupiah(grandTotal)"></span>
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-black text-white rounded-xl font-bold text-sm hover:bg-gray-800 transition-colors shadow-lg active:scale-95 flex-1 max-w-[200px] disabled:opacity-50"
                        :disabled="!activeAddress || !selectedService || isLoading">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </form>

        <div x-show="showAddressModal" x-cloak class="fixed inset-0 z-[100] overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showAddressModal" x-transition.opacity
                class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity"
                @click="showAddressModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="showAddressModal" x-transition.scale
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl w-full">

                    <div
                        class="bg-white px-4 pb-4 pt-5 sm:p-6 border-b border-gray-100 flex justify-between items-center sticky top-0 z-10">
                        <h3 class="text-lg font-bold text-gray-900">Pilih Alamat Pengiriman</h3>
                        <button type="button" @click="showAddressModal = false"
                            class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 sm:p-6 max-h-[60vh] overflow-y-auto space-y-4">
                        <template x-for="addr in allAddresses" :key="addr.id">
                            <div @click="selectAddress(addr)"
                                class="border rounded-xl p-4 cursor-pointer transition-all hover:border-black relative"
                                :class="activeAddress && activeAddress.id === addr.id ?
                                    'border-black ring-1 ring-black bg-gray-50' : 'border-gray-200'">

                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-900"
                                            x-text="addr.label || (addr.is_primary ? 'Alamat Utama' : 'Alamat')"></span>
                                        <template x-if="addr.is_primary">
                                            <span
                                                class="bg-black text-white text-[10px] px-2 py-0.5 rounded font-bold uppercase">Utama</span>
                                        </template>
                                    </div>

                                    <template x-if="activeAddress && activeAddress.id === addr.id">
                                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </template>
                                </div>

                                <div class="text-sm text-gray-600 space-y-0.5">
                                    <p class="font-medium text-gray-900">
                                        <span x-text="addr.recipient_name || addr.name"></span>
                                        <span class="text-gray-400 font-normal">| <span
                                                x-text="addr.phone_number || addr.phone"></span></span>
                                    </p>
                                    <p x-text="addr.address_line1 || addr.address"></p>

                                    <p>
                                        <span
                                            x-text="[addr.village, addr.district, addr.city, addr.province, addr.postal_code].filter(Boolean).join(', ')"></span>
                                    </p>
                                </div>
                            </div>
                        </template>

                        <a href="{{ route('address.index') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 border border-dashed border-gray-300 rounded-xl text-gray-500 hover:text-black hover:border-black transition-colors font-medium text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Tambah Alamat Baru
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutData', () => ({
                showAddressModal: false,
                activeAddress: @json($currentAddress ?? null),
                allAddresses: @json($allAddresses ?? []),
                subtotal: {{ $subtotal ?? 0 }},
                shippingCost: 0,
                totalWeight: {{ $totalWeight ?? 1000 }},
                selectedCourier: '',
                shippingResults: [],
                selectedService: '',
                isLoading: false,
                // Variabel CACHE Frontend
                shippingCache: {},

                init() {
                    if (!this.activeAddress && this.allAddresses.length > 0) {
                        const primary = this.allAddresses.find(a => a.is_primary);
                        this.activeAddress = primary || this.allAddresses[0];
                    }
                },

                get grandTotal() {
                    return parseInt(this.subtotal) + parseInt(this.shippingCost);
                },

                selectAddress(address) {
                    this.activeAddress = address;
                    this.showAddressModal = false;
                    this.selectedCourier = '';
                    this.shippingResults = [];
                    this.selectedService = '';
                    this.shippingCost = 0;
                    // Reset Cache saat ganti alamat
                    this.shippingCache = {};
                },

                async checkShipping(courier) {
                    if (!this.activeAddress || !this.activeAddress.id) {
                        alert('Pilih alamat pengiriman terlebih dahulu!');
                        return;
                    }

                    this.selectedCourier = courier;
                    this.selectedService = '';
                    this.shippingCost = 0;

                    // --- CEK CACHE DULU ---
                    if (this.shippingCache[courier]) {
                        this.shippingResults = this.shippingCache[courier];
                        return; // Stop, tidak perlu request API
                    }

                    this.shippingResults = [];
                    this.isLoading = true;

                    try {
                        const response = await fetch('{{ route('shipping.check') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                address_id: this.activeAddress.id,
                                courier: courier,
                                weight: this.totalWeight
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.error || 'Terjadi kesalahan pada server');
                        }

                        if (data.rajaongkir && data.rajaongkir.results && data.rajaongkir.results
                            .length > 0) {
                            this.shippingResults = data.rajaongkir.results[0].costs || [];

                            // --- SIMPAN KE CACHE ---
                            if (this.shippingResults.length > 0) {
                                this.shippingCache[courier] = this.shippingResults;
                            }

                            if (this.shippingResults.length === 0) {
                                alert(`Layanan ${courier.toUpperCase()} tidak tersedia.`);
                            }
                        } else {
                            alert(data.error || 'Layanan tidak ditemukan.');
                        }

                    } catch (error) {
                        console.error(error);
                        alert(error.message);
                        this.selectedCourier = '';
                    } finally {
                        this.isLoading = false;
                    }
                },

                // --- FUNGSI BAYAR MIDTRANS ---
                async processPayment() {
                    if (!this.activeAddress || !this.activeAddress.id) {
                        alert('Mohon pilih alamat pengiriman.');
                        return;
                    }
                    if (!this.selectedService) {
                        alert('Mohon pilih layanan pengiriman.');
                        return;
                    }

                    this.isLoading = true;

                    try {
                        // Minta Snap Token ke Backend
                        const response = await fetch('{{ route('checkout.process') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                address_id: this.activeAddress.id,
                                courier: this.selectedCourier,
                                shipping_service: this.selectedService,
                                shipping_cost: this.shippingCost
                            })
                        });

                        const data = await response.json();

                        if (!data.success) {
                            throw new Error(data.error || 'Gagal memproses pesanan.');
                        }

                        // Munculkan Pop-up Midtrans Snap
                        window.snap.pay(data.snap_token, {
                            // 1. PEMBAYARAN SUKSES
                            onSuccess: function(result) {
                                console.log('Success:', result);
                                // Redirect ke halaman sukses dengan membawa Order ID dari response backend
                                // (Pastikan backend kirim 'order_id' di JSON response ya!)
                                window.location.href = "/checkout/success/" + data.order_id;
                            },

                            // 2. PEMBAYARAN PENDING (Misal transfer bank belum dibayar)
                            onPending: function(result) {
                                console.log('Pending:', result);
                                // Tetap redirect ke halaman sukses (karena order sudah terbuat, statusnya aja yg pending)
                                // Atau bisa redirect ke riwayat pesanan
                                window.location.href = "/checkout/success/" + data.order_id;
                            },

                            // 3. PEMBAYARAN GAGAL
                            onError: function(result) {
                                console.log('Error:', result);
                                alert("Pembayaran Gagal. Silakan coba lagi.");
                                location.reload(); // Refresh halaman biar token baru
                            },

                            // 4. DI-CLOSE USER
                            onClose: function() {
                                // Tidak perlu alert, biarkan user tetap di halaman checkout siapa tau mau ganti metode
                                console.log(
                                    'Customer closed the popup without finishing the payment'
                                );
                            }
                        });

                    } catch (error) {
                        console.error(error);
                        alert(error.message);
                    } finally {
                        this.isLoading = false;
                    }
                },

                selectService(service) {
                    this.selectedService = service.service;
                    this.shippingCost = service.cost[0].value;
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(number);
                }
            }));
        });
    </script>
@endsection
