@extends('layouts.kasir')

@section('title', 'Pesanan Masuk - SIMANTAP')
@section('page-title', 'Pesanan Masuk')
@section('page-subtitle', 'Kelola pesanan dari pelanggan')

@section('content')

    {{-- Filter Tabs — logic sama persis (filterStatus()), tampilan diganti ke gaya admin:
         kartu putih flat border-neutral-200, tab aktif pakai warna primary (bukan biru) --}}
    <div class="bg-white rounded-xl border border-neutral-200 mb-6">
        <div class="flex items-center gap-1 p-2 overflow-x-auto">
            <button onclick="filterStatus('semua')" data-tab="semua"
                    class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm whitespace-nowrap transition bg-primary text-white">
                Semua <span class="ml-1 bg-white/20 px-2 py-0.5 rounded-full text-xs">6</span>
            </button>
            <button onclick="filterStatus('menunggu_verifikasi')" data-tab="menunggu_verifikasi"
                    class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm whitespace-nowrap transition text-neutral-600 hover:bg-neutral-100 inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Menunggu Verifikasi <span class="ml-1 bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full text-xs">3</span>
            </button>
            <button onclick="filterStatus('diproses')" data-tab="diproses"
                    class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm whitespace-nowrap transition text-neutral-600 hover:bg-neutral-100 inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582M19.418 15A7.978 7.978 0 0112 20a8 8 0 010-16c2.21 0 4.21.895 5.657 2.343M19.418 9l.582-5"/></svg>
                Diproses <span class="ml-1 bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">2</span>
            </button>
            <button onclick="filterStatus('dikirim')" data-tab="dikirim"
                    class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm whitespace-nowrap transition text-neutral-600 hover:bg-neutral-100 inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h13V6H3v7zm0 0l-1 4h2m14-4h2l2 4h-4m-14 0a2 2 0 104 0m10 0a2 2 0 104 0M16 9h3l2 4h-5V9z"/></svg>
                Dikirim <span class="ml-1 bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs">1</span>
            </button>
            <button onclick="filterStatus('selesai')" data-tab="selesai"
                    class="tab-btn px-5 py-2.5 rounded-lg font-semibold text-sm whitespace-nowrap transition text-neutral-600 hover:bg-neutral-100 inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Selesai <span class="ml-1 bg-primary-xlight text-primary-dark px-2 py-0.5 rounded-full text-xs">0</span>
            </button>
        </div>
    </div>

    {{-- Search — input disamakan dengan gaya admin (border-neutral-200, focus ring hijau) --}}
    <div class="mb-6">
        <div class="relative">
            <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" id="search-input" placeholder="Cari nomor pesanan atau nama pelanggan..."
                   class="w-full pl-11 pr-4 py-3 bg-white border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary transition">
        </div>
    </div>

    {{-- Daftar Pesanan — data & struktur data-status / data-search TIDAK diubah,
         supaya filterStatus() & search JS di bawah tetap jalan sama persis --}}
    <div id="daftar-pesanan" class="space-y-4">

        {{-- Pesanan 1: Menunggu Verifikasi --}}
        <div class="pesanan-card bg-white rounded-xl border border-neutral-200 hover:border-primary-light/50 overflow-hidden transition"
             data-status="menunggu_verifikasi"
             data-search="ord-20260924-0003 budi santoso">
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-neutral-800">ORD-20260924-0003</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Menunggu Verifikasi
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500">24 Sep 2026, 10:30</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-neutral-500">Total</div>
                        <div class="text-xl font-extrabold text-primary-dark">Rp195.000</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nama Pelanggan</div>
                        <div class="font-semibold text-sm text-neutral-800">Budi Santoso</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nomor HP</div>
                        <div class="font-semibold text-sm text-neutral-800">081234567890</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Metode</div>
                        <div class="font-semibold text-sm text-neutral-800">Transfer Bank BRI</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <div class="text-xs text-neutral-600 bg-neutral-100 rounded-lg px-3 py-1.5">
                        Pacul × 2, Arit × 1
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ url('/kasir/pesanan/ORD-20260924-0003') }}"
                       class="flex-1 text-center px-4 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-lg transition">
                        Lihat Detail
                    </a>
                    <button onclick="verifikasiCepat('ORD-20260924-0003')"
                            class="flex-1 px-4 py-2.5 bg-primary-xlight hover:bg-primary-light hover:text-white text-primary-dark text-sm font-semibold rounded-lg transition">
                        Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- Pesanan 2: Menunggu Verifikasi --}}
        <div class="pesanan-card bg-white rounded-xl border border-neutral-200 hover:border-primary-light/50 overflow-hidden transition"
             data-status="menunggu_verifikasi"
             data-search="ord-20260924-0002 siti aminah">
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-neutral-800">ORD-20260924-0002</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Menunggu Verifikasi
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500">24 Sep 2026, 09:15</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-neutral-500">Total</div>
                        <div class="text-xl font-extrabold text-primary-dark">Rp85.000</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nama Pelanggan</div>
                        <div class="font-semibold text-sm text-neutral-800">Siti Aminah</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nomor HP</div>
                        <div class="font-semibold text-sm text-neutral-800">082345678901</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Metode</div>
                        <div class="font-semibold text-sm text-neutral-800">Transfer Bank BRI</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <div class="text-xs text-neutral-600 bg-neutral-100 rounded-lg px-3 py-1.5">
                        Bendo × 1
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ url('/kasir/pesanan/ORD-20260924-0002') }}"
                       class="flex-1 text-center px-4 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-lg transition">
                        Lihat Detail
                    </a>
                    <button onclick="verifikasiCepat('ORD-20260924-0002')"
                            class="flex-1 px-4 py-2.5 bg-primary-xlight hover:bg-primary-light hover:text-white text-primary-dark text-sm font-semibold rounded-lg transition">
                        Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- Pesanan 3: Menunggu Verifikasi --}}
        <div class="pesanan-card bg-white rounded-xl border border-neutral-200 hover:border-primary-light/50 overflow-hidden transition"
             data-status="menunggu_verifikasi"
             data-search="ord-20260924-0001 ahmad fauzi">
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-neutral-800">ORD-20260924-0001</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Menunggu Verifikasi
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500">24 Sep 2026, 08:00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-neutral-500">Total</div>
                        <div class="text-xl font-extrabold text-primary-dark">Rp150.000</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nama Pelanggan</div>
                        <div class="font-semibold text-sm text-neutral-800">Ahmad Fauzi</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nomor HP</div>
                        <div class="font-semibold text-sm text-neutral-800">083456789012</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Metode</div>
                        <div class="font-semibold text-sm text-neutral-800">Transfer Bank BRI</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <div class="text-xs text-neutral-600 bg-neutral-100 rounded-lg px-3 py-1.5">
                        Pacul × 2
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ url('/kasir/pesanan/ORD-20260924-0001') }}"
                       class="flex-1 text-center px-4 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-lg transition">
                        Lihat Detail
                    </a>
                    <button onclick="verifikasiCepat('ORD-20260924-0001')"
                            class="flex-1 px-4 py-2.5 bg-primary-xlight hover:bg-primary-light hover:text-white text-primary-dark text-sm font-semibold rounded-lg transition">
                        Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- Pesanan 4: Diproses --}}
        <div class="pesanan-card bg-white rounded-xl border border-neutral-200 hover:border-primary-light/50 overflow-hidden transition"
             data-status="diproses"
             data-search="ord-20260923-0005 rina wati">
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-neutral-800">ORD-20260923-0005</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582M19.418 15A7.978 7.978 0 0112 20a8 8 0 010-16c2.21 0 4.21.895 5.657 2.343M19.418 9l.582-5"/></svg>
                                Diproses
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500">23 Sep 2026, 15:20</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-neutral-500">Total</div>
                        <div class="text-xl font-extrabold text-primary-dark">Rp250.000</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nama Pelanggan</div>
                        <div class="font-semibold text-sm text-neutral-800">Rina Wati</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nomor HP</div>
                        <div class="font-semibold text-sm text-neutral-800">084567890123</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Diverifikasi</div>
                        <div class="font-semibold text-sm text-primary-dark">✓ 23 Sep 16:00</div>
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ url('/kasir/pesanan/ORD-20260923-0005') }}"
                       class="flex-1 text-center px-4 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-lg transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        {{-- Pesanan 5: Dikirim --}}
        <div class="pesanan-card bg-white rounded-xl border border-neutral-200 hover:border-primary-light/50 overflow-hidden transition"
             data-status="dikirim"
             data-search="ord-20260923-0004 dedi kurniawan">
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-neutral-800">ORD-20260923-0004</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-purple-100 text-purple-700 inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h13V6H3v7zm0 0l-1 4h2m14-4h2l2 4h-4m-14 0a2 2 0 104 0m10 0a2 2 0 104 0M16 9h3l2 4h-5V9z"/></svg>
                                Dikirim
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500">23 Sep 2026, 13:00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-neutral-500">Total</div>
                        <div class="text-xl font-extrabold text-primary-dark">Rp105.000</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nama Pelanggan</div>
                        <div class="font-semibold text-sm text-neutral-800">Dedi Kurniawan</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nomor HP</div>
                        <div class="font-semibold text-sm text-neutral-800">085678901234</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Dikirim</div>
                        <div class="font-semibold text-sm text-purple-600">✓ 23 Sep 18:00</div>
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ url('/kasir/pesanan/ORD-20260923-0004') }}"
                       class="flex-1 text-center px-4 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold rounded-lg transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        {{-- Pesanan 6: Selesai --}}
        <div class="pesanan-card bg-white rounded-xl border border-neutral-200 hover:border-primary-light/50 overflow-hidden transition"
             data-status="selesai"
             data-search="ord-20260922-0001 putri ayu">
            <div class="p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="font-mono font-bold text-neutral-800">ORD-20260922-0001</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-primary-xlight text-primary-dark inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Selesai
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500">22 Sep 2026, 10:00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-neutral-500">Total</div>
                        <div class="text-xl font-extrabold text-primary-dark">Rp75.000</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nama Pelanggan</div>
                        <div class="font-semibold text-sm text-neutral-800">Putri Ayu</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Nomor HP</div>
                        <div class="font-semibold text-sm text-neutral-800">086789012345</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 mb-0.5">Selesai</div>
                        <div class="font-semibold text-sm text-primary-dark">✓ 22 Sep 15:00</div>
                    </div>
                </div>

                <div class="flex gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ url('/kasir/pesanan/ORD-20260922-0001') }}"
                       class="flex-1 text-center px-4 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 text-sm font-semibold rounded-lg transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Empty State --}}
    <div id="empty-state" class="hidden text-center py-16">
        <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4M3 7l9 4m-9-4v10l9 4m0-10l9-4m-9 4v10m9-10v10"/></svg>
        <h3 class="text-lg font-bold text-neutral-800 mb-1">Tidak ada pesanan</h3>
        <p class="text-sm text-neutral-500">Belum ada pesanan dengan status ini</p>
    </div>

    <script>
    // ============ Filter Status ============
    // Logic TIDAK diubah — hanya nama class warna tab aktif yang diganti
    // dari 'bg-blue-600' ke 'bg-primary' supaya match tampilan baru.
    let currentFilter = 'semua';
    let currentSearch = '';

    function filterStatus(status) {
        currentFilter = status;

        document.querySelectorAll('.tab-btn').forEach(btn => {
            const isActive = btn.dataset.tab === status;
            btn.classList.toggle('bg-primary', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('text-neutral-600', !isActive);
            btn.classList.toggle('hover:bg-neutral-100', !isActive);
        });

        applyFilter();
    }

    function applyFilter() {
        const cards = document.querySelectorAll('.pesanan-card');
        let visible = 0;

        cards.forEach(card => {
            const matchStatus = currentFilter === 'semua' || card.dataset.status === currentFilter;
            const matchSearch = !currentSearch || card.dataset.search.includes(currentSearch.toLowerCase());

            if (matchStatus && matchSearch) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
    }

    // ============ Search ============
    document.getElementById('search-input').addEventListener('input', (e) => {
        currentSearch = e.target.value;
        applyFilter();
    });

    // ============ Verifikasi Cepat ============
    function verifikasiCepat(nomor) {
        if (confirm('Verifikasi pesanan ' + nomor + '?\n\nPesanan akan berubah status menjadi "Diproses" dan tercatat di laporan keuangan.')) {
            alert('Pesanan ' + nomor + ' berhasil diverifikasi!\n\n(BACKEND NANTI: Update status di database)');
            // Nanti: fetch ke backend
        }
    }

    // ============ Cek Akses ============
    document.addEventListener('DOMContentLoaded', () => {
        const user = JSON.parse(localStorage.getItem('simantap_user') || 'null');
        if (!user || (user.role !== 'kasir' && user.role !== 'admin')) {
            window.location.href = '/login';
        }
    });
    </script>

@endsection