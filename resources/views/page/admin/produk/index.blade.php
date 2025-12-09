@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div x-data="{ showModal: false }">
        
        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">Products</h1>
                    <p class="text-gray-600">Manage your product inventory</p>
                </div>
                <button @click="showModal = true" class="px-6 py-3 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Product
                </button>
            </div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" placeholder="Search products..." class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <select class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        <option>All Categories</option>
                        <option>Outerwear</option>
                        <option>T-Shirts</option>
                        <option>Denim</option>
                        <option>Footwear</option>
                    </select>
                    <select class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Draft</option>
                        <option>Out of Stock</option>
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1648483098902-7af8f711498f?w=100" class="w-12 h-12 rounded-lg object-cover">
                                        <div>
                                            <p class="font-medium text-sm">Essential White Tee</p>
                                            <p class="text-xs text-gray-500">SKU: TW-001</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">T-Shirts</td>
                                <td class="px-6 py-4 text-sm font-semibold">Rp 299.000</td>
                                <td class="px-6 py-4 text-sm">234</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Active</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1588011025378-15f4778d2558?w=100" class="w-12 h-12 rounded-lg object-cover">
                                        <div>
                                            <p class="font-medium text-sm">Classic Black Jacket</p>
                                            <p class="text-xs text-gray-500">SKU: TW-002</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">Outerwear</td>
                                <td class="px-6 py-4 text-sm font-semibold">Rp 899.000</td>
                                <td class="px-6 py-4 text-sm">89</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full font-medium">Active</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1631984564919-1f6b2313a71c?w=100" class="w-12 h-12 rounded-lg object-cover">
                                        <div>
                                            <p class="font-medium text-sm">Urban Sneakers</p>
                                            <p class="text-xs text-gray-500">SKU: TW-003</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">Footwear</td>
                                <td class="px-6 py-4 text-sm font-semibold">Rp 1.299.000</td>
                                <td class="px-6 py-4 text-sm text-orange-600 font-medium">12</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-orange-100 text-orange-600 text-xs rounded-full font-medium">Low Stock</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://images.unsplash.com/photo-1761891873744-eb181eb1334a?w=100" class="w-12 h-12 rounded-lg object-cover">
                                        <div>
                                            <p class="font-medium text-sm">Vintage Denim</p>
                                            <p class="text-xs text-gray-500">SKU: TW-004</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">Denim</td>
                                <td class="px-6 py-4 text-sm font-semibold">Rp 649.000</td>
                                <td class="px-6 py-4 text-sm text-red-600 font-medium">0</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full font-medium">Out of Stock</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-600">Showing 1-4 of 856 products</p>
                    <div class="flex gap-2">
                        <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Previous</button>
                        <button class="px-3 py-2 bg-black text-white rounded-lg">1</button>
                        <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                        <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                        <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showModal" 
             x-cloak
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            
            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.outside="showModal = false"
                 class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-xl font-bold">Add New Product</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Product Name</label>
                            <input type="text" placeholder="e.g., Essential White Tee" class="w-full px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Category</label>
                                <select class="w-full px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                                    <option>Select category</option>
                                    <option>Outerwear</option>
                                    <option>T-Shirts</option>
                                    <option>Denim</option>
                                    <option>Footwear</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Price</label>
                                <input type="number" placeholder="299000" class="w-full px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Description</label>
                            <textarea rows="4" placeholder="Product description..." class="w-full px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Stock Quantity</label>
                                <input type="number" placeholder="100" class="w-full px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">SKU</label>
                                <input type="text" placeholder="TW-005" class="w-full px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button type="button" @click="showModal = false" class="flex-1 px-6 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-colors font-medium">Cancel</button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection