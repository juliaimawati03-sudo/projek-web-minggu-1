@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi Penjualan')
@section('page-desc', 'Informasi lengkap transaksi, pelanggan, pembayaran, dan produk yang dibeli')

@section('content')

    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary mb-3">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Transaksi
    </a>

    @php
        $badgeClass = match($transaksi->status) {
            'menunggu_verifikasi' => 'badge-warning',
            'diproses' => 'badge-info',
            'dikirim' => 'badge-primary',
            'selesai' => 'badge-success',
            default => 'badge-danger',
        };
        $labelStatus = match($transaksi->status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            default => 'Ditolak',
        };
        $kode = $transaksi->kode_transaksi ?? ('TRX-' . str_pad($transaksi->id, 4, '0', STR_PAD_LEFT));
    @endphp

    <div class="row">

        {{-- Info Transaksi --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $kode }}</h6>
                    <span class="badge {{ $badgeClass }} px-2 py-1">{{ $labelStatus }}</span>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Pelanggan</span>
                        <span class="font-weight-bold">{{ $transaksi->nama_pelanggan ?? ($transaksi->pelanggan->nama ?? 'Pelanggan Toko') }}</span>
                    </div>
                    @if($transaksi->no_hp)
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">No. HP</span>
                        <span class="font-weight-bold">{{ $transaksi->no_hp }}</span>
                    </div>
                    @endif
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Petugas Kasir</span>
                        <span class="font-weight-bold">{{ $transaksi->kasir->nama ?? 'Online' }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Waktu Transaksi</span>
                        <span class="font-weight-bold">{{ optional($transaksi->tanggal_transaksi)->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Metode Bayar</span>
                        <span class="badge badge-light border">{{ $transaksi->metode_pembayaran ?? 'Tunai' }}</span>
                    </div>

                    @if($transaksi->alamat)
                    <div class="mb-3">
                        <span class="text-muted small d-block">Alamat Pengiriman:</span>
                        <span class="small text-dark font-weight-bold">{{ $transaksi->alamat }}</span>
                    </div>
                    @endif

                    <hr>
                    @if($transaksi->ongkir > 0)
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Ongkir</span>
                        <span class="font-weight-bold">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted font-weight-bold">Total Harga</span>
                        <span class="font-weight-bold text-success" style="font-size: 18px;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Nominal Bayar</span>
                        <span class="font-weight-bold">Rp {{ number_format($transaksi->nominal_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-0 d-flex justify-content-between">
                        <span class="text-muted">Kembalian</span>
                        <span class="font-weight-bold">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                    </div>

                    <hr>
                    <button class="btn btn-primary btn-block" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Cetak Dokumen Transaksi
                    </button>
                </div>
            </div>
        </div>

        {{-- Rincian Produk --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-box-open mr-1"></i> Rincian Produk yang Dibeli
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%">
                            <thead class="bg-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center" width="80">Qty</th>
                                    <th class="text-right" width="140">Harga Satuan</th>
                                    <th class="text-right" width="150">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi->detailTransaksis as $d)
                                <tr>
                                    <td class="font-weight-bold text-dark">{{ $d->produk->nama_produk ?? 'Produk dihapus' }}</td>
                                    <td class="text-center">{{ $d->jumlah }}</td>
                                    <td class="text-right">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-right font-weight-bold text-dark">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tidak ada rincian item pada transaksi ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                @if($transaksi->ongkir > 0)
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">Ongkos Kirim</td>
                                    <td class="text-right font-weight-bold">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr class="bg-light">
                                    <td colspan="3" class="text-right font-weight-bold">Total Pembayaran</td>
                                    <td class="text-right font-weight-bold text-primary" style="font-size: 16px;">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection