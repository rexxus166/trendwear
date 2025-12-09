@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-1">Analytics</h1>
                <p class="text-gray-600">Performance metrics and reports</p>
            </div>
            <div class="flex gap-3">
                <select class="px-4 py-2 border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-black">
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option>This Year</option>
                </select>
                <button class="px-4 py-2 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors text-sm font-medium">
                    Download Report
                </button>
            </div>
        </div>
    </header>

    <div class="p-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="p-6 bg-black text-white rounded-2xl shadow-lg">
                <p class="text-white/60 text-sm font-medium mb-2">Total Revenue</p>
                <h3 class="text-3xl font-bold mb-4">Rp 124.5M</h3>
                <div class="flex items-center text-sm text-green-400">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>+12.5% vs last month</span>
                </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm">
                <p class="text-gray-500 text-sm font-medium mb-2">Total Orders</p>
                <h3 class="text-3xl font-bold mb-4">1,482</h3>
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>+5.2% vs last month</span>
                </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm">
                <p class="text-gray-500 text-sm font-medium mb-2">Avg. Order Value</p>
                <h3 class="text-3xl font-bold mb-4">Rp 450k</h3>
                <div class="flex items-center text-sm text-red-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    <span>-2.1% vs last month</span>
                </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm">
                <p class="text-gray-500 text-sm font-medium mb-2">Conversion Rate</p>
                <h3 class="text-3xl font-bold mb-4">3.2%</h3>
                <div class="flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>+0.8% vs last month</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-bold text-lg">Revenue Overview</h3>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="w-3 h-3 bg-black rounded-full"></span> <span>Current</span>
                        <span class="w-3 h-3 bg-gray-200 rounded-full ml-2"></span> <span>Previous</span>
                    </div>
                </div>
                
                <div class="h-72 flex items-end justify-between gap-2 lg:gap-4 px-2">
                    @for ($i = 0; $i < 7; $i++)
                    <div class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                        <div class="w-full flex items-end justify-center gap-1 h-full relative">
                            <div class="absolute bottom-0 w-full border-b border-gray-100 h-full -z-10"></div>
                            
                            <div style="height: {{ rand(30, 60) }}%" class="w-3 lg:w-6 bg-gray-200 rounded-t-sm"></div>
                            <div style="height: {{ rand(40, 90) }}%" class="w-3 lg:w-6 bg-black rounded-t-sm hover:bg-gray-800 transition-colors relative">
                                <div class="opacity-0 group-hover:opacity-100 absolute -top-10 left-1/2 -translate-x-1/2 bg-black text-white text-xs py-1 px-2 rounded whitespace-nowrap pointer-events-none transition-opacity z-10">
                                    Rp {{ rand(10, 50) }}M
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">Day {{ $i+1 }}</span>
                    </div>
                    @endfor
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-lg mb-6">Traffic Source</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Direct</span>
                            <span class="text-gray-500">45%</span>
                        </div>
                        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div style="width: 45%" class="h-full bg-black rounded-full"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Social Media</span>
                            <span class="text-gray-500">32%</span>
                        </div>
                        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div style="width: 32%" class="h-full bg-purple-500 rounded-full"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Organic Search</span>
                            <span class="text-gray-500">18%</span>
                        </div>
                        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div style="width: 18%" class="h-full bg-blue-500 rounded-full"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Referral</span>
                            <span class="text-gray-500">5%</span>
                        </div>
                        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div style="width: 5%" class="h-full bg-orange-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="font-bold text-sm mb-4">Top Locations</h4>
                    <ul class="space-y-3">
                        <li class="flex justify-between text-sm">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500"></span> Jakarta</span>
                            <span class="text-gray-600 font-medium">12,403</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Surabaya</span>
                            <span class="text-gray-600 font-medium">8,200</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span> Bandung</span>
                            <span class="text-gray-600 font-medium">5,105</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-lg">Best Selling Products</h3>
                <a href="#" class="text-sm font-medium text-black hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Sold</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1648483098902-7af8f711498f?w=100" class="w-10 h-10 rounded-lg object-cover">
                                    <span class="font-medium text-sm">Essential White Tee</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">T-Shirts</td>
                            <td class="px-6 py-4 text-sm">Rp 299.000</td>
                            <td class="px-6 py-4 text-sm font-bold">1,234</td>
                            <td class="px-6 py-4 text-sm font-bold text-green-600">Rp 368.9M</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1631984564919-1f6b2313a71c?w=100" class="w-10 h-10 rounded-lg object-cover">
                                    <span class="font-medium text-sm">Urban Sneakers</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">Footwear</td>
                            <td class="px-6 py-4 text-sm">Rp 1.299.000</td>
                            <td class="px-6 py-4 text-sm font-bold">856</td>
                            <td class="px-6 py-4 text-sm font-bold text-green-600">Rp 1.1B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection