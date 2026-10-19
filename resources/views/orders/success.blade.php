@extends('layouts.app')

@section('title', 'Pesanan Berhasil & Keterangan Pengiriman - SIMANTAP')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    {{-- Ikon & Judul Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4 shadow-sm">
            <span class="text-4xl">🎉</span>
        </div>
        <h1 class="text-3xl font-bold text-neutral-900 mb-2">Pesanan Berhasil Dibuat!</h1>
        <p class="text-neutral-600">Terima kasih atas pesanan Anda di Toko Alat Pertanian SIMANTAP.</p>
    </div>

    {{-- Kartu Utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden mb-6">

        {{-- Header Nomor Pesanan --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4 text-white">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <div>
                    <span class="text-xs text-green-100 uppercase tracking-wider block">Nomor Pesanan</span>
                    <span id="nomor-pesanan" class="font-mono font-bold text-xl">-</span>
                </div>
                <div id="badge-mode-pengiriman" class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold backdrop-blur-sm">
                    🚚 Pengiriman
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- ===== NOTIFIKASI KETERANGAN STATUS BARANG (DIPROSES / DIANTAR) ===== --}}
            <div id="box-notifikasi-status" class="p-5 rounded-2xl border-2 flex items-start gap-4 transition shadow-sm">
                <div id="notif-icon" class="text-4xl shrink-0">⏳</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-1">
                        <span id="notif-judul" class="text-base font-extrabold">-</span>
                        <span id="notif-pill" class="text-xs px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">-</span>
                    </div>
                    <p id="notif-deskripsi" class="text-sm leading-relaxed mt-1 text-neutral-700">
                        Memuat keterangan pesanan...
                    </p>
                    <div id="notif-subinfo" class="mt-3 pt-3 border-t text-xs flex flex-wrap items-center gap-4 font-medium">
                        <!-- Dimuat via JS -->
                    </div>
                </div>
            </div>

            {{-- ===== TIMELINE STATUS TRACKER ===== --}}
            <div class="bg-neutral-50 rounded-2xl p-5 border border-neutral-200">
                <h3 class="text-sm font-bold text-neutral-800 mb-4 flex items-center gap-2">
                    <span>📍</span> Status Perjalanan Pesanan
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 relative">
                    {{-- Step 1 --}}
                    <div class="bg-white p-3 rounded-xl border-2 border-green-500 text-center shadow-xs">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center mx-auto mb-1.5 text-xs">
                            ✓
                        </div>
                        <div class="text-xs font-bold text-neutral-800">1. Dibuat</div>
                        <div class="text-[10px] text-green-600 font-medium">Pesanan Masuk</div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="bg-white p-3 rounded-xl border-2 border-green-500 text-center shadow-xs">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 font-bold flex items-center justify-center mx-auto mb-1.5 text-xs">
                            ✓
                        </div>
                        <div class="text-xs font-bold text-neutral-800">2. Bukti Bayar</div>
                        <div class="text-[10px] text-green-600 font-medium">Terkirim</div>
                    </div>

                    {{-- Step 3 (Aktif: Sedang Diproses) --}}
                    <div class="bg-emerald-50 p-3 rounded-xl border-2 border-emerald-500 text-center shadow-sm relative ring-2 ring-emerald-400/30">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center mx-auto mb-1.5 text-xs animate-pulse">
                            🔄
                        </div>
                        <div class="text-xs font-bold text-emerald-900">3. Diproses</div>
                        <div class="text-[10px] text-emerald-700 font-bold">Sedang Disiapkan</div>
                    </div>

                    {{-- Step 4 (Diantar / Siap Ambil) --}}
                    <div class="bg-white p-3 rounded-xl border border-neutral-200 text-center opacity-75">
                        <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-400 font-bold flex items-center justify-center mx-auto mb-1.5 text-xs">
                            <span id="step4-icon">🚚</span>
                        </div>
                        <div class="text-xs font-bold text-neutral-700" id="step4-title">4. Diantar</div>
                        <div class="text-[10px] text-neutral-500" id="step4-desc">Menunggu Antar</div>
                    </div>
                </div>
            </div>

            {{-- ===== DATA PEMESAN & PENGIRIMAN ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Pemesan --}}
                <div class="p-4 bg-neutral-50 rounded-xl border border-neutral-200 text-sm space-y-2">
                    <h3 class="font-bold text-neutral-800 flex items-center gap-1.5 mb-2">
                        <span>👤</span> Data Pemesan
                    </h3>
                    <div class="flex">
                        <span class="text-neutral-500 w-20">Nama</span>
                        <span id="info-nama" class="font-semibold text-neutral-800">-</span>
                    </div>
                    <div class="flex">
                        <span class="text-neutral-500 w-20">WhatsApp</span>
                        <span id="info-hp" class="font-medium text-neutral-800 font-mono">-</span>
                    </div>
                    <div class="flex">
                        <span class="text-neutral-500 w-20">Catatan</span>
                        <span id="info-catatan" class="font-medium text-neutral-700 italic">-</span>
                    </div>
                </div>

                {{-- Pengiriman --}}
                <div class="p-4 bg-neutral-50 rounded-xl border border-neutral-200 text-sm space-y-2">
                    <h3 class="font-bold text-neutral-800 flex items-center gap-1.5 mb-2">
                        <span>🚚</span> Detail Pengiriman
                    </h3>
                    <div class="flex">
                        <span class="text-neutral-500 w-24">Metode</span>
                        <span id="info-metode-kirim" class="font-semibold text-neutral-800">-</span>
                    </div>
                    <div class="flex">
                        <span class="text-neutral-500 w-24">Biaya Ongkir</span>
                        <span id="info-ongkir-biaya" class="font-bold text-green-700">Rp0</span>
                    </div>
                    <div>
                        <span class="text-neutral-500 block mb-0.5">Alamat Pengantaran:</span>
                        <span id="info-alamat" class="font-medium text-neutral-800 block text-xs bg-white p-2 rounded border border-neutral-200">-</span>
                    </div>
                </div>
            </div>

            {{-- ===== DAFTAR PRODUK YANG DIPESAN ===== --}}
            <div class="pt-4 border-t border-neutral-100">
                <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>🛒</span> Rincian Produk
                </h3>
                <div id="daftar-produk-sukses" class="space-y-3"></div>
            </div>

            {{-- ===== RINCIAN BIAYA & TOTAL (DENGAN ONGKIR) ===== --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-5 border border-green-200 space-y-2">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-neutral-600">Subtotal Produk:</span>
                    <span id="subtotal-sukses" class="font-semibold text-neutral-800">Rp0</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-neutral-600">Biaya Pengiriman (Ongkir):</span>
                    <span id="ongkir-sukses" class="font-semibold text-green-700">Rp0</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-green-200">
                    <div>
                        <span class="text-base font-bold text-neutral-900 block">Total Akhir</span>
                        <span class="text-xs text-neutral-500">Metode Pembayaran: <strong id="info-payment" class="text-neutral-700">-</strong></span>
                    </div>
                    <span id="total-sukses" class="text-2xl font-extrabold text-green-700">Rp0</span>
                </div>
            </div>

        </div>
    </div>

    {{-- Tombol Tindakan --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('orders.my-orders') }}"
           class="flex-1 text-center px-5 py-3.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
            <span>📦</span> Lacak Pesanan Saya
        </a>
        <a href="{{ url('/') }}"
           class="flex-1 text-center px-5 py-3.5 border border-neutral-200 hover:bg-neutral-100 text-neutral-700 font-semibold rounded-xl transition">
            Belanja Lagi di Beranda
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

    const rupiah = (n) => 'Rp' + Number(n).toLocaleString('id-ID');

    // Nomor & Pemesan
    document.getElementById('nomor-pesanan').textContent = order.nomor;
    document.getElementById('info-nama').textContent = order.nama;
    document.getElementById('info-hp').textContent = order.hp;
    document.getElementById('info-alamat').textContent = order.alamat;
    document.getElementById('info-payment').textContent = order.payment_method || '-';
    document.getElementById('info-catatan').textContent = order.catatan || '(Tidak ada catatan)';

    // Pengiriman & Ongkir
    const isDiantar = order.is_diantar || (order.shipping_method !== 'pickup');
    const ongkirCost = order.ongkir || 0;
    const shippingLabel = order.shipping_label || (isDiantar ? 'Kurir Toko (Diantar Langsung)' : 'Ambil Sendiri di Toko');

    document.getElementById('info-metode-kirim').textContent = shippingLabel;
    document.getElementById('info-ongkir-biaya').textContent = rupiah(ongkirCost);
    document.getElementById('badge-mode-pengiriman').textContent = isDiantar ? '🛵 Pengantaran ke Alamat' : '🏪 Ambil di Toko';

    // Notifikasi Dinamis Keterangan Barang (Diantar / Diproses)
    const notifBox = document.getElementById('box-notifikasi-status');
    const notifIcon = document.getElementById('notif-icon');
    const notifJudul = document.getElementById('notif-judul');
    const notifPill = document.getElementById('notif-pill');
    const notifDesc = document.getElementById('notif-deskripsi');
    const notifSubinfo = document.getElementById('notif-subinfo');

    const step4Icon = document.getElementById('step4-icon');
    const step4Title = document.getElementById('step4-title');
    const step4Desc = document.getElementById('step4-desc');

    if (isDiantar) {
        // Mode Barang Diantar ke Rumah
        notifBox.className = 'p-5 rounded-2xl border-2 border-emerald-300 bg-emerald-50/80 flex items-start gap-4 transition shadow-xs';
        notifIcon.textContent = '🛵';
        notifJudul.textContent = 'Status: Barang Sedang Diproses & Siap Diantar';
        notifJudul.className = 'text-base font-extrabold text-emerald-900';
        notifPill.className = 'text-xs px-2.5 py-0.5 rounded-full font-bold bg-emerald-200 text-emerald-900 uppercase';
        notifPill.textContent = 'Diantar ke Alamat';

        notifDesc.innerHTML = `
            Pesanan Anda saat ini <strong>sedang diproses dan disiapkan</strong> di toko. 
            Setelah proses verifikasi & pengemasan selesai, kurir kami akan <strong>segera mengantar barang langsung</strong> ke alamat Anda: 
            <span class="font-semibold text-emerald-900 underline">${order.alamat}</span>.
        `;

        notifSubinfo.className = 'mt-3 pt-3 border-t border-emerald-200 text-xs flex flex-wrap items-center gap-4 text-emerald-800 font-medium';
        notifSubinfo.innerHTML = `
            <span>📦 Opsi: ${shippingLabel}</span>
            <span>💰 Ongkir: ${rupiah(ongkirCost)}</span>
            <span>⏱️ Estimasi Pengantaran: 1 - 2 Hari Kerja</span>
        `;

        step4Icon.textContent = '🚚';
        step4Title.textContent = '4. Diantar Kurir';
        step4Desc.textContent = 'Menuju Alamat Anda';
    } else {
        // Mode Ambil Sendiri di Toko
        notifBox.className = 'p-5 rounded-2xl border-2 border-blue-300 bg-blue-50/80 flex items-start gap-4 transition shadow-xs';
        notifIcon.textContent = '🏪';
        notifJudul.textContent = 'Status: Barang Sedang Diproses (Siap Diambil)';
        notifJudul.className = 'text-base font-extrabold text-blue-900';
        notifPill.className = 'text-xs px-2.5 py-0.5 rounded-full font-bold bg-blue-200 text-blue-900 uppercase';
        notifPill.textContent = 'Ambil di Toko';

        notifDesc.innerHTML = `
            Pesanan Anda saat ini <strong>sedang diproses dan disiapkan</strong> oleh staf toko SIMANTAP. 
            Anda dapat mengambilnya langsung di toko kami setelah bukti pembayaran diverifikasi oleh kasir/admin.
        `;

        notifSubinfo.className = 'mt-3 pt-3 border-t border-blue-200 text-xs flex flex-wrap items-center gap-4 text-blue-800 font-medium';
        notifSubinfo.innerHTML = `
            <span>📍 Lokasi Pengambilan: Toko Utama SIMANTAP</span>
            <span>💰 Biaya Ongkir: Gratis (Rp0)</span>
            <span>🕒 Jam Operasional: 08.00 - 17.00 WIB</span>
        `;

        step4Icon.textContent = '🏪';
        step4Title.textContent = '4. Siap Diambil';
        step4Desc.textContent = 'Di Toko SIMANTAP';
    }

    // Daftar Produk
    const container = document.getElementById('daftar-produk-sukses');
    if (order.produk && order.produk.length > 0) {
        container.innerHTML = order.produk.map(item => {
            const subtotal = item.harga * item.qty;
            return `
                <div class="flex items-center gap-3 py-2 bg-neutral-50 px-3 rounded-xl border border-neutral-100">
                    <img src="${item.gambar || 'https://images.unsplash.com/photo-1592417817098-8f3d6ef2393c?w=150'}" alt="${item.nama || item.nama_produk || 'Produk'}"
                         class="w-12 h-12 object-cover rounded-lg shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-neutral-800 truncate">${item.nama || item.nama_produk || 'Produk'}</div>
                        <div class="text-xs text-neutral-500">${item.qty} × ${rupiah(item.harga)}</div>
                    </div>
                    <div class="text-sm font-bold text-neutral-800">
                        ${rupiah(subtotal)}
                    </div>
                </div>
            `;
        }).join('');
    }

    // Rincian Biaya
    const subtotal = order.subtotal || (order.total - ongkirCost);
    document.getElementById('subtotal-sukses').textContent = rupiah(subtotal);
    document.getElementById('ongkir-sukses').textContent = rupiah(ongkirCost);
    document.getElementById('total-sukses').textContent = rupiah(order.total);
});
</script>
@endpush