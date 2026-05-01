{{-- resources/views/partials/footer-redesign.blade.php --}}
<footer class="bg-gray-900 text-white mt-auto pb-20 lg:pb-0">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-store text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold">Indo<span class="text-emerald-400">market</span></h3>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Solusi belanja kebutuhan sehari-hari dengan mudah, cepat, dan harga terjangkau.
                </p>
                <div class="flex gap-3 mt-4">
                    <a href="#"
                        class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#"
                        class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors">
                        <i class="fab fa-facebook text-sm"></i>
                    </a>
                    <a href="#"
                        class="w-9 h-9 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-emerald-600 transition-colors">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            {{-- Tautan --}}
            <div>
                <h4 class="font-semibold text-white mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Produk</a></li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Promo</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Tentang
                            Kami</a></li>
                </ul>
            </div>

            {{-- Bantuan --}}
            <div>
                <h4 class="font-semibold text-white mb-4">Bantuan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Cara
                            Belanja</a></li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Pengiriman</a></li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">Pengembalian</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors text-sm">FAQ</a>
                    </li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div>
                <h4 class="font-semibold text-white mb-4">Kontak Kami</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-map-marker-alt text-emerald-400 mt-1"></i>
                        <span>Jl. Pahlawan No. 123, Kecamatan Sukamaju, Jakarta Pusat</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-emerald-400"></i>
                        <span>(021) 1234-5678</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope text-emerald-400"></i>
                        <span>support@indomarket.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-clock text-emerald-400"></i>
                        <span>08:00 - 22:00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Indomarket. All rights reserved.</p>
                <div class="flex gap-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-gray-300 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-gray-300 transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>
