@extends('layouts.admin')

@section('title', 'Data Transaksi Penjualan')
@section('page-title', 'Transaksi Penjualan')
@section('page-desc', 'Daftar seluruh transaksi kasir dan pesanan online yang tercatat di sistem')

@section('content')

    {{-- Filter Periode & Status --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.transaksi.index') }}" class="form-inline flex-wrap">
                <label class="mr-2 font-weight-bold">Dari:</label>
                <input type="date" name="dari" value="{{ old('dari', $dari ?? '') }}" class="form-control form-control-sm mr-2 mb-2">

                <label class="mr-2 ml-2 font-weight-bold">Sampai:</label>
                <input type="date" name="sampai" value="{{ old('sampai', $sampai ?? '') }}" class="form-control form-control-sm mr-2 mb-2">

                <label class="mr-2 ml-2 font-weight-bold">Status:</label>
                <select name="status" class="form-control form-control-sm mr-2 mb-2">
                    <option value="">— Semua Status —</option>
                    <option value="menunggu_verifikasi" {{ ($status ?? '') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="diproses" {{ ($status ?? '') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="dikirim" {{ ($status ?? '') === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="selesai" {{ ($status ?? '') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ ($status ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <button type="submit" class="btn btn-sm btn-primary mb-2 mr-2">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>

                @if (($dari ?? '') || ($sampai ?? '') || ($status ?? ''))
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary mb-2">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi & Pesanan</h6>
            <span class="badge badge-primary px-2 py-1">Total: {{ $totalTransaksi ?? 0 }} Transaksi</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="40">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Pelanggan / Kasir</th>
                            <th>Metode Bayar</th>
                            <th class="text-right">Total Harga</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $t)
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
                            <td class="align-middle text-center">{{ $transaksi->firstItem() + $loop->index }}</td>
                            <td class="align-middle font-weight-bold text-primary">{{ $kode }}</td>
                            <td class="align-middle small">
                                {{ optional($t->tanggal_transaksi)->format('d M Y, H:i') ?? '-' }}
                            </td>
                            <td class="align-middle">
                                <div class="font-weight-bold text-dark">
                                    {{ $t->nama_pelanggan ?? ($t->pelanggan->nama ?? 'Pelanggan Toko') }}
                                </div>
                                <small class="text-muted">Kasir: {{ $t->kasir->nama ?? 'Online' }}</small>
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-light border">{{ $t->metode_pembayaran ?? 'Tunai' }}</span>
                            </td>
                            <td class="align-middle text-right font-weight-bold text-success">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ $badgeClass }} px-2 py-1">{{ $labelStatus }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.transaksi.show', $t->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                Belum ada data transaksi yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($transaksi) && $transaksi->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $transaksi->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection