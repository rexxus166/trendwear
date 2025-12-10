@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div x-data="{ 
        showProductModal: false, 
        showEditModal: false, 
        showCategoryModal: false,
        files: [],
        dt: new DataTransfer(),

        // Form Edit
        editForm: {
            id: null, name: '', category_id: '', price: '', stock: '', sku: '', description: '', status: '', actionUrl: '', existingImages: [],
            options: [], sizes: [], colors: [] 
        },

        // Helper Tag Input
        tagInput(initialTags = []) {
            return {
                tags: initialTags,
                newTag: '',
                addTag() {
                    if (this.newTag.trim() !== '' && !this.tags.includes(this.newTag.trim())) {
                        this.tags.push(this.newTag.trim());
                    }
                    this.newTag = '';
                },
                removeTag(index) {
                    this.tags.splice(index, 1);
                },
                // Menggabungkan tags jadi string 'S,M,L' untuk dikirim ke backend
                get valueString() {
                    return this.tags.join(',');
                }
            }
        },

        handleFileSelect(event) {
            const input = event.target;
            const newFiles = Array.from(input.files);
            newFiles.forEach(file => {
                this.dt.items.add(file);
                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    this.files.push({url: URL.createObjectURL(file), type: file.type, name: file.name});
                }
            });
            if(this.$refs.mediaInput) this.$refs.mediaInput.files = this.dt.files;
            if(this.$refs.mediaInputEdit) this.$refs.mediaInputEdit.files = this.dt.files;
        },

        removeFile(index) {
            this.files.splice(index, 1);
            this.dt.items.remove(index);
            if(this.$refs.mediaInput) this.$refs.mediaInput.files = this.dt.files;
            if(this.$refs.mediaInputEdit) this.$refs.mediaInputEdit.files = this.dt.files;
        },

        resetAddModal() {
            this.showProductModal = true; 
            this.files = []; 
            this.dt = new DataTransfer(); 
        },
        
        openEditModal(product) {
            this.editForm.id = product.id;
            this.editForm.name = product.name;
            this.editForm.category_id = product.category_id;
            this.editForm.price = product.price;
            this.editForm.stock = product.stock;
            this.editForm.sku = product.sku;
            this.editForm.description = product.description;
            this.editForm.status = product.status;
            this.editForm.actionUrl = '/admin/products/' + product.id;
            this.editForm.existingImages = product.images; 
            
            this.files = [];
            this.dt = new DataTransfer();
            
            // --- FIX PENTING: MENGIRIM DATA VARIAN KE KOMPONEN INPUT ---
            let optionsData = product.options || [];
            let sizesData = product.sizes || [];
            let colorsData = product.colors || [];
            
            this.$nextTick(() => {
                // Kita kirim sinyal (dispatch) agar input tag di modal edit merespon
                this.$dispatch('set-edit-options', optionsData);
                this.$dispatch('set-edit-sizes', sizesData);
                this.$dispatch('set-edit-colors', colorsData);
            });

            this.showEditModal = true;
        },

        async deleteImage(imageId, index) {
            if(!confirm('Delete image?')) return;
            try {
                let response = await fetch('/admin/product-images/' + imageId, { 
                    method: 'DELETE', 
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' } 
                });
                if (response.ok) this.editForm.existingImages.splice(index, 1);
            } catch (error) { console.error(error); }
        }
    }">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-5 right-5 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg transition-all">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="fixed top-5 right-5 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg max-w-sm">
                <p class="font-bold">Error</p><ul class="text-sm list-disc pl-4">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div><h1 class="text-2xl font-bold mb-1">Products</h1><p class="text-gray-600">Manage your product inventory</p></div>
                <div class="flex gap-3">
                    <button @click="showCategoryModal = true" class="px-6 py-3 border border-gray-200 bg-white text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium flex items-center gap-2">Add Category</button>
                    <button @click="resetAddModal()" class="px-6 py-3 bg-black text-white rounded-xl hover:bg-gray-800 transition-colors font-medium flex items-center gap-2">+ Add New Product</button>
                </div>
            </div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Variants</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($product->images->isNotEmpty())
                                            @if($product->images->first()->file_type == 'video') <video src="{{ asset('storage/' . $product->images->first()->file_path) }}" class="w-12 h-12 rounded-lg object-cover"></video>
                                            @else <img src="{{ asset('storage/' . $product->images->first()->file_path) }}" class="w-12 h-12 rounded-lg object-cover"> @endif
                                        @else <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">No Img</div> @endif
                                        <div><p class="font-medium text-sm truncate max-w-[200px]">{{ $product->name }}</p><p class="text-xs text-gray-500">{{ $product->sku }}</p></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $product->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-wrap gap-1 max-w-[150px]">
                                        @if($product->sizes) @foreach($product->sizes as $size) <span class="px-1.5 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded border">{{ $size }}</span> @endforeach @endif
                                        @if($product->colors) @foreach($product->colors as $color) <span class="px-1.5 py-0.5 bg-black text-white text-[10px] rounded">{{ $color }}</span> @endforeach @endif
                                        @if(!$product->sizes && !$product->colors) - @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm">{{ $product->stock }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium {{ $product->status == 'active' ? 'bg-green-100 text-green-600' : ($product->status == 'draft' ? 'bg-gray-100 text-gray-600' : 'bg-red-100 text-red-600') }}">
                                        {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button @click="openEditModal({{ $product->load('images') }})" class="p-2 hover:bg-gray-100 rounded-lg text-gray-500 hover:text-black transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete product?')">@csrf @method('DELETE')<button type="submit" class="p-2 hover:bg-red-50 rounded-lg text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No products found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">{{ $products->links() }}</div>
            </div>
        </div>

        <div x-show="showProductModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div @click.outside="showProductModal = false" class="bg-white rounded-2xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-xl font-bold">Add New Product</h3>
                    <button @click="showProductModal = false" class="text-gray-400 hover:text-gray-600">X</button>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium mb-2">Product Media</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:bg-gray-50 relative">
                                <input type="file" name="media[]" multiple x-ref="mediaInput" @change="handleFileSelect" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-sm text-gray-500">Drag & drop or click to upload</p>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mt-4" x-show="files.length > 0">
                                <template x-for="(file, index) in files" :key="index"><div class="relative aspect-square rounded-xl overflow-hidden border border-gray-200"><img :src="file.url" class="w-full h-full object-cover"></div></template>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <h4 class="font-bold text-sm mb-4">Variations (Optional)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div x-data="tagInput()">
                                    <label class="block text-sm font-medium mb-2">Opsi Tambahan</label>
                                    <div class="flex flex-wrap gap-2 p-2 bg-white border rounded-xl focus-within:ring-2 focus-within:ring-black">
                                        <template x-for="(tag, index) in tags" :key="index">
                                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded flex items-center gap-1"><span x-text="tag"></span><button type="button" @click="removeTag(index)" class="text-gray-500 hover:text-red-500">&times;</button></span>
                                        </template>
                                        <input type="text" x-model="newTag" @keydown.enter.prevent="addTag()" @keydown.comma.prevent="addTag()" placeholder="Panjang, Pendek, ..." class="flex-1 outline-none text-sm bg-transparent min-w-[60px]">
                                    </div>
                                    <input type="hidden" name="options" :value="valueString">
                                </div>
                                <div x-data="tagInput()">
                                    <label class="block text-sm font-medium mb-2">Sizes (Type & Enter)</label>
                                    <div class="flex flex-wrap gap-2 p-2 bg-white border rounded-xl focus-within:ring-2 focus-within:ring-black">
                                        <template x-for="(tag, index) in tags" :key="index">
                                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded flex items-center gap-1"><span x-text="tag"></span><button type="button" @click="removeTag(index)" class="text-gray-500 hover:text-red-500">&times;</button></span>
                                        </template>
                                        <input type="text" x-model="newTag" @keydown.enter.prevent="addTag()" @keydown.comma.prevent="addTag()" placeholder="S, M, L..." class="flex-1 outline-none text-sm bg-transparent min-w-[60px]">
                                    </div>
                                    <input type="hidden" name="sizes" :value="valueString">
                                </div>
                                <div x-data="tagInput()">
                                    <label class="block text-sm font-medium mb-2">Colors (Type & Enter)</label>
                                    <div class="flex flex-wrap gap-2 p-2 bg-white border rounded-xl focus-within:ring-2 focus-within:ring-black">
                                        <template x-for="(tag, index) in tags" :key="index">
                                            <span class="bg-black text-white text-xs font-semibold px-2 py-1 rounded flex items-center gap-1"><span x-text="tag"></span><button type="button" @click="removeTag(index)" class="text-white hover:text-gray-300">&times;</button></span>
                                        </template>
                                        <input type="text" x-model="newTag" @keydown.enter.prevent="addTag()" @keydown.comma.prevent="addTag()" placeholder="Red, Blue..." class="flex-1 outline-none text-sm bg-transparent min-w-[60px]">
                                    </div>
                                    <input type="hidden" name="colors" :value="valueString">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Product Name</label><input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div><label class="block text-sm font-medium mb-2">Category</label><select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"><option value="">Select Category</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
                            <div><label class="block text-sm font-medium mb-2">Price (IDR)</label><input type="number" name="price" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Description</label><textarea name="description" rows="4" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></textarea></div>
                            <div><label class="block text-sm font-medium mb-2">Stock</label><input type="number" name="stock" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div><label class="block text-sm font-medium mb-2">SKU</label><input type="text" name="sku" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                        </div>
                        <div class="flex gap-3 pt-4 border-t border-gray-100"><button type="button" @click="showProductModal = false" class="flex-1 px-6 py-3 border rounded-xl">Cancel</button><button type="submit" class="flex-1 px-6 py-3 bg-black text-white rounded-xl">Save Product</button></div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div @click.outside="showEditModal = false" class="bg-white rounded-2xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-xl font-bold">Edit Product</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">X</button>
                </div>
                
                <div class="p-6">
                    <form :action="editForm.actionUrl" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf @method('PUT')
                        
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <label class="block text-sm font-bold mb-2">Product Status</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="status" value="active" x-model="editForm.status" class="w-4 h-4 text-green-600"><span class="text-sm font-medium text-green-700">Aktif</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="status" value="draft" x-model="editForm.status" class="w-4 h-4 text-gray-600"><span class="text-sm font-medium text-gray-700">Arsip</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="status" value="out_of_stock" x-model="editForm.status" class="w-4 h-4 text-red-600"><span class="text-sm font-medium text-red-700">Out of Stock</span></label>
                            </div>
                        </div>

                        <div x-show="editForm.existingImages.length > 0">
                            <label class="block text-sm font-medium mb-2">Existing Media</label>
                            <div class="grid grid-cols-4 gap-4">
                                <template x-for="(img, index) in editForm.existingImages" :key="img.id">
                                    <div class="relative aspect-square rounded-xl overflow-hidden border border-gray-200 group">
                                        <template x-if="img.file_type === 'image'"><img :src="'/storage/' + img.file_path" class="w-full h-full object-cover"></template>
                                        <template x-if="img.file_type === 'video'"><video :src="'/storage/' + img.file_path" class="w-full h-full object-cover"></video></template>
                                        <button type="button" @click="deleteImage(img.id, index)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Add More Media</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-4 text-center hover:bg-gray-50 relative">
                                <input type="file" name="media[]" multiple x-ref="mediaInputEdit" @change="function(e) { const input = e.target; const newFiles = Array.from(input.files); newFiles.forEach(file => { this.dt.items.add(file); if (file.type.startsWith('image/')) { this.files.push({ url: URL.createObjectURL(file), type: file.type, name: file.name }); } }); this.$refs.mediaInputEdit.files = this.dt.files; }" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <p class="text-sm text-gray-500">Click to upload new images</p>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mt-4" x-show="files.length > 0"><template x-for="(file, index) in files" :key="index"><div class="relative aspect-square rounded-xl overflow-hidden border border-gray-200"><img :src="file.url" class="w-full h-full object-cover"></div></template></div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <h4 class="font-bold text-sm mb-4">Variations (Optional)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div x-data="tagInput()" @set-edit-options.window="tags = $event.detail">
                                    <label class="block text-sm font-medium mb-2">Opsi Tambahan</label>
                                    <div class="flex flex-wrap gap-2 p-2 bg-white border rounded-xl focus-within:ring-2 focus-within:ring-black">
                                        <template x-for="(tag, index) in tags" :key="index">
                                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded flex items-center gap-1"><span x-text="tag"></span><button type="button" @click="removeTag(index)" class="text-gray-500 hover:text-red-500">&times;</button></span>
                                        </template>
                                        <input type="text" x-model="newTag" @keydown.enter.prevent="addTag()" @keydown.comma.prevent="addTag()" class="flex-1 outline-none text-sm bg-transparent min-w-[60px]">
                                    </div>
                                    <input type="hidden" name="options" :value="valueString">
                                </div>
                                <div x-data="tagInput()" @set-edit-sizes.window="tags = $event.detail">
                                    <label class="block text-sm font-medium mb-2">Sizes</label>
                                    <div class="flex flex-wrap gap-2 p-2 bg-white border rounded-xl focus-within:ring-2 focus-within:ring-black">
                                        <template x-for="(tag, index) in tags" :key="index">
                                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded flex items-center gap-1"><span x-text="tag"></span><button type="button" @click="removeTag(index)" class="text-gray-500 hover:text-red-500">&times;</button></span>
                                        </template>
                                        <input type="text" x-model="newTag" @keydown.enter.prevent="addTag()" @keydown.comma.prevent="addTag()" class="flex-1 outline-none text-sm bg-transparent min-w-[60px]">
                                    </div>
                                    <input type="hidden" name="sizes" :value="valueString">
                                </div>
                                <div x-data="tagInput()" @set-edit-colors.window="tags = $event.detail">
                                    <label class="block text-sm font-medium mb-2">Colors</label>
                                    <div class="flex flex-wrap gap-2 p-2 bg-white border rounded-xl focus-within:ring-2 focus-within:ring-black">
                                        <template x-for="(tag, index) in tags" :key="index">
                                            <span class="bg-black text-white text-xs font-semibold px-2 py-1 rounded flex items-center gap-1"><span x-text="tag"></span><button type="button" @click="removeTag(index)" class="text-white hover:text-gray-300">&times;</button></span>
                                        </template>
                                        <input type="text" x-model="newTag" @keydown.enter.prevent="addTag()" @keydown.comma.prevent="addTag()" class="flex-1 outline-none text-sm bg-transparent min-w-[60px]">
                                    </div>
                                    <input type="hidden" name="colors" :value="valueString">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Product Name</label><input type="text" name="name" x-model="editForm.name" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div><label class="block text-sm font-medium mb-2">Category</label><select name="category_id" x-model="editForm.category_id" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"><option value="">Select Category</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
                            <div><label class="block text-sm font-medium mb-2">Price (IDR)</label><input type="number" name="price" x-model="editForm.price" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Description</label><textarea name="description" x-model="editForm.description" rows="4" class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></textarea></div>
                            <div><label class="block text-sm font-medium mb-2">Stock</label><input type="number" name="stock" x-model="editForm.stock" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                            <div><label class="block text-sm font-medium mb-2">SKU</label><input type="text" name="sku" x-model="editForm.sku" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl"></div>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100"><button type="button" @click="showEditModal = false" class="flex-1 px-6 py-3 border rounded-xl">Cancel</button><button type="submit" class="flex-1 px-6 py-3 bg-black text-white rounded-xl">Update Product</button></div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showCategoryModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div @click.outside="showCategoryModal = false" class="bg-white rounded-2xl max-w-md w-full mx-4 overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-xl font-bold">Add New Category</h3>
                    <button @click="showCategoryModal = false" class="text-gray-400 hover:text-gray-600">X</button>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div><label class="block text-sm font-medium mb-2">Category Name</label><input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-200"></div>
                            <div><label class="block text-sm font-medium mb-2">Category Image</label><input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-200"></div>
                        </div>
                        <div class="flex gap-3 pt-6"><button type="button" @click="showCategoryModal = false" class="flex-1 px-6 py-3 border rounded-xl">Cancel</button><button type="submit" class="flex-1 px-6 py-3 bg-black text-white rounded-xl">Save Category</button></div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection