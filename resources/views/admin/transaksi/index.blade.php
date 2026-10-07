@extends('layouts.admin')

@section('title', 'Data Transaksi')
@section('page-title', 'Transaksi Penjualan')
@section('page-desc', 'Daftar seluruh transaksi yang tercatat di sistem')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kasir</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Harga</th>
                            <th>Nominal Bayar</th>
                            <th>Kembalian</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dummy = [
                                ['id'=>124,'kasir'=>'Siti Aminah','tanggal'=>'25 Sep 2026, 10:12','total'=>350000,'bayar'=>400000,'kembali'=>50000],
                                ['id'=>123,'kasir'=>'Budi Santoso','tanggal'=>'25 Sep 2026, 09:47','total'=>1250000,'bayar'=>1250000,'kembali'=>0],
                                ['id'=>122,'kasir'=>'Siti Aminah','tanggal'=>'24 Sep 2026, 16:30','total'=>175000,'bayar'=>200000,'kembali'=>25000],
                            ];
                        @endphp
                        @foreach(($transaksi ?? $dummy) as $t)
                        <tr>
                            <td class="font-weight-bold">#TRX-{{ str_pad($t['id'], 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $t['kasir'] }}</td>
                            <td>{{ $t['tanggal'] }}</td>
                            <td>Rp {{ number_format($t['total'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($t['bayar'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($t['kembali'], 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.transaksi.show', $t['id']) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection