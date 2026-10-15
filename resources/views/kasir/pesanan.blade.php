@extends('layouts.kasir')

@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')
@section('page-desc', 'Kelola pesanan dari pelanggan')

@section('content')

    {{-- Filter Tabs --}}
    <div class="card shadow mb-4">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap gap-1">
                <button onclick="filterStatus('semua')" data-tab="semua"
                        class="tab-btn btn btn-sm font-weight-bold active bg-primary text-white">
                    Semua
                </button>
                <button onclick="filterStatus('menunggu_verifikasi')" data-tab="menunggu_verifikasi"
                        class="tab-btn btn btn-sm font-weight-bold text-dark">
                    <i class="fas fa-clock text-warning mr-1"></i> Menunggu Verifikasi
                </button>
                <button onclick="filterStatus('diproses')" data-tab="diproses"
                        class="tab-btn btn btn-sm font-weight-bold text-dark">
                    <i class="fas fa-spinner text-info mr-1"></i> Diproses
                </button>
                <button onclick="filterStatus('dikirim')" data-tab="dikirim"
                        class="tab-btn btn btn-sm font-weight-bold text-dark">
                    <i class="fas fa-truck text-purple mr-1"></i> Dikirim
                </button>
                <button onclick="filterStatus('selesai')" data-tab="selesai"
                        class="tab-btn btn btn-sm font-weight-bold text-dark">
                    <i class="fas fa-check-circle text-success mr-1"></i> Selesai
                </button>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                </div>
                <input type="text" id="search-input" class="form-control"
                       placeholder="Cari nomor pesanan atau nama pelanggan...">
            </div>
        </div>
    </div>

    {{-- Daftar Pesanan --}}
    <div id="daftar-pesanan">

        {{-- Pesanan 1: Menunggu Verifikasi --}}
        <div class="pesanan-card card shadow-sm mb-3 border-left-warning"
             data-status="menunggu_verifikasi"
             data-search="ord-20260924-0003 budi santoso">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="font-weight-bold text-dark">ORD-20260924-0003</span>
                            <span class="badge badge-warning">Menunggu Verifikasi</span>
                        </div>
                        <div class="text-muted small">24 Sep 2026, 10:30</div>
                    </div>
                    <div class="text-right">
                        <div class="text-muted small">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp195.000</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nama Pelanggan</div>
                        <div class="font-weight-bold">Budi Santoso</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nomor HP</div>
                        <div class="font-weight-bold">081234567890</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Metode</div>
                        <div class="font-weight-bold">Transfer Bank BRI</div>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="badge badge-light border">Pacul × 2, Arit × 1</span>
                </div>

                <div class="d-flex gap-2 pt-3 border-top">
                    <a href="{{ url('/kasir/pesanan/ORD-20260924-0003') }}"
                       class="btn btn-success btn-sm flex-fill">
                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                    </a>
                    <button onclick="verifikasiCepat('ORD-20260924-0003')"
                            class="btn btn-outline-success btn-sm flex-fill">
                        <i class="fas fa-check mr-1"></i> Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- Pesanan 2: Menunggu Verifikasi --}}
        <div class="pesanan-card card shadow-sm mb-3 border-left-warning"
             data-status="menunggu_verifikasi"
             data-search="ord-20260924-0002 siti aminah">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="font-weight-bold text-dark">ORD-20260924-0002</span>
                            <span class="badge badge-warning">Menunggu Verifikasi</span>
                        </div>
                        <div class="text-muted small">24 Sep 2026, 09:15</div>
                    </div>
                    <div class="text-right">
                        <div class="text-muted small">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp85.000</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nama Pelanggan</div>
                        <div class="font-weight-bold">Siti Aminah</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nomor HP</div>
                        <div class="font-weight-bold">082345678901</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Metode</div>
                        <div class="font-weight-bold">Transfer Bank BRI</div>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="badge badge-light border">Bendo × 1</span>
                </div>
                <div class="d-flex gap-2 pt-3 border-top">
                    <a href="{{ url('/kasir/pesanan/ORD-20260924-0002') }}" class="btn btn-success btn-sm flex-fill">
                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                    </a>
                    <button onclick="verifikasiCepat('ORD-20260924-0002')" class="btn btn-outline-success btn-sm flex-fill">
                        <i class="fas fa-check mr-1"></i> Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- Pesanan 3: Menunggu Verifikasi --}}
        <div class="pesanan-card card shadow-sm mb-3 border-left-warning"
             data-status="menunggu_verifikasi"
             data-search="ord-20260924-0001 ahmad fauzi">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="font-weight-bold text-dark">ORD-20260924-0001</span>
                            <span class="badge badge-warning">Menunggu Verifikasi</span>
                        </div>
                        <div class="text-muted small">24 Sep 2026, 08:00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-muted small">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp150.000</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nama Pelanggan</div>
                        <div class="font-weight-bold">Ahmad Fauzi</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nomor HP</div>
                        <div class="font-weight-bold">083456789012</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Metode</div>
                        <div class="font-weight-bold">Transfer Bank BRI</div>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="badge badge-light border">Pacul × 2</span>
                </div>
                <div class="d-flex gap-2 pt-3 border-top">
                    <a href="{{ url('/kasir/pesanan/ORD-20260924-0001') }}" class="btn btn-success btn-sm flex-fill">
                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                    </a>
                    <button onclick="verifikasiCepat('ORD-20260924-0001')" class="btn btn-outline-success btn-sm flex-fill">
                        <i class="fas fa-check mr-1"></i> Verifikasi
                    </button>
                </div>
            </div>
        </div>

        {{-- Pesanan 4: Diproses --}}
        <div class="pesanan-card card shadow-sm mb-3 border-left-info"
             data-status="diproses"
             data-search="ord-20260923-0005 rina wati">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="font-weight-bold text-dark">ORD-20260923-0005</span>
                            <span class="badge badge-info">Diproses</span>
                        </div>
                        <div class="text-muted small">23 Sep 2026, 15:20</div>
                    </div>
                    <div class="text-right">
                        <div class="text-muted small">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp250.000</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nama Pelanggan</div>
                        <div class="font-weight-bold">Rina Wati</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nomor HP</div>
                        <div class="font-weight-bold">084567890123</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Diverifikasi</div>
                        <div class="font-weight-bold text-success">✓ 23 Sep 16:00</div>
                    </div>
                </div>
                <div class="pt-3 border-top">
                    <a href="{{ url('/kasir/pesanan/ORD-20260923-0005') }}" class="btn btn-success btn-sm flex-fill">
                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        {{-- Pesanan 5: Dikirim --}}
        <div class="pesanan-card card shadow-sm mb-3 border-left-primary"
             data-status="dikirim"
             data-search="ord-20260923-0004 dedi kurniawan">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="font-weight-bold text-dark">ORD-20260923-0004</span>
                            <span class="badge badge-primary">Dikirim</span>
                        </div>
                        <div class="text-muted small">23 Sep 2026, 13:00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-muted small">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp105.000</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nama Pelanggan</div>
                        <div class="font-weight-bold">Dedi Kurniawan</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nomor HP</div>
                        <div class="font-weight-bold">085678901234</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Dikirim</div>
                        <div class="font-weight-bold text-primary">✓ 23 Sep 18:00</div>
                    </div>
                </div>
                <div class="pt-3 border-top">
                    <a href="{{ url('/kasir/pesanan/ORD-20260923-0004') }}" class="btn btn-success btn-sm flex-fill">
                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        {{-- Pesanan 6: Selesai --}}
        <div class="pesanan-card card shadow-sm mb-3 border-left-success"
             data-status="selesai"
             data-search="ord-20260922-0001 putri ayu">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="font-weight-bold text-dark">ORD-20260922-0001</span>
                            <span class="badge badge-success">Selesai</span>
                        </div>
                        <div class="text-muted small">22 Sep 2026, 10:00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-muted small">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-success">Rp75.000</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nama Pelanggan</div>
                        <div class="font-weight-bold">Putri Ayu</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Nomor HP</div>
                        <div class="font-weight-bold">086789012345</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Selesai</div>
                        <div class="font-weight-bold text-success">✓ 22 Sep 15:00</div>
                    </div>
                </div>
                <div class="pt-3 border-top">
                    <a href="{{ url('/kasir/pesanan/ORD-20260922-0001') }}" class="btn btn-light btn-sm flex-fill">
                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Empty State --}}
    <div id="empty-state" class="card shadow-sm d-none">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="font-weight-bold">Tidak ada pesanan</h5>
            <p class="text-muted small mb-0">Belum ada pesanan dengan status ini</p>
        </div>
    </div>

@endsection

@push('scripts')
<script>
let currentFilter = 'semua';
let currentSearch = '';

function filterStatus(status) {
    currentFilter = status;

    document.querySelectorAll('.tab-btn').forEach(btn => {
        const isActive = btn.dataset.tab === status;
        btn.classList.toggle('bg-primary', isActive);
        btn.classList.toggle('text-white', isActive);
        btn.classList.toggle('text-dark', !isActive);
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

    document.getElementById('empty-state').classList.toggle('d-none', visible > 0);
}

document.getElementById('search-input').addEventListener('input', (e) => {
    currentSearch = e.target.value;
    applyFilter();
});

function verifikasiCepat(nomor) {
    if (confirm('Verifikasi pesanan ' + nomor + '?\n\nPesanan akan berubah status menjadi "Diproses".')) {
        alert('Pesanan ' + nomor + ' berhasil diverifikasi!');
    }
}
</script>
@endpush