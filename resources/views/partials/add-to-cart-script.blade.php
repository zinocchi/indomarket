{{-- resources/views/partials/add-to-cart-script.blade.php --}}
@push('scripts')
    <script>
        async function addToCart(productId) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update cart count
                    window.dispatchEvent(new CustomEvent('cart-updated', {
                        detail: {
                            count: data.cart_count
                        }
                    }));

                    // Show toast notification
                    showToast('success', 'Produk berhasil ditambahkan ke keranjang!');
                } else {
                    showToast('error', data.message || 'Gagal menambahkan produk');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('error', 'Terjadi kesalahan. Silakan coba lagi.');
            }
        }

        function showToast(type, message) {
            // Simple toast implementation
            const colors = {
                success: 'bg-emerald-600',
                error: 'bg-red-500'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle'
            };

            const toast = document.createElement('div');
            toast.className = `fixed bottom-20 lg:bottom-8 right-4 ${colors[type]} text-white px-6 py-4 rounded-2xl
                           shadow-lg z-50 flex items-center gap-3 animate-fadeIn`;
            toast.innerHTML = `
            <i class="fas ${icons[type]} text-xl"></i>
            <span class="font-medium">${message}</span>
        `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
@endpush
