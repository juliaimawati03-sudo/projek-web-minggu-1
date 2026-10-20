@extends('layouts.admin')

@section('title', 'Data Transaksi')
@section('page-title', 'Transaksi Penjualan')
@section('page-desc', 'Daftar seluruh transaksi yang tercatat di sistem')

@section('content')
<div class="space-y-4">

    <!-- Filter bar -->
    <div class="bg-white rounded-xl border border-neutral-200 p-4 flex flex-col sm:flex-row sm:items-center gap-3">
        <div class="relative flex-1">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" placeholder="Cari ID transaksi atau nama kasir..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        </div>
        <input type="date" class="px-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        <select class="px-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
            <option>Semua Kasir</option>
            <option>Siti Aminah</option>
            <option>Budi Santoso</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-neutral-100 text-neutral-500 text-left">
                        <th class="px-5 py-3 font-medium">ID</th>
                        <th class="px-5 py-3 font-medium">Kasir</th>
                        <th class="px-5 py-3 font-medium">Tanggal Transaksi</th>
                        <th class="px-5 py-3 font-medium">Total Harga</th>
                        <th class="px-5 py-3 font-medium">Nominal Bayar</th>
                        <th class="px-5 py-3 font-medium">Kembalian</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @php
                        $dummy = [
                            ['id'=>124,'kasir'=>'Siti Aminah','tanggal'=>'25 Sep 2026, 10:12','total'=>350000,'bayar'=>400000,'kembali'=>50000],
                            ['id'=>123,'kasir'=>'Budi Santoso','tanggal'=>'25 Sep 2026, 09:47','total'=>1250000,'bayar'=>1250000,'kembali'=>0],
                            ['id'=>122,'kasir'=>'Siti Aminah','tanggal'=>'24 Sep 2026, 16:30','total'=>175000,'bayar'=>200000,'kembali'=>25000],
                        ];
                    @endphp
                    @forelse(($transaksi ?? $dummy) as $t)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3 font-medium text-neutral-700">#TRX-{{ str_pad($t['id'], 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-5 py-3 text-neutral-600">{{ $t['kasir'] }}</td>
                        <td class="px-5 py-3 text-neutral-500">{{ $t['tanggal'] }}</td>
                        <td class="px-5 py-3 font-medium text-neutral-700">Rp {{ number_format($t['total'], 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-neutral-600">Rp {{ number_format($t['bayar'], 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-neutral-600">Rp {{ number_format($t['kembali'], 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.transaksi.show', $t['id']) }}"
                               class="inline-flex items-center gap-1.5 text-primary font-medium hover:text-primary-dark">
                                Lihat Detail
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-neutral-500">Belum ada data transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-5 py-3 border-t border-neutral-200 text-sm text-neutral-500">
            <span>Menampilkan 1–3 dari 3 transaksi</span>
            <div class="flex gap-1">
                <button class="px-3 py-1.5 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-neutral-100">Sebelumnya</button>
                <button class="px-3 py-1.5 rounded-lg bg-primary text-white">1</button>
                <button class="px-3 py-1.5 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-neutral-100">Berikutnya</button>
            </div>
        </div>
    </div>
</div>
@endsection