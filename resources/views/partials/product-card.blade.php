{{-- resources/views/partials/product-card.blade.php --}}
<div
    class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300
            hover:-translate-y-1 overflow-hidden border border-gray-50 flex flex-col">
    {{-- Product Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="relative block overflow-hidden">
        <div
            class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center
                    group-hover:from-emerald-50 group-hover:to-emerald-100 transition-colors duration-300">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            @else
                <i class="fas fa-box text-gray-300 text-5xl group-hover:text-emerald-300 transition-colors"></i>
            @endif
        </div>

        {{-- Stock Badge --}}
        @if ($product->isLowStock() && $product->stock > 0)
            <span
                class="absolute top-3 left-3 bg-amber-500 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full">
                Stok Terbatas
            </span>
        @endif

        @if ($product->stock == 0)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded-xl">
                    Stok Habis
                </span>
            </div>
        @endif

        {{-- Quick Add Button (Hover) --}}
        @if ($product->stock > 0)
            <button onclick="addToCart({{ $product->id }})"
                class="absolute bottom-3 right-3 w-10 h-10 bg-white rounded-xl shadow-lg
                           flex items-center justify-center opacity-0 group-hover:opacity-100
                           transition-all duration-300 hover:bg-emerald-600 hover:text-white
                           transform translate-y-2 group-hover:translate-y-0">
                <i class="fas fa-plus text-sm"></i>
            </button>
        @endif
    </a>

    {{-- Product Info --}}
    <div class="p-3 lg:p-4 flex flex-col flex-1">
        {{-- Category --}}
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
            class="text-[11px] text-emerald-600 font-medium hover:text-emerald-700 transition-colors mb-1">
            {{ $product->category->name }}
        </a>

        {{-- Name --}}
        <a href="{{ route('products.show', $product->slug) }}"
            class="font-semibold text-gray-800 hover:text-emerald-600 transition-colors text-sm lg:text-base line-clamp-2 mb-2">
            {{ $product->name }}
        </a>

        {{-- Price & Stock --}}
        <div class="mt-auto">
            <div class="flex items-baseline justify-between mb-2">
                <span class="text-lg font-bold text-gray-800">{{ $product->formatted_price }}</span>
                <span class="text-[11px] {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    <i class="fas fa-box text-[10px] mr-1"></i>
                    {{ $product->stock }}
                </span>
            </div>

            {{-- Add to Cart Button (Mobile Always Visible) --}}
            @if ($product->stock > 0)
                <button onclick="addToCart({{ $product->id }})"
                    class="w-full bg-green-500 text-white text-sm font-medium py-2.5 px-4 rounded-xl
                               hover:bg-green-500 transition-all duration-200
                               flex items-center justify-center gap-2 group/btn
                               lg:opacity-0 lg:group-hover:opacity-100">
                    <i class="fas fa-shopping-bag text-xs group-hover/btn:scale-110 transition-transform"></i>
                    <span>Tambah ke Keranjang</span>
                </button>
            @else
                <button disabled
                    class="w-full bg-gray-200 text-gray-400 text-sm font-medium py-2.5 px-4 rounded-xl cursor-not-allowed">
                    <i class="fas fa-times-circle mr-1"></i>Stok Habis
                </button>
            @endif
        </div>
    </div>
</div>
