@extends('layouts.app')

@section('title', 'Pesanan Berhasil - SIMANTAP')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    {{-- Ikon Sukses --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-4">
            <span class="text-4xl">⏳</span>
        </div>
        <h1 class="text-3xl font-bold text-neutral-900 mb-2">Menunggu Verifikasi</h1>
        <p class="text-neutral-600">Bukti transfer Anda telah kami terima</p>
    </div>

    {{-- Kartu Ringkasan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden mb-6">

        {{-- Nomor Pesanan --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <span class="text-sm text-green-50">Nomor Pesanan</span>
                <span id="nomor-pesanan" class="font-mono font-bold text-lg">-</span>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- Status --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex gap-3">
                <span class="text-yellow-500 text-xl shrink-0">⏳</span>
                <div class="text-sm text-yellow-800">
                    <p class="font-semibold mb-1">Status: Menunggu Konfirmasi Admin</p>
                    <p>Admin akan memverifikasi pembayaran Anda dalam <strong>1×24 jam</strong>. Kami akan menghubungi Anda melalui HP yang terdaftar.</p>
                </div>
            </div>

            {{-- Info Pelanggan --}}
            <div>
                <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>👤</span> Data Pemesan
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex">
                        <span class="text-neutral-500 w-24">Nama</span>
                        <span id="info-nama" class="font-medium text-neutral-800">-</span>
                    </div>
                    <div class="flex">
                        <span class="text-neutral-500 w-24">HP</span>
                        <span id="info-hp" class="font-medium text-neutral-800">-</span>
                    </div>
                    <div class="flex">
                        <span class="text-neutral-500 w-24">Alamat</span>
                        <span id="info-alamat" class="font-medium text-neutral-800">-</span>
                    </div>
                    <div id="info-catatan-row" class="flex">
                        <span class="text-neutral-500 w-24">Catatan</span>
                        <span id="info-catatan" class="font-medium text-neutral-800 italic">-</span>
                    </div>
                </div>
            </div>

            {{-- Info Pembayaran --}}
            <div class="pt-4 border-t border-neutral-100">
                <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>💳</span> Info Pembayaran
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex">
                        <span class="text-neutral-500 w-32">Metode</span>
                        <span id="info-payment" class="font-medium text-neutral-800">-</span>
                    </div>
                    <div class="flex">
                        <span class="text-neutral-500 w-32">Bukti Transfer</span>
                        <span id="info-bukti" class="font-medium text-green-600">✓ Terkirim</span>
                    </div>
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="pt-4 border-t border-neutral-100">
                <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>🛒</span> Produk Dipesan
                </h3>
                <div id="daftar-produk-sukses" class="space-y-3"></div>
            </div>

            {{-- Total --}}
            <div class="bg-green-50 rounded-xl p-5 border border-green-100 flex justify-between items-center">
                <span class="text-lg font-semibold text-neutral-800">Total</span>
                <span id="total-sukses" class="text-2xl font-extrabold text-green-600">Rp0</span>
            </div>
        </div>
    </div>

    {{-- Tombol --}}
    <div class="flex gap-3">
        <a href="{{ url('/') }}"
           class="flex-1 text-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition shadow-lg shadow-green-600/20">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const order = JSON.parse(localStorage.getItem('simantap_last_order') || 'null');

    if (!order) {
        window.location.href = "{{ url('/') }}";
        return;
    }

    document.getElementById('nomor-pesanan').textContent = order.nomor;
    document.getElementById('info-nama').textContent = order.nama;
    document.getElementById('info-hp').textContent = order.hp;
    document.getElementById('info-alamat').textContent = order.alamat;
    document.getElementById('info-payment').textContent = order.payment_method || '-';

    if (order.catatan) {
        document.getElementById('info-catatan').textContent = order.catatan;
    } else {
        document.getElementById('info-catatan-row').style.display = 'none';
    }

    const container = document.getElementById('daftar-produk-sukses');
    container.innerHTML = order.produk.map(item => {
        const subtotal = item.harga * item.qty;
        return `
            <div class="flex items-center gap-3 py-2">
                <img src="${item.gambar}" alt="${item.nama}"
                     class="w-12 h-12 object-cover rounded-lg shrink-0">
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-neutral-800 truncate">${item.nama}</div>
                    <div class="text-xs text-neutral-500">${item.qty} × Rp${Number(item.harga).toLocaleString('id-ID')}</div>
                </div>
                <div class="text-sm font-bold text-neutral-800">
                    Rp${subtotal.toLocaleString('id-ID')}
                </div>
            </div>
        `;
    }).join('');

    document.getElementById('total-sukses').textContent = 'Rp' + order.total.toLocaleString('id-ID');

    // Hapus data order setelah ditampilkan
    setTimeout(() => {
        localStorage.removeItem('simantap_last_order');
    }, 1000);
});
</script>
@endpush