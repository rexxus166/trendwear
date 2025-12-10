@extends('layouts.admin')

@section('title', 'Customers')

@section('content')

    <div x-data="{
        showModal: false,
        isEdit: false,
        form: { id: null, name: '', email: '', phone: '', password: '', status: 'active' },
    
        openAddModal() {
            this.showModal = true;
            this.isEdit = false;
            this.form = { id: null, name: '', email: '', phone: '', password: '', status: 'active' };
        },
    
        openEditModal(customer) {
            this.showModal = true;
            this.isEdit = true;
            // Copy data customer ke form
            this.form = {
                id: customer.id,
                name: customer.name,
                email: customer.email,
                phone: customer.phone,
                password: '', // Password kosongkan saat edit
                status: customer.status
            };
        }
    }">
        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">Customers</h1>
                    <p class="text-gray-600">Manage your customer base and history</p>
                </div>
                <div class="flex gap-3">
                    <button
                        class="px-4 py-2 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Export CSV
                    </button>
                    <button @click="openAddModal()"
                        class="px-6 py-2 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Customer
                    </button>
                </div>
            </div>
        </header>

        <div class="p-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2"><svg
                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-6">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg mb-6">
                    <ul class="list-disc pl-4 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg></div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Customers</p>
                            <p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg></div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">New This Month</p>
                            <p class="text-2xl font-bold">+{{ $stats['new_this_month'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg></div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Active Members</p>
                            <p class="text-2xl font-bold">{{ $stats['active'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-orange-50 rounded-xl text-orange-600"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                </path>
                            </svg></div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Blocked Users</p>
                            <p class="text-2xl font-bold">{{ $stats['blocked'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
                <form action="{{ route('admin.customers') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, email, or phone..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <select name="status" onchange="this.form.submit()"
                        class="px-4 py-3 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-black min-w-[160px]">
                        <option {{ request('status') == 'All Status' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                    @if (request('search') || (request('status') && request('status') != 'All Status'))
                        <a href="{{ route('admin.customers') }}"
                            class="px-4 py-3 bg-gray-100 rounded-xl text-gray-600 hover:bg-gray-200 flex items-center justify-center">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Customer Info</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Phone</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Joined Date</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($customers as $customer)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random&color=fff"
                                                class="w-10 h-10 rounded-full">
                                            <div>
                                                <p class="font-semibold text-sm text-gray-900">{{ $customer->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $customer->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = match ($customer->status) {
                                                'active' => 'bg-green-100 text-green-700',
                                                'inactive' => 'bg-gray-100 text-gray-700',
                                                'blocked' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="px-2.5 py-0.5 text-xs rounded-full font-medium {{ $statusColor }}">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="openEditModal({{ $customer }})"
                                                class="text-gray-400 hover:text-black transition-colors p-1"
                                                title="Edit Customer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <form action="{{ route('admin.customers.destroy', $customer->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure want to delete this customer?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-red-500 transition-colors p-1"
                                                    title="Delete User">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No customers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">{{ $customers->links() }}</div>
            </div>
        </div>

        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg w-full">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold leading-6 text-gray-900"
                            x-text="isEdit ? 'Edit Customer' : 'Add New Customer'"></h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-500"><svg class="h-6 w-6"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg></button>
                    </div>

                    <form :action="isEdit ? '/admin/customers/' + form.id : '{{ route('admin.customers.store') }}'"
                        method="POST" class="p-6">
                        @csrf
                        <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" x-model="form.name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" x-model="form.email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" x-model="form.phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                    x-text="isEdit ? 'Password (Leave blank to keep current)' : 'Password'"></label>
                                <input type="password" name="password" x-model="form.password" :required="!isEdit"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" x-model="form.status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="blocked">Blocked</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 rounded-lg text-gray-600 font-medium hover:bg-gray-100">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-black text-white font-bold hover:bg-gray-800 shadow-lg">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
