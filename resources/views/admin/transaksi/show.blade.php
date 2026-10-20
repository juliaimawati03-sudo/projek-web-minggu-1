@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-desc', 'Informasi lengkap transaksi dan produk yang dibeli')

@section('content')
<div class="space-y-4">

    <a href="{{ route('admin.transaksi.index') }}" class="inline-flex items-center gap-1.5 text-sm text-neutral-500 hover:text-neutral-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke daftar transaksi
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Info transaksi -->
        <div class="lg:col-span-1 bg-white rounded-xl border border-neutral-200 p-5 h-fit">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-neutral-800">#TRX-{{ str_pad($transaksi['id'] ?? 124, 4, '0', STR_PAD_LEFT) }}</h2>
                <span class="px-2.5 py-1 rounded-full bg-primary-xlight text-primary-dark text-xs font-medium">Selesai</span>
            </div>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Kasir</dt>
                    <dd class="text-neutral-700 font-medium">{{ $transaksi['kasir'] ?? 'Siti Aminah' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Tanggal Transaksi</dt>
                    <dd class="text-neutral-700 font-medium">{{ $transaksi['tanggal'] ?? '25 Sep 2026, 10:12' }}</dd>
                </div>
                <div class="border-t border-neutral-200 pt-3 flex justify-between">
                    <dt class="text-neutral-500">Total Harga</dt>
                    <dd class="text-neutral-800 font-semibold">Rp {{ number_format($transaksi['total'] ?? 350000, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Nominal Bayar</dt>
                    <dd class="text-neutral-700 font-medium">Rp {{ number_format($transaksi['bayar'] ?? 400000, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Kembalian</dt>
                    <dd class="text-neutral-700 font-medium">Rp {{ number_format($transaksi['kembali'] ?? 50000, 0, ',', '.') }}</dd>
                </div>
            </dl>

            <button class="w-full mt-5 flex items-center justify-center gap-2 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium py-2.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a1 1 0 001-1v-4H8v4a1 1 0 001 1zm8-12V4a1 1 0 00-1-1H8a1 1 0 00-1 1v5h10z"/></svg>
                Cetak Struk
            </button>
        </div>

        <!-- Detail produk -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-neutral-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-neutral-200">
                <h2 class="font-semibold text-neutral-800">Rincian Produk</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-neutral-100 text-neutral-500 text-left">
                            <th class="px-5 py-3 font-medium">Produk</th>
                            <th class="px-5 py-3 font-medium">Jumlah</th>
                            <th class="px-5 py-3 font-medium">Harga Satuan</th>
                            <th class="px-5 py-3 font-medium text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @php
                            $items = [
                                ['produk'=>'Cangkul Baja EGA','jumlah'=>2,'harga'=>85000],
                                ['produk'=>'Pupuk NPK Mutiara 1kg','jumlah'=>4,'harga'=>35000],
                                ['produk'=>'Benih Cabai Hibrida','jumlah'=>1,'harga'=>40000],
                            ];
                        @endphp
                        @foreach(($detailTransaksi ?? $items) as $d)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-5 py-3 text-neutral-700 font-medium">{{ $d['produk'] }}</td>
                            <td class="px-5 py-3 text-neutral-600">{{ $d['jumlah'] }}</td>
                            <td class="px-5 py-3 text-neutral-600">Rp {{ number_format($d['harga'], 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-right text-neutral-700 font-medium">Rp {{ number_format($d['jumlah'] * $d['harga'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-primary-pale">
                            <td colspan="3" class="px-5 py-3 text-right font-semibold text-neutral-700">Total</td>
                            <td class="px-5 py-3 text-right font-bold text-primary-dark">Rp {{ number_format($transaksi['total'] ?? 350000, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection