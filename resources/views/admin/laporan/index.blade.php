@extends('layouts.admin')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-desc', 'Ringkasan pemasukan dan pengeluaran toko')

@section('content')
<div class="space-y-4">

    <!-- Filter periode -->
    <div class="bg-white rounded-xl border border-neutral-200 p-4 flex flex-col sm:flex-row sm:items-center gap-3">
        <label class="text-sm font-medium text-neutral-700">Periode Laporan</label>
        <input type="date" value="2026-09-01" class="px-3 py-2 rounded-lg border border-neutral-200 text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        <span class="text-neutral-500 text-sm">s/d</span>
        <input type="date" value="2026-09-25" class="px-3 py-2 rounded-lg border border-neutral-200 text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        <button class="inline-flex items-center gap-2 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-4 py-2 transition">
            Tampilkan
        </button>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <p class="text-neutral-500 text-sm">Total Pemasukan</p>
            <p class="text-2xl font-bold text-primary-dark mt-2">Rp {{ number_format($totalPemasukan ?? 18450000, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <p class="text-neutral-500 text-sm">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($totalPengeluaran ?? 6250000, 0, ',', '.') }}</p>
        </div>
        <div class="bg-primary-pale rounded-xl border border-primary-light/30 p-5">
            <p class="text-primary-dark text-sm">Laba Bersih</p>
            <p class="text-2xl font-bold text-primary-dark mt-2">Rp {{ number_format(($totalPemasukan ?? 18450000) - ($totalPengeluaran ?? 6250000), 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tabel catatan keuangan -->
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-200 flex items-center justify-between">
            <h2 class="font-semibold text-neutral-800">Rincian Catatan Keuangan</h2>
            <button class="inline-flex items-center gap-2 text-sm text-primary font-medium hover:text-primary-dark">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                Unduh Laporan
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-neutral-100 text-neutral-500 text-left">
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Keterangan</th>
                        <th class="px-5 py-3 font-medium">Dicatat Oleh</th>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @php
                        $catatan = [
                            ['tanggal'=>'25 Sep 2026','ket'=>'Penjualan harian — 18 transaksi','user'=>'Siti Aminah','jenis'=>'pemasukan','nominal'=>2450000],
                            ['tanggal'=>'24 Sep 2026','ket'=>'Pembelian stok dari CV Tani Makmur','user'=>'Admin Utama','jenis'=>'pengeluaran','nominal'=>850000],
                            ['tanggal'=>'23 Sep 2026','ket'=>'Penjualan harian — 22 transaksi','user'=>'Budi Santoso','jenis'=>'pemasukan','nominal'=>3100000],
                            ['tanggal'=>'22 Sep 2026','ket'=>'Pembelian stok dari UD Sumber Subur','user'=>'Admin Utama','jenis'=>'pengeluaran','nominal'=>1200000],
                        ];
                    @endphp
                    @foreach(($catatan ?? $catatan) as $c)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3 text-neutral-500">{{ $c['tanggal'] }}</td>
                        <td class="px-5 py-3 text-neutral-700 font-medium">{{ $c['ket'] }}</td>
                        <td class="px-5 py-3 text-neutral-600">{{ $c['user'] }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $c['jenis'] === 'pemasukan' ? 'bg-primary-xlight text-primary-dark' : 'bg-red-50 text-red-600' }}">
                                {{ ucfirst($c['jenis']) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right font-medium {{ $c['jenis'] === 'pemasukan' ? 'text-primary-dark' : 'text-red-600' }}">
                            {{ $c['jenis'] === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($c['nominal'], 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection