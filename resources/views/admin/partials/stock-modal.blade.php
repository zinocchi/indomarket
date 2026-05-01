{{-- resources/views/admin/products/partials/stock-modal.blade.php --}}
<div x-data="{
    open: false,
    productId: null,
    productName: '',
    currentStock: 0
}"
     x-show="open"
     @open-stock-modal.window="
        open = true;
        productId = $event.detail.id;
        productName = $event.detail.name;
        currentStock = $event.detail.stock
     "
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/50 transition-opacity" @click="open = false"></div>

    {{-- Modal --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 animate-fadeIn"
             @click.away="open = false">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Update Stok</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Product Info --}}
            <div class="bg-gray-50 rounded-2xl p-4 mb-6">
                <p class="text-sm font-semibold text-gray-800" x-text="productName"></p>
                <p class="text-sm text-gray-500 mt-1">
                    Stok saat ini: <span class="font-bold text-gray-800" x-text="currentStock"></span> unit
                </p>
            </div>

            {{-- Form --}}
            <form :action="'/admin/products/' + productId + '/stock'" method="POST">
                @csrf

                <div class="space-y-4">
                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Update</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="add" checked class="sr-only peer">
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center text-sm peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                                    <i class="fas fa-plus text-emerald-500 block mb-1"></i>
                                    Tambah
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="subtract" class="sr-only peer">
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center text-sm peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all">
                                    <i class="fas fa-minus text-amber-500 block mb-1"></i>
                                    Kurangi
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="set" class="sr-only peer">
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center text-sm peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <i class="fas fa-equals text-blue-500 block mb-1"></i>
                                    Set
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                        <input type="number"
                               name="quantity"
                               min="1"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition-all text-sm"
                               placeholder="Masukkan jumlah">
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 mt-6">
                    <button type="button"
                            @click="open = false"
                            class="flex-1 px-4 py-3 text-gray-600 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-all text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-emerald-600 text-white px-4 py-3 rounded-xl hover:bg-emerald-700 transition-all text-sm font-medium">
                        <i class="fas fa-check mr-2"></i>Update Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openStockModal(id, name, stock) {
        window.dispatchEvent(new CustomEvent('open-stock-modal', {
            detail: { id, name, stock }
        }));
    }
</script>
@endpush
