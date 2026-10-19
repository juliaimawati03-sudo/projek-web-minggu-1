@extends('layouts.kasir')

@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')
@section('page-desc', 'Kelola, verifikasi pembayaran, dan perbarui status pesanan pelanggan')

@section('content')

    {{-- Filter Tabs --}}
    <div class="card shadow mb-4">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap gap-1">
                <button onclick="filterStatus('semua')" data-tab="semua"
                        class="tab-btn btn btn-sm font-weight-bold active bg-primary text-white mr-1 mb-1">
                    Semua ({{ $counts['semua'] ?? 0 }})
                </button>
                <button onclick="filterStatus('menunggu_verifikasi')" data-tab="menunggu_verifikasi"
                        class="tab-btn btn btn-sm font-weight-bold text-dark mr-1 mb-1">
                    <i class="fas fa-clock text-warning mr-1"></i> Menunggu Verifikasi ({{ $counts['menunggu_verifikasi'] ?? 0 }})
                </button>
                <button onclick="filterStatus('diproses')" data-tab="diproses"
                        class="tab-btn btn btn-sm font-weight-bold text-dark mr-1 mb-1">
                    <i class="fas fa-spinner text-info mr-1"></i> Diproses ({{ $counts['diproses'] ?? 0 }})
                </button>
                <button onclick="filterStatus('dikirim')" data-tab="dikirim"
                        class="tab-btn btn btn-sm font-weight-bold text-dark mr-1 mb-1">
                    <i class="fas fa-truck text-purple mr-1"></i> Dikirim ({{ $counts['dikirim'] ?? 0 }})
                </button>
                <button onclick="filterStatus('selesai')" data-tab="selesai"
                        class="tab-btn btn btn-sm font-weight-bold text-dark mr-1 mb-1">
                    <i class="fas fa-check-circle text-success mr-1"></i> Selesai ({{ $counts['selesai'] ?? 0 }})
                </button>
                @if(($counts['ditolak'] ?? 0) > 0)
                <button onclick="filterStatus('ditolak')" data-tab="ditolak"
                        class="tab-btn btn btn-sm font-weight-bold text-dark mr-1 mb-1">
                    <i class="fas fa-times-circle text-danger mr-1"></i> Ditolak ({{ $counts['ditolak'] ?? 0 }})
                </button>
                @endif
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
                       placeholder="Cari nomor pesanan, nama pelanggan, atau nomor HP...">
            </div>
        </div>
    </div>

    {{-- Daftar Pesanan --}}
    <div id="daftar-pesanan">

        @forelse($pesanan as $p)
            @php
                $statusClass = match($p->status) {
                    'menunggu_verifikasi' => 'border-left-warning',
                    'diproses' => 'border-left-info',
                    'dikirim' => 'border-left-primary',
                    'selesai' => 'border-left-success',
                    default => 'border-left-danger',
                };
                $badgeClass = match($p->status) {
                    'menunggu_verifikasi' => 'badge-warning',
                    'diproses' => 'badge-info',
                    'dikirim' => 'badge-primary',
                    'selesai' => 'badge-success',
                    default => 'badge-danger',
                };
                $statusLabel = match($p->status) {
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'diproses' => 'Diproses',
                    'dikirim' => 'Dikirim',
                    'selesai' => 'Selesai',
                    default => 'Ditolak',
                };
                $kode = $p->kode_transaksi ?? ('ORD-' . str_pad($p->id, 4, '0', STR_PAD_LEFT));
                $namaPelanggan = $p->nama_pelanggan ?? ($p->pelanggan->nama ?? 'Pelanggan');
                $searchIndex = strtolower($kode . ' ' . $namaPelanggan . ' ' . $p->no_hp . ' ' . $p->metode_pembayaran);
            @endphp

            <div class="pesanan-card card shadow-sm mb-3 {{ $statusClass }}"
                 data-status="{{ $p->status }}"
                 data-search="{{ $searchIndex }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="font-weight-bold text-dark mr-2" style="font-family: monospace; font-size: 16px;">
                                    {{ $kode }}
                                </span>
                                <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                            </div>
                            <div class="text-muted small">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $p->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-muted small">Total Pembayaran</div>
                            <div class="h5 mb-0 font-weight-bold text-success">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <div class="text-muted small mb-1">Nama Pelanggan</div>
                            <div class="font-weight-bold">{{ $namaPelanggan }}</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="text-muted small mb-1">Nomor HP / WhatsApp</div>
                            <div class="font-weight-bold">{{ $p->no_hp ?? '-' }}</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="text-muted small mb-1">Metode Pembayaran</div>
                            <div class="font-weight-bold">{{ $p->metode_pembayaran ?? 'Tunai' }}</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="text-muted small mb-1">Petugas Kasir</div>
                            <div class="font-weight-bold text-muted">{{ $p->kasir->nama ?? 'Belum diverifikasi' }}</div>
                        </div>
                    </div>

                    {{-- Ringkasan Item Produk --}}
                    <div class="mb-3">
                        @if($p->detailTransaksis->count() > 0)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($p->detailTransaksis as $d)
                                    <span class="badge badge-light border mr-1 mb-1 p-1.5">
                                        {{ $d->produk->nama_produk ?? 'Alat Tani' }} × {{ $d->jumlah }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="badge badge-light border">Tidak ada rincian item</span>
                        @endif
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2 pt-3 border-top flex-wrap">
                        <a href="{{ route('kasir.pesanan.show', $p->id) }}"
                           class="btn btn-outline-secondary btn-sm mr-2 mb-1">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                        </a>

                        @if($p->status === 'menunggu_verifikasi')
                            {{-- Form Verifikasi Cepat (Status -> Diproses) --}}
                            <form action="{{ route('kasir.pesanan.verifikasi', $p->id) }}" method="POST" class="d-inline mr-2 mb-1"
                                  onsubmit="return confirm('Verifikasi pesanan {{ $kode }}?\n\nStatus pesanan akan berubah menjadi DIPROSES.')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm font-weight-bold">
                                    <i class="fas fa-check-circle mr-1"></i> Verifikasi Pembayaran
                                </button>
                            </form>

                            {{-- Form Tolak Bukti Transfer --}}
                            <form action="{{ route('kasir.pesanan.tolak', $p->id) }}" method="POST" class="d-inline mb-1"
                                  onsubmit="return confirm('Tolak bukti pembayaran pesanan {{ $kode }}?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-times-circle mr-1"></i> Tolak
                                </button>
                            </form>
                        @elseif($p->status === 'diproses')
                            <form action="{{ route('kasir.pesanan.status', $p->id) }}" method="POST" class="d-inline mr-2 mb-1"
                                  onsubmit="return confirm('Tandai pesanan {{ $kode }} telah DIKIRIM / SIAP DIAMBIL?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="dikirim">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-truck mr-1"></i> Kirim Pesanan
                                </button>
                            </form>
                        @elseif($p->status === 'dikirim')
                            <form action="{{ route('kasir.pesanan.status', $p->id) }}" method="POST" class="d-inline mr-2 mb-1"
                                  onsubmit="return confirm('Selesaikan pesanan {{ $kode }}?\n\nPesanan akan ditandai SELESAI dan masuk ke riwayat transaksi kasir.')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check-double mr-1"></i> Tandai Selesai
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="font-weight-bold">Belum Ada Pesanan Masuk</h5>
                    <p class="text-muted small mb-0">Pesanan dari pelanggan akan muncul secara otomatis di sini.</p>
                </div>
            </div>
        @endforelse

    </div>

    {{-- Empty State untuk filter Javascript --}}
    <div id="empty-state" class="card shadow-sm d-none">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="font-weight-bold">Tidak ada pesanan</h5>
            <p class="text-muted small mb-0">Belum ada pesanan yang sesuai dengan filter atau kata kunci ini.</p>
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

    const empty = document.getElementById('empty-state');
    if (empty) {
        empty.classList.toggle('d-none', visible > 0);
    }
}

document.getElementById('search-input').addEventListener('input', (e) => {
    currentSearch = e.target.value.trim();
    applyFilter();
});
</script>
@endpush