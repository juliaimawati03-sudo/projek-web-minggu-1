@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-desc', 'Daftar semua transaksi yang telah selesai dan tuntas')

@section('content')

    {{-- Ringkasan --}}
    <div class="row mb-4">

        <div class="col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Transaksi Selesai
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $jumlahTransaksi ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-success">
                                Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Card Tabel --}}
    <div class="card shadow mb-4">

        {{-- Filter tanggal --}}
        <div class="card-header py-3">
            <form method="GET" action="{{ route('kasir.riwayat.index') }}" class="form-inline">
                <label class="mr-2 font-weight-bold">Dari:</label>
                <input type="date" name="dari" value="{{ old('dari', $dari ?? '') }}"
                       class="form-control form-control-sm mr-2 mb-2">

                <label class="mr-2 ml-2 font-weight-bold">Sampai:</label>
                <input type="date" name="sampai" value="{{ old('sampai', $sampai ?? '') }}"
                       class="form-control form-control-sm mr-2 mb-2">

                <button type="submit" class="btn btn-sm btn-success mb-2 mr-2">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>

                @if (($dari ?? '') || ($sampai ?? ''))
                    <a href="{{ route('kasir.riwayat.index') }}" class="btn btn-sm btn-secondary mb-2">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="card-body">

            {{-- Error validasi --}}
            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger small">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Kasir / Pelanggan</th>
                            <th>Metode Bayar</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Bayar</th>
                            <th class="text-right">Kembalian</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi ?? [] as $item)
                            <tr>
                                <td class="align-middle text-center">{{ $transaksi->firstItem() + $loop->index }}</td>
                                <td class="align-middle font-weight-bold text-primary">
                                    {{ $item->kode_transaksi ?? ('TRX-' . str_pad($item->id, 4, '0', STR_PAD_LEFT)) }}
                                </td>
                                <td class="align-middle small">
                                    {{ optional($item->tanggal_transaksi)->format('d/m/Y H:i') ?? '-' }}
                                </td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-dark">
                                        {{ $item->nama_pelanggan ?? ($item->pelanggan->nama ?? 'Pelanggan Toko') }}
                                    </div>
                                    <small class="text-muted">
                                        Kasir: {{ $item->kasir->nama ?? '-' }}
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-light border">
                                        {{ $item->metode_pembayaran ?? 'Tunai' }}
                                    </span>
                                </td>
                                <td class="align-middle text-right font-weight-bold text-success">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-right">
                                    Rp {{ number_format($item->nominal_bayar, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-right">
                                    Rp {{ number_format($item->kembalian, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalDetail{{ $item->id }}" title="Lihat Rincian">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="fas fa-receipt fa-3x mb-2 text-gray-300 d-block"></i>
                                    Belum ada data riwayat transaksi yang selesai.
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

    {{-- Modal Rincian untuk Masing-masing Transaksi --}}
    @foreach ($transaksi ?? [] as $item)
        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title font-weight-bold">
                            <i class="fas fa-receipt mr-1"></i> Rincian {{ $item->kode_transaksi ?? ('TRX-' . str_pad($item->id, 4, '0', STR_PAD_LEFT)) }}
                        </h5>
                        <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small d-block">Waktu Transaksi</span>
                                <strong>{{ optional($item->tanggal_transaksi)->format('d F Y, H:i') ?? '-' }}</strong>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small d-block">Petugas Kasir</span>
                                <strong>{{ $item->kasir->nama ?? '-' }}</strong>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small d-block">Pelanggan</span>
                                <strong>{{ $item->nama_pelanggan ?? ($item->pelanggan->nama ?? 'Pelanggan Langsung') }}</strong>
                                @if($item->no_hp)
                                    <div class="small text-muted">{{ $item->no_hp }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted small d-block">Metode Pembayaran</span>
                                <span class="badge badge-success px-2 py-1">{{ $item->metode_pembayaran ?? 'Tunai' }}</span>
                            </div>
                            @if($item->alamat)
                                <div class="col-12 mb-2">
                                    <span class="text-muted small d-block">Alamat Pengiriman</span>
                                    <p class="small text-dark mb-0">{{ $item->alamat }}</p>
                                </div>
                            @endif
                        </div>

                        <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3">
                            <i class="fas fa-box-open mr-1"></i> Produk yang Dibeli
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th class="text-center" width="80">Qty</th>
                                        <th class="text-right" width="120">Harga Satuan</th>
                                        <th class="text-right" width="130">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->detailTransaksis as $d)
                                        <tr>
                                            <td>{{ $d->produk->nama_produk ?? 'Produk dihapus' }}</td>
                                            <td class="text-center">{{ $d->jumlah }}</td>
                                            <td class="text-right">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="text-right font-weight-bold">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada data rincian produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    @if($item->ongkir > 0)
                                        <tr>
                                            <td colspan="3" class="text-right font-weight-bold">Ongkos Kirim:</td>
                                            <td class="text-right font-weight-bold">Rp {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-right font-weight-bold text-dark">Total Pembayaran:</td>
                                        <td class="text-right font-weight-bold text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Nominal Bayar:</td>
                                        <td class="text-right">Rp {{ number_format($item->nominal_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Kembalian:</td>
                                        <td class="text-right">Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection