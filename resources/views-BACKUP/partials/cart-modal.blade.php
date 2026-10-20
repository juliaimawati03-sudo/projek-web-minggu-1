<div id="cart-modal" class="fixed inset-0 z-50 hidden">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeCart()"></div>

    {{-- Modal --}}
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">
        {{-- Header --}}
        <div class="flex items-center justify-between p-5 border-b border-neutral-100">
            <h3 class="text-lg font-bold text-neutral-900">🛒 Keranjang Belanja</h3>
            <button onclick="closeCart()" class="p-2 rounded-lg hover:bg-neutral-100 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Items --}}
        <div id="cart-items" class="flex-1 overflow-y-auto p-5 space-y-4">
            {{-- diisi via JS --}}
        </div>

        {{-- Empty state --}}
        <div id="cart-empty" class="flex-1 flex flex-col items-center justify-center p-8 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <p class="text-neutral-500 mb-1">Keranjang Anda masih kosong</p>
            <p class="text-sm text-neutral-400">Yuk, pilih produk terlebih dahulu!</p>
        </div>

        {{-- Footer / Total --}}
        <div id="cart-footer" class="hidden border-t border-neutral-100 p-5 space-y-4">
            <div class="flex items-center justify-between text-lg">
                <span class="font-semibold text-neutral-700">Total</span>
                <span id="cart-total" class="font-extrabold text-green-600 text-xl">Rp0</span>
            </div>
            <button onclick="lanjutKePemesanan()"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20">
                Lanjut ke Pemesanan
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </div>
    </div>
</div>