@extends('layouts.app')

@section('title', 'Lacak Pesanan Saya - SIMANTAP')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Breadcrumb & Title --}}
    <div class="mb-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm text-neutral-500 hover:text-green-600 transition mb-3">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 flex items-center gap-2">
                    <span>📦</span> Lacak Pesanan Saya
                </h1>
                <p class="text-neutral-500 text-sm mt-1">Pantau status pesanan, proses penyiapan, serta pengantaran barang Anda.</p>
            </div>

            @auth
                <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 border border-green-200 rounded-xl text-xs text-green-800">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-ping"></span>
                    <span>Pelanggan: <strong>{{ Auth::user()->nama }}</strong></span>
                </div>
            @else
                <div class="text-xs text-neutral-500">
                    Ingin pesanan tersimpan otomatis?
                    <a href="{{ route('login') }}" class="font-bold text-green-600 underline">Masuk Akun</a>
                </div>
            @endauth
        </div>
    </div>

    {{-- Pencarian Nomor Pesanan --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-neutral-100 mb-6">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400">🔍</span>
                <input type="text" id="cari-pesanan"
                       placeholder="Cari berdasarkan nomor pesanan (cth: ORD-...) atau nama..."
                       class="w-full pl-10 pr-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
            </div>
            <button onclick="cariOrderManual()"
                    class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition">
                Cari
            </button>
        </div>
    </div>

    {{-- Daftar Pesanan --}}
    <div id="container-pesanan" class="space-y-4">
        {{-- Diisi secara dinamis oleh JavaScript --}}
    </div>

    {{-- Empty State --}}
    <div id="empty-state" class="hidden bg-white rounded-2xl p-12 text-center shadow-sm border border-neutral-100">
        <div class="text-6xl mb-3">📦</div>
        <h3 class="text-lg font-bold text-neutral-800 mb-1">Belum Ada Riwayat Pesanan</h3>
        <p class="text-sm text-neutral-500 max-w-md mx-auto mb-6">
            Anda belum melakukan pemesanan melalui browser ini. Silakan pilih alat pertanian di katalog dan lakukan pemesanan!
        </p>
        <a href="{{ url('/#katalog') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition shadow-lg shadow-green-600/20 text-sm">
            🌾 Lihat Katalog Produk
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    muatRiwayatPesanan();
    document.getElementById('cari-pesanan').addEventListener('input', (e) => {
        filterPesanan(e.target.value.toLowerCase().trim());
    });
});

const rupiah = (n) => 'Rp' + Number(n).toLocaleString('id-ID');

let allOrders = [];

function muatRiwayatPesanan() {
    let history = JSON.parse(localStorage.getItem('simantap_orders_history') || '[]');
    const lastOrder = JSON.parse(localStorage.getItem('simantap_last_order') || 'null');

    // Ambil order dari MySQL database jika user sedang login
    const dbOrders = @json($dbOrders ?? []);
    if (Array.isArray(dbOrders) && dbOrders.length > 0) {
        dbOrders.forEach(o => {
            const exists = history.findIndex(h => h.nomor === o.kode_transaksi);
            const mapped = {
                nomor: o.kode_transaksi,
                nama: o.nama_pelanggan,
                hp: o.no_hp,
                alamat: o.alamat,
                latitude: o.latitude,
                longitude: o.longitude,
                shipping_method: 'kurir_toko',
                shipping_label: 'Kurir Pengantaran SIMANTAP',
                shipping_type: 'Pengantaran',
                ongkir: Number(o.ongkir || 0),
                subtotal: Math.max(0, Number(o.total_harga || 0) - Number(o.ongkir || 0)),
                total: Number(o.total_harga || 0),
                status: o.status,
                payment_method: o.metode_pembayaran || 'Transfer Bank',
                payment_status: o.status === 'menunggu_verifikasi' ? 'Menunggu Verifikasi' : (o.status === 'ditolak' ? 'Ditolak' : 'Terverifikasi'),
                created_at: o.tanggal_transaksi,
                produk: (o.details || []).map(d => ({
                    nama: d.produk ? d.produk.nama_produk : 'Alat Pertanian',
                    harga: Number(d.harga_satuan || 0),
                    qty: Number(d.jumlah || 1),
                    gambar: d.produk ? d.produk.gambar : null
                }))
            };

            if (exists >= 0) {
                // Update dengan status terbaru dari DB
                history[exists] = mapped;
            } else {
                history.unshift(mapped);
            }
        });
    }

    // Jika last order ada tapi belum masuk ke history, tambahkan
    if (lastOrder && !history.some(h => h.nomor === lastOrder.nomor)) {
        history.unshift(lastOrder);
    }

    localStorage.setItem('simantap_orders_history', JSON.stringify(history));

    allOrders = history;
    renderPesananList(allOrders);
}

function renderPesananList(list) {
    const container = document.getElementById('container-pesanan');
    const empty = document.getElementById('empty-state');

    if (list.length === 0) {
        container.innerHTML = '';
        empty.classList.remove('hidden');
        return;
    }

    empty.classList.add('hidden');

    container.innerHTML = list.map(order => {
        const isDiantar = order.is_diantar || (order.shipping_method !== 'pickup');
        const ongkirCost = order.ongkir || 0;
        const shippingLabel = order.shipping_label || (isDiantar ? 'Kurir Toko (Diantar Langsung)' : 'Ambil Sendiri di Toko');

        // Status badge & notification box
        let statusBadgeHtml = '';
        let notifKeteranganHtml = '';

        if (isDiantar) {
            statusBadgeHtml = `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sedang Diproses & Siap Diantar 🛵
                </span>
            `;
            notifKeteranganHtml = `
                <div class="mt-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-start gap-2">
                    <span class="text-base shrink-0">🚚</span>
                    <div>
                        <span class="font-bold">Keterangan: Barang Sedang Diproses Toko</span>
                        <p class="mt-0.5 text-neutral-600">Barang sedang disiapkan di gudang toko untuk segera diantar oleh kurir ke alamat: <strong>${order.alamat}</strong>.</p>
                    </div>
                </div>
            `;
        } else {
            statusBadgeHtml = `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-300">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Sedang Diproses (Siap Diambil) 🏪
                </span>
            `;
            notifKeteranganHtml = `
                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-800 flex items-start gap-2">
                    <span class="text-base shrink-0">🏪</span>
                    <div>
                        <span class="font-bold">Keterangan: Barang Sedang Diproses di Toko</span>
                        <p class="mt-0.5 text-neutral-600">Barang sedang disiapkan di toko SIMANTAP dan siap Anda ambil setelah konfirmasi pembayaran.</p>
                    </div>
                </div>
            `;
        }

        // Render produk list
        const produkHtml = (order.produk || []).map(p => `
            <div class="flex items-center justify-between text-xs py-1 border-b border-neutral-100 last:border-0">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-neutral-800">${p.nama}</span>
                    <span class="text-neutral-400">×${p.qty}</span>
                </div>
                <span class="font-semibold text-neutral-700">${rupiah(p.harga * p.qty)}</span>
            </div>
        `).join('');

        const subtotal = order.subtotal || (order.total - ongkirCost);

        return `
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden hover:shadow-md transition">
                <div class="p-5 border-b border-neutral-100 flex items-center justify-between flex-wrap gap-3 bg-neutral-50/70">
                    <div>
                        <span class="text-[11px] text-neutral-400 uppercase tracking-wider block">No. Pesanan</span>
                        <span class="font-mono font-bold text-neutral-800 text-base sm:text-lg">${order.nomor}</span>
                    </div>
                    <div>
                        ${statusBadgeHtml}
                    </div>
                </div>

                <div class="p-5 space-y-4">
                    ${notifKeteranganHtml}

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-neutral-400 block mb-0.5">Penerima & Alamat:</span>
                            <div class="font-semibold text-neutral-800">${order.nama} (${order.hp})</div>
                            <div class="text-neutral-600 mt-0.5 leading-relaxed">${order.alamat}</div>
                            ${order.latitude && order.longitude ? `
                                <div class="mt-1.5 flex items-center gap-1.5 text-[11px] text-emerald-700 font-mono">
                                    <span>📍</span>
                                    <span>${order.latitude}, ${order.longitude}</span>
                                    <a href="https://www.google.com/maps?q=${order.latitude},${order.longitude}" target="_blank" class="text-blue-600 underline font-sans ml-1">Buka Maps</a>
                                </div>
                            ` : ''}
                        </div>
                        <div>
                            <span class="text-neutral-400 block mb-0.5">Pengiriman & Pembayaran:</span>
                            <div class="font-semibold text-neutral-800">${shippingLabel}</div>
                            <div class="text-neutral-600 mt-0.5">Metode: ${order.payment_method || 'Transfer'}</div>
                            ${!isDiantar ? `
                                <div class="mt-1.5 p-2 bg-emerald-50 rounded-lg border border-emerald-200 text-[11px] text-emerald-800">
                                    <div class="font-bold flex items-center gap-1"><span>🏪</span> Titik Toko SIMANTAP:</div>
                                    <div class="text-neutral-600">{{ config('simantap.store_address') }}</div>
                                    <a href="{{ config('simantap.store_maps_url') }}" target="_blank" rel="noopener noreferrer" class="text-emerald-700 underline font-semibold mt-1 inline-block">
                                        📍 Buka di Google Maps (${order.store_latitude || '{{ config('simantap.store_latitude') }}'}, ${order.store_longitude || '{{ config('simantap.store_longitude') }}'})
                                    </a>
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <div class="bg-neutral-50 rounded-xl p-3 border border-neutral-100">
                        <div class="text-xs font-bold text-neutral-700 mb-2">Item Produk:</div>
                        <div class="space-y-1">
                            ${produkHtml}
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-neutral-100 flex-wrap gap-2 text-sm">
                        <div class="text-xs text-neutral-500">
                            Subtotal: ${rupiah(subtotal)} | 
                            <span class="font-medium text-emerald-700">Ongkir: ${rupiah(ongkirCost)}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-neutral-400 mr-2">Total Pembayaran:</span>
                            <span class="text-lg font-extrabold text-green-700">${rupiah(order.total)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

function filterPesanan(query) {
    if (!query) {
        renderPesananList(allOrders);
        return;
    }
    const filtered = allOrders.filter(o => {
        const text = `${o.nomor} ${o.nama} ${o.alamat} ${o.shipping_label}`.toLowerCase();
        return text.includes(query);
    });
    renderPesananList(filtered);
}

function cariOrderManual() {
    const q = document.getElementById('cari-pesanan').value.toLowerCase().trim();
    filterPesanan(q);
}
</script>
@endpush
