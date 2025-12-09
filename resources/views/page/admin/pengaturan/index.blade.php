@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <div x-data="{ activeTab: 'general' }">
        
        <header class="bg-white border-b border-gray-200 px-8 py-6 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">Settings</h1>
                    <p class="text-gray-600">Manage store configuration and preferences</p>
                </div>
                <button class="px-6 py-2.5 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium shadow-lg shadow-gray-200">
                    Save Changes
                </button>
            </div>
            
            <div class="flex items-center gap-6 mt-6 border-b border-gray-100">
                <button @click="activeTab = 'general'" 
                        :class="activeTab === 'general' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors">
                    General Store
                </button>
                <button @click="activeTab = 'payment'" 
                        :class="activeTab === 'payment' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors">
                    Payment Methods
                </button>
                <button @click="activeTab = 'shipping'" 
                        :class="activeTab === 'shipping' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors">
                    Shipping & Delivery
                </button>
                <button @click="activeTab = 'security'" 
                        :class="activeTab === 'security' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-3 text-sm font-medium border-b-2 transition-colors">
                    Security
                </button>
            </div>
        </header>

        <div class="p-8 max-w-5xl">
            
            <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm mb-6">
                    <h3 class="text-lg font-bold mb-6">Store Information</h3>
                    
                    <div class="flex flex-col md:flex-row gap-8 mb-8">
                        <div class="w-full md:w-1/3">
                            <label class="block text-sm font-medium mb-3 text-gray-700">Store Logo</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer">
                                <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-black">Click to upload</p>
                                <p class="text-xs text-gray-500 mt-1">SVG, PNG, JPG (Max. 2MB)</p>
                            </div>
                        </div>

                        <div class="flex-1 space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-gray-700">Store Name</label>
                                    <input type="text" value="TrendWear Official" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-gray-700">Support Email</label>
                                    <input type="email" value="support@trendwear.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Store Description</label>
                                <textarea rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">Premium fashion for the urban explorer.</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100">
                        <h3 class="text-lg font-bold mb-6">Contact & Location</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Phone Number</label>
                                <input type="text" value="+62 812 3456 7890" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">City / Country</label>
                                <input type="text" value="Jakarta, Indonesia" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Full Address</label>
                            <input type="text" value="Jl. Sudirman No. 45, Jakarta Pusat" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'payment'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="space-y-4">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Bank Transfer</h4>
                                <p class="text-sm text-gray-500">Accept manual bank transfers (BCA, Mandiri, etc)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span>
                            <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">Configure</button>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Midtrans Payment Gateway</h4>
                                <p class="text-sm text-gray-500">Automated payments (CC, GoPay, QRIS)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Connected</span>
                            <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50">Manage</button>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Cash on Delivery (COD)</h4>
                                <p class="text-sm text-gray-500">Pay when order arrives</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-bold">Disabled</span>
                            <button class="px-4 py-2 text-sm bg-black text-white rounded-lg hover:bg-gray-800">Enable</button>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'shipping'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
                    <h3 class="text-lg font-bold mb-6">Shipping Methods</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between pb-6 border-b border-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-900">Flat Rate Shipping</h4>
                                <p class="text-sm text-gray-500">Fixed shipping cost for all orders</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="text" value="25000" class="block w-full rounded-lg border-gray-300 pl-10 focus:border-black focus:ring-black sm:text-sm py-2 bg-gray-50 border px-3">
                                </div>
                                <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="toggle1" checked class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-green-400 right-0"/>
                                    <label for="toggle1" class="toggle-label block overflow-hidden h-6 rounded-full bg-green-400 cursor-pointer"></label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pb-6 border-b border-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-900">Free Shipping</h4>
                                <p class="text-sm text-gray-500">Free shipping for orders over specific amount</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="text" value="500000" class="block w-full rounded-lg border-gray-300 pl-10 focus:border-black focus:ring-black sm:text-sm py-2 bg-gray-50 border px-3">
                                </div>
                                <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="toggle2" checked class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-green-400 right-0"/>
                                    <label for="toggle2" class="toggle-label block overflow-hidden h-6 rounded-full bg-green-400 cursor-pointer"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'security'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm max-w-2xl">
                    <h3 class="text-lg font-bold mb-6">Change Password</h3>
                    <form>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Current Password</label>
                                <input type="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">New Password</label>
                                <input type="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Confirm New Password</label>
                                <input type="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition-all">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button class="px-6 py-3 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Custom Toggle Switch Style for Shipping Tab */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #4ade80; /* green-400 */
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #4ade80; /* green-400 */
        }
        .toggle-checkbox {
            right: 24px; /* Default position */
            border-color: #e5e7eb; /* gray-200 */
            transition: all 0.3s;
        }
        .toggle-label {
            width: 48px;
            background-color: #e5e7eb; /* gray-200 */
        }
    </style>
@endsection