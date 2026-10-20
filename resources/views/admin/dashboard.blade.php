@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-desc', 'Informasi lengkap transaksi dan produk yang dibeli')

@section('content')

    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary mb-3">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>

    <div class="row">

        {{-- Info Transaksi --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        #TRX-{{ str_pad($transaksi['id'] ?? 124, 4, '0', STR_PAD_LEFT) }}
                    </h6>
                    <span class="badge badge-success">Selesai</span>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Kasir</span>
                        <span class="font-weight-bold">{{ $transaksi['kasir'] ?? 'Siti Aminah' }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Tanggal</span>
                        <span class="font-weight-bold">{{ $transaksi['tanggal'] ?? '25 Sep 2026, 10:12' }}</span>
                    </div>
                    <hr>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Total Harga</span>
                        <span class="font-weight-bold">Rp {{ number_format($transaksi['total'] ?? 350000, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Nominal Bayar</span>
                        <span class="font-weight-bold">Rp {{ number_format($transaksi['bayar'] ?? 400000, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-0 d-flex justify-content-between">
                        <span class="text-muted">Kembalian</span>
                        <span class="font-weight-bold">Rp {{ number_format($transaksi['kembali'] ?? 50000, 0, ',', '.') }}</span>
                    </div>

                    <hr>
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-print mr-1"></i> Cetak Struk
                    </button>
                </div>
            </div>
        </div>

        {{-- Rincian Produk --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Produk</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $items = [
                                        ['produk'=>'Cangkul Baja EGA','jumlah'=>2,'harga'=>85000],
                                        ['produk'=>'Pupuk NPK Mutiara 1kg','jumlah'=>4,'harga'=>35000],
                                        ['produk'=>'Benih Cabai Hibrida','jumlah'=>1,'harga'=>40000],
                                    ];
                                @endphp
                                @foreach(($detailTransaksi ?? $items) as $d)
                                <tr>
                                    <td class="font-weight-bold">{{ $d['produk'] }}</td>
                                    <td>{{ $d['jumlah'] }}</td>
                                    <td>Rp {{ number_format($d['harga'], 0, ',', '.') }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($d['jumlah'] * $d['harga'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <td colspan="3" class="text-right font-weight-bold">Total</td>
                                    <td class="font-weight-bold text-primary">
                                        Rp {{ number_format($transaksi['total'] ?? 350000, 0, ',', '.') }}
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