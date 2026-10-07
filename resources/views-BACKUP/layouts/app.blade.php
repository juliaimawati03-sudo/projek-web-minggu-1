<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIMANTAP - Toko Alat Pertanian')</title>

    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.cart-modal')

    {{-- ============================================ --}}
    {{-- SIMANTAP Cart Integration (tanpa WhatsApp) --}}
    {{-- ============================================ --}}
    <script>
    (function () {
        let cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');

        const rupiah = (n) => 'Rp' + Number(n).toLocaleString('id-ID');

        function saveCart() {
            localStorage.setItem('simantap_cart', JSON.stringify(cart));
        }

        function updateCartCount() {
            const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
            const el = document.getElementById('cart-count');
            if (el) el.textContent = totalQty;
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            const empty = document.getElementById('cart-empty');
            const footer = document.getElementById('cart-footer');
            if (!container) return;

            if (cart.length === 0) {
                container.innerHTML = '';
                if (empty) empty.classList.remove('hidden');
                if (footer) footer.classList.add('hidden');
                return;
            }

            if (empty) empty.classList.add('hidden');
            if (footer) footer.classList.remove('hidden');

            let total = 0;
            container.innerHTML = cart.map(item => {
                const subtotal = item.harga * item.qty;
                total += subtotal;
                return `
                    <div class="flex gap-3 bg-neutral-50 rounded-xl p-3">
                        <img src="${item.gambar}" alt="${item.nama}"
                             class="w-20 h-20 object-cover rounded-lg shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="font-semibold text-sm text-neutral-900 truncate">${item.nama}</h4>
                                <button onclick="hapusItem(${item.id})"
                                        class="text-red-500 hover:text-red-700 text-xs shrink-0">Hapus</button>
                            </div>
                            <p class="text-xs text-neutral-500 mt-0.5">${rupiah(item.harga)}</p>
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center gap-2">
                                    <button onclick="ubahQty(${item.id}, -1)"
                                            class="w-7 h-7 rounded-md bg-white border border-neutral-200 hover:border-green-600 hover:text-green-600 font-bold text-sm">−</button>
                                    <span class="text-sm font-semibold w-6 text-center">${item.qty}</span>
                                    <button onclick="ubahQty(${item.id}, 1)"
                                            class="w-7 h-7 rounded-md bg-white border border-neutral-200 hover:border-green-600 hover:text-green-600 font-bold text-sm">+</button>
                                </div>
                                <span class="text-sm font-bold text-green-600">${rupiah(subtotal)}</span>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            const totalEl = document.getElementById('cart-total');
            if (totalEl) totalEl.textContent = rupiah(total);
        }

        // ============ Fungsi Global ============

        window.tambahKeKeranjang = function (produk) {
            const existing = cart.find(i => i.id === produk.id);
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({ ...produk, qty: 1 });
            }
            saveCart();
            updateCartCount();
            renderCart();
            window.openCart();
        };

        window.ubahQty = function (id, delta) {
            const item = cart.find(i => i.id === id);
            if (!item) return;
            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(i => i.id !== id);
            }
            saveCart();
            updateCartCount();
            renderCart();
        };

        window.hapusItem = function (id) {
            cart = cart.filter(i => i.id !== id);
            saveCart();
            updateCartCount();
            renderCart();
        };

        window.openCart = function () {
            const modal = document.getElementById('cart-modal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                renderCart();
            }
        };

        window.closeCart = function () {
            const modal = document.getElementById('cart-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        };

        // Lanjut ke halaman pemesanan
        window.lanjutKePemesanan = function () {
            if (cart.length === 0) {
                alert('Keranjang masih kosong');
                return;
            }
            window.location.href = "{{ url('/checkout') }}";
        };

        window.filterKategori = function (kategori) {
            const cards = document.querySelectorAll('.produk-card');
            let visible = 0;

            cards.forEach(card => {
                const match = kategori === 'all' || card.dataset.kategori === kategori;
                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            const empty = document.getElementById('empty-kategori');
            if (empty) empty.classList.toggle('hidden', visible > 0);

            document.querySelectorAll('.kategori-btn').forEach(btn => {
                const active = btn.dataset.kategori === kategori;
                btn.classList.toggle('bg-green-600', active);
                btn.classList.toggle('border-green-600', active);
                btn.classList.toggle('text-white', active);
            });
        };

        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
            renderCart();
        });
    })();
    </script>

    @stack('scripts')
</body>
</html>