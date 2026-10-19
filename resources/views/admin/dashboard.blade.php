@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-desc', 'Ringkasan performa dan aktivitas toko alat pertanian SIMANTAP')

@section('content')

    {{-- Stat Cards --}}
    <div class="row">

        {{-- Transaksi Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Transaksi Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalTransaksiHariIni ?? 0 }}
                            </div>
                            <div class="text-xs text-muted mt-1">Total pesanan & kasir</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pemasukan Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pemasukan Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-success">
                                Rp {{ number_format($pemasukanHariIni ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-muted mt-1">Penjualan tuntas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengeluaran Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pengeluaran Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-danger">
                                Rp {{ number_format($pengeluaranHariIni ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-muted mt-1">Pembelian supplier / operasional</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stok Menipis (&lt; 10)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $produkStokMenipis ?? 0 }} Produk
                            </div>
                            <div class="text-xs text-muted mt-1">Perlu restock supplier</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Banner Selamat Datang --}}
    <div class="card shadow mb-4" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%); border: none;">
        <div class="card-body text-white p-4">
            <h5 class="font-weight-bold mb-2">
                <i class="fas fa-seedling mr-1"></i>
                Selamat Datang di Panel Admin SIMANTAP!
            </h5>
            <p class="mb-3 text-white-50">
                Kelola data master produk alat pertanian, transaksi kasir, pembelian supplier, laporan buku kas, dan akun pengguna dengan mudah dalam satu sistem terpadu.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-light btn-sm text-success font-weight-bold mr-2 mb-1">
                    <i class="fas fa-box mr-1"></i> Kelola Produk
                </a>
                <a href="{{ route('admin.pembelian.create') }}" class="btn btn-outline-light btn-sm font-weight-bold mr-2 mb-1">
                    <i class="fas fa-shopping-cart mr-1"></i> Catat Pembelian Supplier
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-light btn-sm font-weight-bold mb-1">
                    <i class="fas fa-chart-line mr-1"></i> Laporan Keuangan
                </a>
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-receipt mr-1"></i> Transaksi Penjualan Terbaru
            </h6>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-primary">
                Lihat Semua Transaksi <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Kasir</th>
                            <th>Waktu</th>
                            <th class="text-right">Total</th>
                            <th>Status</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($transaksiTerbaru ?? []) as $t)
                        @php
                            $badgeClass = match($t->status) {
                                'menunggu_verifikasi' => 'badge-warning',
                                'diproses' => 'badge-info',
                                'dikirim' => 'badge-primary',
                                'selesai' => 'badge-success',
                                default => 'badge-danger',
                            };
                            $labelStatus = match($t->status) {
                                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                'diproses' => 'Diproses',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai',
                                default => 'Ditolak',
                            };
                            $kode = $t->kode_transaksi ?? ('TRX-' . str_pad($t->id, 4, '0', STR_PAD_LEFT));
                        @endphp
                        <tr>
                            <td class="align-middle font-weight-bold text-primary">{{ $kode }}</td>
                            <td class="align-middle font-weight-bold">{{ $t->nama_pelanggan ?? ($t->pelanggan->nama ?? 'Pelanggan Toko') }}</td>
                            <td class="align-middle text-muted">{{ $t->kasir->nama ?? 'Online' }}</td>
                            <td class="align-middle small">{{ optional($t->tanggal_transaksi)->format('d M Y, H:i') ?? '-' }}</td>
                            <td class="align-middle text-right font-weight-bold text-success">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ $badgeClass }} px-2 py-1">{{ $labelStatus }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.transaksi.show', $t->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data transaksi yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection