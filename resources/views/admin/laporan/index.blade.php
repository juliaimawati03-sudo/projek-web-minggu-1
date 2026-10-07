@extends('layouts.admin')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-desc', 'Ringkasan pemasukan dan pengeluaran toko')

@section('content')

    {{-- Filter Periode --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-inline">
                <label class="mr-2 font-weight-bold">Periode:</label>
                <input type="date" class="form-control mr-2 mb-2" value="2026-09-01">
                <span class="mr-2 mb-2">s/d</span>
                <input type="date" class="form-control mr-2 mb-2" value="2026-09-25">
                <button type="button" class="btn btn-success mb-2">
                    <i class="fas fa-search mr-1"></i> Tampilkan
                </button>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Debit (Pemasukan)
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalDebit ?? 18450000, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Kredit (Pengeluaran)
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalKredit ?? 6250000, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Saldo / Laba Bersih
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-primary">
                                Rp {{ number_format(($totalDebit ?? 18450000) - ($totalKredit ?? 6250000), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Catatan Keuangan --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-book mr-1"></i> Buku Kas — Rincian Catatan Keuangan
            </h6>
            <button class="btn btn-sm btn-success">
                <i class="fas fa-download mr-1"></i> Unduh Laporan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Dicatat Oleh</th>
                            <th class="text-right">Debit (Rp)</th>
                            <th class="text-right">Kredit (Rp)</th>
                            <th class="text-right">Saldo (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $catatan = [
                                ['tanggal'=>'25 Sep 2026','ket'=>'Penjualan harian — 18 transaksi','user'=>'Siti Aminah','jenis'=>'pemasukan','nominal'=>2450000],
                                ['tanggal'=>'24 Sep 2026','ket'=>'Pembelian stok dari CV Tani Makmur','user'=>'Admin Utama','jenis'=>'pengeluaran','nominal'=>850000],
                                ['tanggal'=>'23 Sep 2026','ket'=>'Penjualan harian — 22 transaksi','user'=>'Budi Santoso','jenis'=>'pemasukan','nominal'=>3100000],
                                ['tanggal'=>'22 Sep 2026','ket'=>'Pembelian stok dari UD Sumber Subur','user'=>'Admin Utama','jenis'=>'pengeluaran','nominal'=>1200000],
                            ];
                            $saldo = 0;
                        @endphp
                        @foreach(($catatan ?? []) as $i => $c)
                            @php
                                // Hitung debit, kredit, saldo
                                $debit  = $c['jenis'] === 'pemasukan'   ? $c['nominal'] : 0;
                                $kredit = $c['jenis'] === 'pengeluaran' ? $c['nominal'] : 0;
                                $saldo += $debit - $kredit;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $c['tanggal'] }}</td>
                                <td class="font-weight-bold">{{ $c['ket'] }}</td>
                                <td>{{ $c['user'] }}</td>
                                <td class="text-right {{ $debit > 0 ? 'text-success font-weight-bold' : '' }}">
                                    {{ $debit > 0 ? number_format($debit, 0, ',', '.') : '—' }}
                                </td>
                                <td class="text-right {{ $kredit > 0 ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '—' }}
                                </td>
                                <td class="text-right font-weight-bold">
                                    {{ number_format($saldo, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light">
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">TOTAL</td>
                            <td class="text-right text-success">
                                Rp {{ number_format($totalDebit ?? 18450000, 0, ',', '.') }}
                            </td>
                            <td class="text-right text-danger">
                                Rp {{ number_format($totalKredit ?? 6250000, 0, ',', '.') }}
                            </td>
                            <td class="text-right text-primary">
                                Rp {{ number_format(($totalDebit ?? 18450000) - ($totalKredit ?? 6250000), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Legend --}}
            <div class="mt-3 small text-muted">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Debit</strong> = pemasukan &nbsp;|&nbsp;
                <strong>Kredit</strong> = pengeluaran &nbsp;|&nbsp;
                <strong>Saldo</strong> = akumulasi Debit − Kredit
            </div>
        </div>
    </div>

@endsection