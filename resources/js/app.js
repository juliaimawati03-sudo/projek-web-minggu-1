// ============================================
// SIMANTAP - Cart & WhatsApp Integration
// ============================================

const WA_NUMBER = window.SIMANTAP_CONFIG?.waNumber || '6281234567890';

// State keranjang
let cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');

// ---------- Helpers ----------
const rupiah = (n) => 'Rp' + n.toLocaleString('id-ID');

function saveCart() {
    localStorage.setItem('simantap_cart', JSON.stringify(cart));
}

function updateCartCount() {
    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    const el = document.getElementById('cart-count');
    if (el) el.textContent = totalQty;
}

// ---------- Tambah ke Keranjang ----------
function tambahKeKeranjang(produk) {
    const existing = cart.find(i => i.id === produk.id);
    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ ...produk, qty: 1 });
    }
    saveCart();
    updateCartCount();
    renderCart();
    openCart();
}

// ---------- Render Keranjang ----------
function renderCart() {
    const container = document.getElementById('cart-items');
    const empty = document.getElementById('cart-empty');
    const footer = document.getElementById('cart-footer');
    if (!container) return;

    if (cart.length === 0) {
        container.innerHTML = '';
        empty.classList.remove('hidden');
        footer.classList.add('hidden');
        return;
    }

    empty.classList.add('hidden');
    footer.classList.remove('hidden');

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

    document.getElementById('cart-total').textContent = rupiah(total);
}

// ---------- Ubah Qty ----------
function ubahQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) {
        cart = cart.filter(i => i.id !== id);
    }
    saveCart();
    updateCartCount();
    renderCart();
}

// ---------- Hapus Item ----------
function hapusItem(id) {
    cart = cart.filter(i => i.id !== id);
    saveCart();
    updateCartCount();
    renderCart();
}

// ---------- Buka / Tutup Cart ----------
function openCart() {
    document.getElementById('cart-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    renderCart();
}

function closeCart() {
    document.getElementById('cart-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

// ---------- Checkout via WhatsApp ----------
function checkoutWhatsApp() {
    if (cart.length === 0) return;

    let total = 0;
    let pesan = `Halo, saya ingin memesan produk dari SIMANTAP:\n\n`;

    cart.forEach((item, index) => {
        const subtotal = item.harga * item.qty;
        total += subtotal;
        pesan += `${index + 1}. ${item.nama} × ${item.qty} — ${rupiah(subtotal)}\n`;
    });

    pesan += `\nTotal: ${rupiah(total)}\n\n`;
    pesan += `Mohon informasi ketersediaan dan proses selanjutnya. Terima kasih.`;

    const url = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(pesan)}`;
    window.open(url, '_blank');
}

// ---------- Pesan Produk Tunggal via WhatsApp ----------
function pesanProdukWA(produk) {
    const pesan = `Halo, saya ingin menanyakan/memesan produk: ${produk.nama}.\n`
                + `Harga: ${rupiah(produk.harga)}.\n`
                + `Apakah produk masih tersedia?`;
    const url = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(pesan)}`;
    window.open(url, '_blank');
}

// ---------- Filter Kategori ----------
function filterKategori(kategori) {
    const cards = document.querySelectorAll('.produk-card');
    let visible = 0;

    cards.forEach(card => {
        const match = kategori === 'all' || card.dataset.kategori === kategori;
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    document.getElementById('empty-kategori').classList.toggle('hidden', visible > 0);

    // highlight tombol kategori
    document.querySelectorAll('.kategori-btn').forEach(btn => {
        const active = btn.dataset.kategori === kategori;
        btn.classList.toggle('bg-green-600', active);
        btn.classList.toggle('border-green-600', active);
        btn.classList.toggle('text-white', active);
        btn.querySelector('div:last-child')?.classList.toggle('text-white', active);
    });
}

// ---------- Init ----------
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    renderCart();
});