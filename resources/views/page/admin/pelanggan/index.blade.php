@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
    <header class="bg-white border-b border-gray-200 px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-1">Customers</h1>
                <p class="text-gray-600">Manage your customer base and history</p>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV
                </button>
                <button class="px-6 py-2 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium text-sm">
                    Add Customer
                </button>
            </div>
        </div>
    </header>

    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Customers</p>
                        <p class="text-2xl font-bold">2,847</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">New This Month</p>
                        <p class="text-2xl font-bold">+145</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Members</p>
                        <p class="text-2xl font-bold">1,890</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Blocked Users</p>
                        <p class="text-2xl font-bold">12</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Search by name, email, or phone..." class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
                <select class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black min-w-[160px]">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Blocked</option>
                </select>
                <select class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black min-w-[160px]">
                    <option>Sort by: Newest</option>
                    <option>Sort by: Orders</option>
                    <option>Sort by: Spent</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer Info</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Orders</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Spent</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Alex+Johnson&background=random" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900">Alex Johnson</p>
                                        <p class="text-xs text-gray-500">alex.j@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">+62 812 3456 7890</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Dec 12, 2024</td>
                            <td class="px-6 py-4 text-sm font-medium">12</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp 4.500.000</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">Active</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-gray-400 hover:text-black transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Mitchell&background=random" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900">Sarah Mitchell</p>
                                        <p class="text-xs text-gray-500">sarah.m@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">+62 813 9988 7766</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Jan 05, 2025</td>
                            <td class="px-6 py-4 text-sm font-medium">5</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp 1.250.000</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">Active</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-gray-400 hover:text-black transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900">Budi Santoso</p>
                                        <p class="text-xs text-gray-500">budi.s@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">-</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Oct 20, 2024</td>
                            <td class="px-6 py-4 text-sm font-medium">0</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp 0</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-700 text-xs rounded-full font-medium">Blocked</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-gray-400 hover:text-black transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <p class="text-sm text-gray-600">Showing 1-3 of 2,847 customers</p>
                <div class="flex gap-2">
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm">Previous</button>
                    <button class="px-3 py-2 bg-black text-white rounded-lg text-sm">1</button>
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm">2</button>
                    <button class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection