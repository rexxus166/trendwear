@extends('layouts.app')
@section('title', 'Alamat Saya')

@section('content')
    <div
        class="fixed top-0 left-0 right-0 bg-white z-50 border-b border-gray-100 px-4 h-16 flex items-center gap-4 lg:hidden">
        <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-black">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-lg font-bold text-gray-900">Alamat Saya</h1>
    </div>

    <div class="px-5 py-8 lg:px-12 max-w-4xl mx-auto min-h-[80vh] pt-20 lg:pt-12" x-data="addressManager()">

        <div class="hidden lg:flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold">Alamat Saya</h1>
            @if ($addresses->count() < 3)
                <button @click="openModal()"
                    class="bg-black text-white px-6 py-2.5 rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Alamat Baru
                </button>
            @endif
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2"><svg class="w-5 h-5"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-6">{{ session('error') }}</div>
        @endif

        <div class="space-y-4">
            @forelse($addresses as $address)
                <div
                    class="bg-white border {{ $address->is_primary ? 'border-black ring-1 ring-black' : 'border-gray-200' }} rounded-2xl p-5 relative group transition-all hover:border-black">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-3">
                            <h3 class="font-bold text-gray-900">{{ $address->label }}</h3>
                            @if ($address->is_primary)
                                <span
                                    class="bg-black text-white text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wide">Utama</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="openModal({{ $address }})"
                                class="text-gray-400 hover:text-black p-1 transition-colors">Ubah</button>
                            @if (!$address->is_primary)
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('address.destroy', $address->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus alamat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-400 hover:text-red-600 p-1 transition-colors">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="text-gray-600 text-sm space-y-1 mb-4">
                        <p class="font-medium text-gray-900">{{ $address->recipient_name }} <span
                                class="text-gray-400 font-normal">| {{ $address->phone_number }}</span></p>
                        <p>{{ $address->address_line1 }}</p>
                        <p>{{ $address->village }}, {{ $address->district }}</p>
                        <p>{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                        @if ($address->address_line2)
                            <p class="text-gray-400 italic">({{ $address->address_line2 }})</p>
                        @endif
                    </div>
                    @if (!$address->is_primary)
                        <form action="{{ route('address.setPrimary', $address->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-sm font-medium border border-gray-300 px-4 py-2 rounded-lg hover:border-black hover:bg-black hover:text-white transition-all">Jadikan
                                Alamat Utama</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <div
                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 mb-6">Kamu belum memiliki alamat tersimpan.</p>
                    <button @click="openModal()"
                        class="bg-black text-white px-6 py-3 rounded-full font-bold shadow-lg hover:bg-gray-800 transition-transform active:scale-95">Tambah
                        Alamat Sekarang</button>
                </div>
            @endforelse
        </div>

        @if ($addresses->count() < 3)
            <button @click="openModal()"
                class="lg:hidden fixed bottom-6 right-6 w-14 h-14 bg-black text-white rounded-full shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95 z-40">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
        @endif

        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="showModal" x-transition.opacity
                class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showModal" x-transition.scale
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl w-full">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900" x-text="isEdit ? 'Ubah Alamat' : 'Tambah Alamat Baru'">
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <form :action="isEdit ? '/profile/address/' + form.id : '{{ route('address.store') }}'" method="POST"
                        class="p-6 max-h-[80vh] overflow-y-auto">
                        @csrf
                        <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Label Alamat</label>
                                <div class="flex gap-3">
                                    <button type="button" @click="form.label = 'Rumah'"
                                        :class="form.label === 'Rumah' ? 'bg-black text-white border-black' :
                                            'bg-white text-gray-600 border-gray-200'"
                                        class="px-4 py-2 border rounded-lg text-sm font-medium transition-all">Rumah</button>
                                    <button type="button" @click="form.label = 'Kantor'"
                                        :class="form.label === 'Kantor' ? 'bg-black text-white border-black' :
                                            'bg-white text-gray-600 border-gray-200'"
                                        class="px-4 py-2 border rounded-lg text-sm font-medium transition-all">Kantor</button>
                                    <button type="button" @click="form.label = 'Kost'"
                                        :class="form.label === 'Kost' ? 'bg-black text-white border-black' :
                                            'bg-white text-gray-600 border-gray-200'"
                                        class="px-4 py-2 border rounded-lg text-sm font-medium transition-all">Kost</button>
                                </div>
                                <input type="hidden" name="label" x-model="form.label">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="text-xs text-gray-500 uppercase font-bold">Nama Penerima</label><input
                                        type="text" name="recipient_name" x-model="form.recipient_name" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black focus:border-black">
                                </div>
                                <div><label class="text-xs text-gray-500 uppercase font-bold">No. HP</label><input
                                        type="text" name="phone_number" x-model="form.phone_number" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black focus:border-black">
                                </div>
                            </div>

                            <div class="space-y-4 border-t border-b border-gray-100 py-4">
                                <p class="text-sm font-bold text-black">Lokasi Wilayah</p>

                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-bold">Provinsi</label>
                                    <select x-model="selectedProvId" @change="fetchCities()" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black">
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="prov in provinces" :key="prov.id">
                                            <option :value="prov.id" x-text="prov.name"></option>
                                        </template>
                                    </select>
                                    <input type="hidden" name="province" x-model="form.province">
                                </div>

                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-bold">Kota / Kabupaten</label>
                                    <select x-model="selectedCityId" @change="fetchDistricts()"
                                        :disabled="!selectedProvId" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black disabled:bg-gray-100">
                                        <option value="">Pilih Kota/Kab</option>
                                        <template x-for="city in cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                    <input type="hidden" name="city" x-model="form.city">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase font-bold">Kecamatan</label>
                                        <select x-model="selectedDistrictId" @change="fetchVillages()"
                                            :disabled="!selectedCityId" required
                                            class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black disabled:bg-gray-100">
                                            <option value="">Pilih Kecamatan</option>
                                            <template x-for="dist in districts" :key="dist.id">
                                                <option :value="dist.id" x-text="dist.name"></option>
                                            </template>
                                        </select>
                                        <input type="hidden" name="district" x-model="form.district">
                                    </div>

                                    <div>
                                        <label class="text-xs text-gray-500 uppercase font-bold">Kelurahan</label>
                                        <select x-model="selectedVillageId" @change="setVillageName()"
                                            :disabled="!selectedDistrictId" required
                                            class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black disabled:bg-gray-100">
                                            <option value="">Pilih Kelurahan</option>
                                            <template x-for="vill in villages" :key="vill.id">
                                                <option :value="vill.id" x-text="vill.name"></option>
                                            </template>
                                        </select>
                                        <input type="hidden" name="village" x-model="form.village">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs text-gray-500 uppercase font-bold">Alamat Lengkap (Jalan,
                                    RT/RW)</label>
                                <textarea name="address_line1" x-model="form.address_line1" rows="2" required
                                    placeholder="Nama Jalan, No. Rumah, RT/RW"
                                    class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black focus:border-black"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-bold">Kode Pos</label>
                                    <input type="text" name="postal_code" x-model="form.postal_code" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black focus:border-black">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-bold">Patokan (Opsional)</label>
                                    <input type="text" name="address_line2" x-model="form.address_line2"
                                        placeholder="Warna pagar, dekat masjid..."
                                        class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg focus:ring-black focus:border-black">
                                </div>
                            </div>

                            <div x-show="!form.is_primary" class="flex items-center gap-2 pt-2">
                                <input type="checkbox" name="is_primary" id="is_primary" value="1"
                                    class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                                <label for="is_primary" class="text-sm text-gray-700">Jadikan Alamat Utama</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="showModal = false"
                                class="px-5 py-2.5 rounded-xl text-gray-600 font-medium hover:bg-gray-100">Batal</button>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-black text-white font-bold hover:bg-gray-800 transition-transform active:scale-95 shadow-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addressManager() {
            return {
                showModal: false,
                isEdit: false,
                form: {
                    id: null,
                    recipient_name: '',
                    phone_number: '',
                    address_line1: '',
                    address_line2: '',
                    province: '',
                    city: '',
                    district: '',
                    village: '',
                    postal_code: '',
                    label: 'Rumah',
                    is_primary: false
                },

                // Data Wilayah
                provinces: [],
                cities: [],
                districts: [],
                villages: [],

                // ID Terpilih (untuk fetch API selanjutnya)
                selectedProvId: '',
                selectedCityId: '',
                selectedDistrictId: '',
                selectedVillageId: '',

                init() {
                    this.fetchProvinces();
                },

                openModal(address = null) {
                    this.showModal = true;
                    if (address) {
                        this.isEdit = true;
                        this.form = JSON.parse(JSON.stringify(address)); // Clone object
                        // Note: Untuk Edit, dropdown tidak otomatis ter-select karena kita cuma simpan NAMA di DB, bukan ID.
                        // User harus memilih ulang jika ingin mengganti wilayah.
                        // Tapi input hidden tetap terisi data lama, jadi aman kalau user tidak mengubah wilayah.
                    } else {
                        this.isEdit = false;
                        this.resetForm();
                    }
                },

                resetForm() {
                    this.form = {
                        id: null,
                        recipient_name: '',
                        phone_number: '',
                        address_line1: '',
                        address_line2: '',
                        province: '',
                        city: '',
                        district: '',
                        village: '',
                        postal_code: '',
                        label: 'Rumah',
                        is_primary: false
                    };
                    this.selectedProvId = '';
                    this.selectedCityId = '';
                    this.selectedDistrictId = '';
                    this.selectedVillageId = '';
                },

                // --- API FETCHING (EMSIFA) ---
                async fetchProvinces() {
                    let res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    this.provinces = await res.json();
                },

                async fetchCities() {
                    if (!this.selectedProvId) return;
                    // Set Nama Provinsi ke Input Hidden
                    let prov = this.provinces.find(p => p.id == this.selectedProvId);
                    if (prov) this.form.province = prov.name;

                    let res = await fetch(
                        `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selectedProvId}.json`);
                    this.cities = await res.json();
                    this.districts = [];
                    this.villages = []; // Reset anak
                },

                async fetchDistricts() {
                    if (!this.selectedCityId) return;
                    // Set Nama Kota
                    let city = this.cities.find(c => c.id == this.selectedCityId);
                    if (city) this.form.city = city.name;

                    let res = await fetch(
                        `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedCityId}.json`);
                    this.districts = await res.json();
                    this.villages = []; // Reset anak
                },

                async fetchVillages() {
                    if (!this.selectedDistrictId) return;
                    // Set Nama Kecamatan
                    let dist = this.districts.find(d => d.id == this.selectedDistrictId);
                    if (dist) this.form.district = dist.name;

                    let res = await fetch(
                        `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selectedDistrictId}.json`);
                    this.villages = await res.json();
                },

                setVillageName() {
                    // Set Nama Kelurahan
                    let vill = this.villages.find(v => v.id == this.selectedVillageId);
                    if (vill) this.form.village = vill.name;
                }
            }
        }
    </script>
@endsection
