{{-- resources/views/partials/product-card.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;

    $categoryColors = [
        1 => ['bg' => 'from-amber-50 to-orange-50', 'icon' => 'text-amber-500', 'iconBg' => 'bg-amber-100'],
        2 => ['bg' => 'from-blue-50 to-cyan-50', 'icon' => 'text-blue-500', 'iconBg' => 'bg-blue-100'],
        3 => ['bg' => 'from-red-50 to-rose-50', 'icon' => 'text-red-500', 'iconBg' => 'bg-red-100'],
        4 => ['bg' => 'from-indigo-50 to-purple-50', 'icon' => 'text-indigo-500', 'iconBg' => 'bg-indigo-100'],
        5 => ['bg' => 'from-green-50 to-emerald-50', 'icon' => 'text-green-500', 'iconBg' => 'bg-green-100'],
        6 => ['bg' => 'from-pink-50 to-rose-50', 'icon' => 'text-pink-500', 'iconBg' => 'bg-pink-100'],
        7 => ['bg' => 'from-orange-50 to-yellow-50', 'icon' => 'text-orange-500', 'iconBg' => 'bg-orange-100'],
        8 => ['bg' => 'from-purple-50 to-violet-50', 'icon' => 'text-purple-500', 'iconBg' => 'bg-purple-100'],
    ];
    $color = $categoryColors[$product->category_id] ?? [
        'bg' => 'from-gray-50 to-gray-100',
        'icon' => 'text-gray-400',
        'iconBg' => 'bg-gray-100',
    ];

    $icons = ['fa-box', 'fa-box-open', 'fa-cube', 'fa-cubes', 'fa-archive', 'fa-shopping-basket'];
    $randomIcon = $icons[array_rand($icons)];

    // Perbaikan: Mendapatkan URL gambar yang benar dari storage
    $imageUrl = null;
    if ($product->image) {
        // Cek apakah image adalah URL eksternal atau path lokal
        if (filter_var($product->image, FILTER_VALIDATE_URL)) {
            $imageUrl = $product->image;
        } else {
            // Menggunakan Storage::url() untuk file yang disimpan di storage/app/public
            $imageUrl = Storage::url($product->image);
        }
    }
@endphp

<div
    class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300
            hover:-translate-y-1 overflow-hidden border border-gray-50 flex flex-col">

    {{-- Product Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="relative block overflow-hidden">
        <div
            class="aspect-square bg-gradient-to-br {{ $color['bg'] }} flex items-center justify-center
                    group-hover:scale-105 transition-transform duration-300 relative">

            {{-- Cek apakah gambar ada --}}
            @if ($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
            @else
                {{-- Placeholder jika tidak ada gambar --}}
                <div class="text-center p-4">
                    <div
                        class="w-16 h-16 {{ $color['iconBg'] }} rounded-2xl flex items-center justify-center mx-auto mb-2">
                        <i class="fas {{ $randomIcon }} {{ $color['icon'] }} text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">{{ $product->category->name }}</span>
                </div>
            @endif
        </div>

        {{-- Stock Badge --}}
        @if ($product->isLowStock() && $product->stock > 0)
            <span
                class="absolute top-3 left-3 bg-amber-500 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full shadow">
                Stok Terbatas
            </span>
        @endif

        @if ($product->stock == 0)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded-xl">Stok Habis</span>
            </div>
        @endif

        {{-- Quick Add Button (Hover) --}}
        @if ($product->stock > 0)
            <button onclick="addToCart({{ $product->id }})"
                class="absolute bottom-3 right-3 w-10 h-10 bg-white rounded-xl shadow-lg
                           flex items-center justify-center opacity-0 group-hover:opacity-100
                           transition-all duration-300 hover:bg-green-500 hover:text-white
                           transform translate-y-2 group-hover:translate-y-0 z-10"
                type="button">
                <i class="fas fa-plus text-sm"></i>
            </button>
        @endif
    </a>

    {{-- Product Info --}}
    <div class="p-3 lg:p-4 flex flex-col flex-1">
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
            class="text-[11px] text-green-600 font-medium hover:text-green-700 transition-colors mb-1">
            {{ $product->category->name }}
        </a>

        <a href="{{ route('products.show', $product->slug) }}"
            class="font-semibold text-gray-800 hover:text-green-600 transition-colors text-sm lg:text-base line-clamp-2 mb-2">
            {{ $product->name }}
        </a>

        <div class="mt-auto">
            <div class="flex items-baseline justify-between mb-2">
                <span class="text-lg font-bold text-gray-800">{{ $product->formatted_price }}</span>
                <span class="text-[11px] {{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                    <i class="fas fa-box text-[10px] mr-1"></i>{{ $product->stock }}
                </span>
            </div>

            @if ($product->stock > 0)
                <button onclick="addToCart({{ $product->id }})"
                    class="w-full bg-green-500 text-white text-sm font-medium py-2.5 px-4 rounded-xl
                               hover:bg-green-600 transition-all duration-200
                               flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-bag text-xs"></i>Tambah
                </button>
            @else
                <button disabled
                    class="w-full bg-gray-200 text-gray-400 text-sm font-medium py-2.5 px-4 rounded-xl cursor-not-allowed">
                    <i class="fas fa-times-circle mr-1"></i>Habis
                </button>
            @endif
        </div>
    </div>
</div>
