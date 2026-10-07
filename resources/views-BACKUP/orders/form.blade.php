@extends('layouts.app')

@section('title', 'Form Pemesanan - SIMANTAP')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- Tombol Kembali --}}
    <a href="{{ url('/') }}"
       class="inline-flex items-center gap-2 text-sm text-neutral-600 hover:text-green-600 mb-6 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-green-600 px-6 py-5 text-white">
            <h1 class="text-2xl font-bold mb-1">📋 Form Pemesanan</h1>
            <p class="text-green-50 text-sm">Lengkapi data pesanan Anda di bawah ini</p>
        </div>

        <form id="form-pemesanan" class="p-6 space-y-6">

            {{-- ===== DAFTAR PRODUK ===== --}}
            <div>
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>🛒</span> Produk Pesanan
                </h2>
                <div id="daftar-produk" class="space-y-3"></div>

                <div id="produk-kosong" class="hidden text-center py-8 text-neutral-500">
                    <div class="text-4xl mb-2">📦</div>
                    <p>Keranjang masih kosong</p>
                    <a href="{{ url('/') }}" class="text-green-600 underline mt-2 inline-block">
                        Pilih produk dulu
                    </a>
                </div>
            </div>

            {{-- ===== DATA PELANGGAN ===== --}}
            <div class="pt-4 border-t border-neutral-100">
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>👤</span> Data Pelanggan
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-neutral-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required
                               placeholder="Contoh: Budi Santoso"
                               class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="hp" class="block text-sm font-medium text-neutral-700 mb-1">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="hp" name="hp" required
                               placeholder="Contoh: 081234567890"
                               class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-neutral-700 mb-1">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" required rows="3"
                                  placeholder="Contoh: Jl. Pertanian No. 123, RT 01/RW 02, Desa Sukamaju"
                                  class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"></textarea>
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-neutral-700 mb-1">
                            Catatan <span class="text-neutral-400">(opsional)</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="2"
                                  placeholder="Contoh: Tolong dikirim pagi hari"
                                  class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- ===== METODE PEMBAYARAN ===== --}}
            <div class="pt-4 border-t border-neutral-100">
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>💳</span> Metode Pembayaran
                </h2>
                <p class="text-sm text-neutral-500 mb-4">Pilih salah satu metode pembayaran di bawah ini:</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    {{-- ShopeePay --}}
                    <label class="payment-option cursor-pointer">
                        <input type="radio" name="payment_method" value="ShopeePay" class="sr-only" required>
                        <div class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl hover:border-orange-400 transition">
                            <div class="w-14 h-14 rounded-lg bg-white flex items-center justify-center shrink-0 overflow-hidden border border-neutral-100 p-1">
                                <img src="{{ asset('images/shopeepay.png') }}"
                                     alt="ShopeePay"
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-neutral-800">ShopeePay</div>
                                <div class="text-xs text-neutral-500 font-mono">0878-5956-3173</div>
                            </div>
                        </div>
                    </label>

                    {{-- SeaBank --}}
                    <label class="payment-option cursor-pointer">
                        <input type="radio" name="payment_method" value="SeaBank" class="sr-only">
                        <div class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl hover:border-orange-400 transition">
                            <div class="w-14 h-14 rounded-lg bg-white flex items-center justify-center shrink-0 overflow-hidden border border-neutral-100 p-1">
                                <img src="{{ asset('images/seabank.png') }}"
                                     alt="SeaBank"
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-neutral-800">SeaBank</div>
                                <div class="text-xs text-neutral-500 font-mono">901229078240</div>
                            </div>
                        </div>
                    </label>
                </div>

                <p id="error-payment" class="hidden text-sm text-red-500 mt-2">
                    ⚠️ Silakan pilih metode pembayaran terlebih dahulu
                </p>
            </div>

            {{-- ===== TOTAL ===== --}}
            <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-neutral-600">Jumlah Item</span>
                    <span id="total-item" class="font-semibold text-neutral-800">0 item</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-green-200">
                    <span class="text-lg font-semibold text-neutral-800">Total</span>
                    <span id="total-harga" class="text-2xl font-extrabold text-green-600">Rp0</span>
                </div>
            </div>

            {{-- ===== TOMBOL ===== --}}
            <div class="flex gap-3">
                <a href="{{ url('/') }}"
                   class="flex-1 text-center px-4 py-3 border border-neutral-200 hover:border-neutral-300 text-neutral-700 font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" id="btn-konfirmasi"
                        class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                    <span>✓</span> Konfirmasi Pesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .payment-option input:checked + div {
        border-color: #16a34a;
        background-color: #f0fdf4;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    renderProdukDiForm();
    document.getElementById('form-pemesanan').addEventListener('submit', handleSubmit);
});

function rupiah(n) {
    return 'Rp' + Number(n).toLocaleString('id-ID');
}

function renderProdukDiForm() {
    const cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');
    const container = document.getElementById('daftar-produk');
    const empty = document.getElementById('produk-kosong');
    const btnKonfirmasi = document.getElementById('btn-konfirmasi');

    if (cart.length === 0) {
        container.innerHTML = '';
        empty.classList.remove('hidden');
        btnKonfirmasi.disabled = true;
        btnKonfirmasi.classList.add('opacity-50', 'cursor-not-allowed');
        updateTotal(0, 0);
        return;
    }

    empty.classList.add('hidden');
    btnKonfirmasi.disabled = false;
    btnKonfirmasi.classList.remove('opacity-50', 'cursor-not-allowed');

    container.innerHTML = cart.map(item => {
        const subtotal = item.harga * item.qty;
        return `
            <div class="flex gap-3 bg-neutral-50 rounded-xl p-3 items-center">
                <img src="${item.gambar}" alt="${item.nama}"
                     class="w-16 h-16 object-cover rounded-lg shrink-0">
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-sm text-neutral-900 truncate">${item.nama}</h4>
                    <p class="text-xs text-neutral-500 mt-0.5">${rupiah(item.harga)}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="ubahQtyForm(${item.id}, -1)"
                            class="w-7 h-7 rounded-md bg-white border border-neutral-200 hover:border-green-600 hover:text-green-600 font-bold text-sm">−</button>
                    <span class="text-sm font-semibold w-6 text-center">${item.qty}</span>
                    <button type="button" onclick="ubahQtyForm(${item.id}, 1)"
                            class="w-7 h-7 rounded-md bg-white border border-neutral-200 hover:border-green-600 hover:text-green-600 font-bold text-sm">+</button>
                </div>
                <div class="text-sm font-bold text-green-600 w-24 text-right">
                    ${rupiah(subtotal)}
                </div>
            </div>
        `;
    }).join('');

    const totalHarga = cart.reduce((sum, i) => sum + (i.harga * i.qty), 0);
    const totalItem = cart.reduce((sum, i) => sum + i.qty, 0);
    updateTotal(totalHarga, totalItem);
}

function updateTotal(harga, item) {
    document.getElementById('total-harga').textContent = rupiah(harga);
    document.getElementById('total-item').textContent = item + ' item';
}

function ubahQtyForm(id, delta) {
    let cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');
    const item = cart.find(i => i.id === id);
    if (!item) return;

    item.qty += delta;
    if (item.qty <= 0) {
        cart = cart.filter(i => i.id !== id);
    }
    localStorage.setItem('simantap_cart', JSON.stringify(cart));
    renderProdukDiForm();
}

function handleSubmit(e) {
    e.preventDefault();

    const cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');
    if (cart.length === 0) {
        alert('Keranjang masih kosong');
        return;
    }

    const nama = document.getElementById('nama').value.trim();
    const hp = document.getElementById('hp').value.trim();
    const alamat = document.getElementById('alamat').value.trim();

    if (!nama || !hp || !alamat) {
        alert('Mohon lengkapi semua data yang wajib diisi');
        return;
    }

    // Cek metode pembayaran
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    const errorPayment = document.getElementById('error-payment');

    if (!paymentMethod) {
        errorPayment.classList.remove('hidden');
        document.querySelector('.payment-option').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    errorPayment.classList.add('hidden');

    // Simpan data pesanan
    const orderData = {
        nomor: 'ORD-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + String(Math.floor(Math.random() * 9999) + 1).padStart(4, '0'),
        nama: nama,
        hp: hp,
        alamat: alamat,
        catatan: document.getElementById('catatan').value.trim(),
        payment_method: paymentMethod.value,
        produk: cart,
        total: cart.reduce((sum, i) => sum + (i.harga * i.qty), 0)
    };

    localStorage.setItem('simantap_last_order', JSON.stringify(orderData));
    // Jangan hapus cart di sini — hapus setelah upload bukti transfer

    // Redirect ke halaman pembayaran
    window.location.href = "{{ url('/orders/payment') }}";
}
</script>
@endpush