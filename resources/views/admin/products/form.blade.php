{{-- resources/views/admin/products/form.blade.php --}}
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </a>
        </div>

        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
            method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            {{-- Category & SKU --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm
                                   @error('category_id') border-red-300 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        SKU <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
                        placeholder="PRD-XXXXXXXX" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm
                                  @error('sku') border-red-300 @enderror">
                    @error('sku')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Product Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                    placeholder="Masukkan nama produk" required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all
                              @error('name') border-red-300 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" placeholder="Deskripsi produk..."
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm resize-none">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            {{-- Price, Stock, Min Stock --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <span
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                            step="100" min="0" required
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm
                                      @error('price') border-red-300 @enderror">
                    </div>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                        min="0" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm
                                  @error('stock') border-red-300 @enderror">
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Minimal Stok <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock ?? 10) }}"
                        min="1" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm
                                  @error('min_stock') border-red-300 @enderror">
                    @error('min_stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                <div class="flex items-center gap-4">
                    @if (isset($product) && $product->image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-20 h-20 object-cover rounded-xl">
                            <div
                                class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <i class="fas fa-camera text-white"></i>
                            </div>
                        </div>
                    @endif
                    <label class="flex-1">
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-emerald-400 transition-colors cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-400">JPG, PNG, GIF (Max. 2MB)</p>
                        </div>
                        <input type="file" name="image" accept="image/*" class="hidden">
                    </label>
                </div>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active Status --}}
            <div class="flex items-center gap-3">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-300
                                rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white
                                after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5
                                after:transition-all peer-checked:bg-emerald-600">
                    </div>
                </label>
                <div>
                    <p class="text-sm font-medium text-gray-700">Produk Aktif</p>
                    <p class="text-xs text-gray-500">Produk dapat dijual dan ditampilkan</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-3 text-gray-600 hover:text-gray-800 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-all text-sm font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="bg-gradient-to-r from-green-500 to-green-500 text-white px-6 py-3 rounded-xl
                               font-medium hover:from-green-500 hover:to-green-500 transition-all shadow-sm text-sm">
                    <i class="fas fa-save mr-2"></i>
                    {{ isset($product) ? 'Update Produk' : 'Simpan Produk' }}
                </button>
            </div>
        </form>
    </div>
</div>
