@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-desc', 'Semua transaksi yang sudah selesai')

@section('content')
@php
    // DATA CONTOH: nanti diganti Raihan dengan data dari database
    // Kolom mengikuti class diagram: tanggal_transaksi, total_harga, nominal_bayar, kembalian
    $semuaTransaksi = [
        ['kode' => 'TRX-001', 'tanggal' => '2026-10-12', 'jam' => '09:15', 'kasir' => 'Kasir SIMANTAP', 'total' => 150000, 'bayar' => 200000],
        ['kode' => 'TRX-002', 'tanggal' => '2026-10-12', 'jam' => '10:30', 'kasir' => 'Kasir SIMANTAP', 'total' => 275000, 'bayar' => 300000],
        ['kode' => 'TRX-003', 'tanggal' => '2026-10-13', 'jam' => '13:45', 'kasir' => 'Kasir SIMANTAP', 'total' => 78500,  'bayar' => 100000],
        ['kode' => 'TRX-004', 'tanggal' => '2026-10-14', 'jam' => '08:20', 'kasir' => 'Kasir SIMANTAP', 'total' => 420000, 'bayar' => 420000],
    ];

    // Filter tanggal (sesuai activity diagram)
    $dari   = request('dari');
    $sampai = request('sampai');

    $transaksi = collect($semuaTransaksi)->filter(function ($t) use ($dari, $sampai) {
        if ($dari && $t['tanggal'] < $dari) return false;
        if ($sampai && $t['tanggal'] > $sampai) return false;
        return true;
    })->values()->all();

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

<div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">

    {{-- Filter tanggal --}}
    <form method="GET" class="p-4 border-b border-neutral-200 flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-medium text-neutral-600 mb-1">Dari tanggal</label>
            <input type="date" name="dari" value="{{ $dari }}"
                   class="rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-neutral-600 mb-1">Sampai tanggal</label>
            <input type="date" name="sampai" value="{{ $sampai }}"
                   class="rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <button type="submit" class="rounded-lg bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm font-medium">
            Filter
        </button>
        @if ($dari || $sampai)
            <a href="{{ url()->current() }}" class="rounded-lg border border-neutral-300 hover:bg-neutral-50 px-4 py-2 text-sm text-neutral-700">
                Reset
            </a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-600">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold">No</th>
                    <th class="text-left px-4 py-3 font-semibold">Kode</th>
                    <th class="text-left px-4 py-3 font-semibold">Tanggal</th>
                    <th class="text-left px-4 py-3 font-semibold">Kasir</th>
                    <th class="text-right px-4 py-3 font-semibold">Total Harga</th>
                    <th class="text-right px-4 py-3 font-semibold">Nominal Bayar</th>
                    <th class="text-right px-4 py-3 font-semibold">Kembalian</th>
                    <th class="text-center px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($transaksi as $item)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-neutral-800">{{ $item['kode'] }}</td>
                        <td class="px-4 py-3 text-neutral-600">{{ $item['tanggal'] }} {{ $item['jam'] }}</td>
                        <td class="px-4 py-3">{{ $item['kasir'] }}</td>
                        <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($item['bayar'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($item['bayar'] - $item['total'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="rounded-lg bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 text-xs font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-neutral-500">
                            Tidak ada transaksi pada rentang tanggal ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection