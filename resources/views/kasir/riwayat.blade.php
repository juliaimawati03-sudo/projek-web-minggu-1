@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-desc', 'Semua transaksi yang sudah selesai')

@section('content')

    {{-- Ringkasan --}}
    <div class="row mb-4">

        <div class="col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Transaksi
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
            @if ($errors->any())
                <div class="alert alert-danger small">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th class="text-right">Total Harga</th>
                            <th class="text-right">Nominal Bayar</th>
                            <th class="text-right">Kembalian</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi ?? [] as $item)
                            <tr>
                                <td>{{ $transaksi->firstItem() + $loop->index }}</td>
                                <td class="font-weight-bold">
                                    TRX-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>{{ optional($item->tanggal_transaksi)->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>{{ $item->kasir->nama ?? $item->kasir->name ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item->nominal_bayar, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-success">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan