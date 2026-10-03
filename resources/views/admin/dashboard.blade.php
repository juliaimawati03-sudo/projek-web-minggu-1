@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-desc', 'Ringkasan aktivitas toko alat pertanian hari ini')

@section('content')
<div class="space-y-6">

    <!-- Stat cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Transaksi Hari Ini</p>
                <span class="w-9 h-9 rounded-lg bg-primary-xlight text-primary-dark flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5-2h6a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">{{ $totalTransaksiHariIni ?? 18 }}</p>
            <p class="text-xs text-primary-dark mt-1">+12% dari kemarin</p>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Pemasukan Hari Ini</p>
                <span class="w-9 h-9 rounded-lg bg-primary-xlight text-primary-dark flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">Rp {{ number_format($pemasukanHariIni ?? 2450000, 0, ',', '.') }}</p>
            <p class="text-xs text-primary-dark mt-1">Dari {{ $totalTransaksiHariIni ?? 18 }} transaksi</p>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Pengeluaran Hari Ini</p>
                <span class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">Rp {{ number_format($pengeluaranHariIni ?? 850000, 0, ',', '.') }}</p>
            <p class="text-xs text-neutral-500 mt-1">Pembelian ke supplier</p>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Stok Menipis</p>
                <span class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">{{ $produkStokMenipis ?? 4 }} Produk</p>
            <p class="text-xs text-neutral-500 mt-1">Stok di bawah 10 unit</p>
        </div>
    </div>

    <!-- Recent transactions -->
    <div class="bg-white rounded-xl border border-neutral-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-200">
            <h2 class="font-semibold text-neutral-800">Transaksi Terbaru</h2>
            <a href="{{ route('admin.transaksi.index') }}" class="text-sm text-primary font-medium hover:text-primary-dark">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-neutral-100 text-neutral-500 text-left">
                        <th class="px-5 py-3 font-medium">ID Transaksi</th>
                        <th class="px-5 py-3 font-medium">Kasir</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse(($transaksiTerbaru ?? []) as $t)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3 font-medium text-neutral-700">#TRX-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-5 py-3 text-neutral-600">{{ $t->kasir->nama ?? '-' }}</td>
                        <td class="px-5 py-3 text-neutral-500">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-3 font-medium text-neutral-700">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="px-5 py-3"><span class="px-2.5 py-1 rounded-full bg-primary-xlight text-primary-dark text-xs font-medium">Selesai</span></td>
                    </tr>
                    @empty
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3 font-medium text-neutral-700">#TRX-0124</td>
                        <td class="px-5 py-3 text-neutral-600">Siti Aminah</td>
                        <td class="px-5 py-3 text-neutral-500">25 Sep 2026, 10:12</td>
                        <td class="px-5 py-3 font-medium text-neutral-700">Rp 350.000</td>
                        <td class="px-5 py-3"><span class="px-2.5 py-1 rounded-full bg-primary-xlight text-primary-dark text-xs font-medium">Selesai</span></td>
                    </tr>
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3 font-medium text-neutral-700">#TRX-0123</td>
                        <td class="px-5 py-3 text-neutral-600">Budi Santoso</td>
                        <td class="px-5 py-3 text-neutral-500">25 Sep 2026, 09:47</td>
                        <td class="px-5 py-3 font-medium text-neutral-700">Rp 1.250.000</td>
                        <td class="px-5 py-3"><span class="px-2.5 py-1 rounded-full bg-primary-xlight text-primary-dark text-xs font-medium">Selesai</span></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection