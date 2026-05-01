{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition-colors ml-2">Dashboard</a>
    <span class="text-gray-400 ml-2">/</span>
    <span class="text-gray-800 font-medium ml-2">Kategori</span>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Add Category Form --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-emerald-500"></i>
                    Tambah Kategori
                </h3>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required placeholder="Masukkan nama kategori"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm
                                  @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" placeholder="Deskripsi kategori (opsional)"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm resize-none"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 text-white py-3 rounded-xl
                               font-semibold hover:from-emerald-700 hover:to-emerald-600 transition-all shadow-sm text-sm">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori
                    </button>
                </form>

                {{-- Info Card --}}
                <div class="mt-6 p-4 bg-amber-50 rounded-2xl">
                    <p class="text-xs text-amber-800 flex items-start gap-2">
                        <i class="fas fa-info-circle mt-0.5"></i>
                        <span>Kategori yang sudah memiliki produk tidak dapat dihapus.</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Categories List --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 lg:p-6 border-b">
                    <h3 class="font-bold text-gray-800 text-lg">Daftar Kategori</h3>
                    <p class="text-sm text-gray-500 mt-1">Total: {{ $categories->total() }} kategori</p>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <div class="p-5 lg:p-6 hover:bg-gray-50/50 transition-colors group" x-data="{ editing: false }">

                            {{-- View Mode --}}
                            <div x-show="!editing">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div
                                                class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                                <i class="fas fa-folder text-emerald-600"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-800">{{ $category->name }}</h4>
                                                <p class="text-xs text-gray-400 font-mono">{{ $category->slug }}</p>
                                            </div>
                                        </div>

                                        @if ($category->description)
                                            <p class="text-sm text-gray-500 ml-13">{{ $category->description }}</p>
                                        @endif

                                        <div class="flex items-center gap-3 mt-3 ml-13">
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                                <i class="fas fa-box text-gray-400"></i>
                                                {{ $category->products_count }} produk
                                            </span>
                                            <span class="text-xs text-gray-300">|</span>
                                            <span class="text-xs text-gray-400">
                                                Dibuat {{ $category->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <button @click="editing = true"
                                            class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400
                                                   hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                                            title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400
                                                       hover:text-red-600 hover:bg-red-50 transition-all"
                                                {{ $category->products_count > 0 ? 'disabled' : '' }}
                                                title="{{ $category->products_count > 0 ? 'Tidak bisa menghapus kategori yang memiliki produk' : 'Hapus' }}">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Edit Mode --}}
                            <div x-show="editing" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                                    class="space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Kategori</label>
                                        <input type="text" name="name" value="{{ $category->name }}" required
                                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
                                        <textarea name="description" rows="2"
                                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 text-sm resize-none">{{ $category->description }}</textarea>
                                    </div>

                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="bg-emerald-600 text-white px-4 py-2 rounded-xl hover:bg-emerald-700 transition-all text-sm font-medium">
                                            <i class="fas fa-check mr-1"></i>Simpan
                                        </button>
                                        <button type="button" @click="editing = false"
                                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-300 transition-all text-sm font-medium">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 lg:p-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tags text-gray-300 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Kategori</h3>
                            <p class="text-gray-500 text-sm">Tambahkan kategori pertama Anda untuk mulai mengorganisir
                                produk.</p>
                        </div>
                    @endforelse
                </div>

                @if ($categories->hasPages())
                    <div class="p-5 border-t">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
