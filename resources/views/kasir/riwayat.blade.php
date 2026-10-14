@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-desc', 'Semua transaksi yang sudah selesai')

@section('content')
@php
    // DATA CONTOH: nanti diganti Raihan dengan data dari database
    $transaksi = [
        ['kode' => 'TRX-001', 'tanggal' => '2026-10-12 09:15', 'pelanggan' => 'Budi Santoso', 'metode' => 'Tunai',    'total' => 150000, 'status' => 'Selesai'],
        ['kode' => 'TRX-002', 'tanggal' => '2026-10-12 10:30', 'pelanggan' => 'Siti Aminah',  'metode' => 'Transfer', 'total' => 275000, 'status' => 'Selesai'],
        ['kode' => 'TRX-003', 'tanggal' => '2026-10-13 13:45', 'pelanggan' => 'Agus Salim',   'metode' => 'Tunai',    'total' => 78500,  'status' => 'Selesai'],
        ['kode' => 'TRX-004', 'tanggal' => '2026-10-14 08:20', 'pelanggan' => 'Dewi Lestari', 'metode' => 'Transfer', 'total' => 420000, 'status' => 'Selesai'],
    ];
    $totalPendapatan = collect($transaksi)->sum('total');
@endphp

{{-- Ringkasan --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <p class="text-sm text-neutral-500">Jumlah Transaksi</p>
        <p class="text-2xl font-bold text-neutral-800">{{ count($transaksi) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <p class="text-sm text-neutral-500">Total Pendapatan</p>
        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
    <div class="p-4 border-b border-neutral-200">
        <input type="text" placeholder="Cari kode atau nama pelanggan..."
               class="w-full sm:w-72 rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-600">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold">No</th>
                    <th class="text-left px-4 py-3 font-semibold">Kode</th>
                    <th class="text-left px-4 py-3 font-semibold">Tanggal</th>
                    <th class="text-left px-4 py-3 font-semibold">Pelanggan</th>
                    <th class="text-left px-4 py-3 font-semibold">Metode</th>
                    <th class="text-right px-4 py-3 font-semibold">Total</th>
                    <th class="text-center px-4 py-3 font-semibold">Status</th>
                    <th class="text-center px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($transaksi as $item)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-neutral-800">{{ $item['kode'] }}</td>
                        <td class="px-4 py-3 text-neutral-600">{{ $item['tanggal'] }}</td>
                        <td class="px-4 py-3">{{ $item['pelanggan'] }}</td>
                        <td class="px-4 py-3">{{ $item['metode'] }}</td>
                        <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-block rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-medium">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="rounded-lg bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 text-xs font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-neutral-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection