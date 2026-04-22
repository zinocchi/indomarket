{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-white border-t mt-auto">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold text-blue-600 mb-4">Indomarket</h3>
                <p class="text-gray-600 text-sm">
                    Solusi belanja kebutuhan sehari-hari dengan mudah dan cepat.
                </p>
            </div>

            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-600">Produk</a></li>
                    <li><a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-blue-600">Riwayat Transaksi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Kategori</h4>
                <ul class="space-y-2 text-sm">
                    @php
                        $categories = App\Models\Category::take(4)->get();
                    @endphp
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                               class="text-gray-600 hover:text-blue-600">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><i class="fas fa-phone mr-2"></i> (021) 1234-5678</li>
                    <li><i class="fas fa-envelope mr-2"></i> support@indomarket.com</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>

        <div class="border-t mt-8 pt-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Indomarket. All rights reserved.</p>
        </div>
    </div>
</footer>
