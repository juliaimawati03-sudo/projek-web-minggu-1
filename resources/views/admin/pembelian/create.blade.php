@extends('layouts.admin')

@section('title', 'Pembelian ke Supplier')
@section('page-title', 'Pembelian ke Supplier')
@section('page-desc', 'Catat pembelian barang dari supplier (otomatis tercatat sebagai pengeluaran)')

@section('content')
<div class="max-w-3xl space-y-4">

    <div class="bg-white rounded-xl border border-neutral-200">
        <div class="px-5 py-4 border-b border-neutral-200">
            <h2 class="font-semibold text-neutral-800">Form Pembelian</h2>
        </div>

        <form method="POST" action="{{ route('admin.pembelian.store') }}" class="p-5 space-y-5">
            @csrf

            <!-- Supplier -->
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Supplier</label>
                <select name="supplier_id" required
                    class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                    <option value="">— Pilih Supplier —</option>
                    <option value="1">CV Tani Makmur</option>
                    <option value="2">UD Sumber Subur</option>
                    <option value="3">Toko Agro Jaya</option>
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Tanggal Pembelian</label>
                <input type="date" name="tanggal" required value="{{ now()->format('Y-m-d') }}"
                    class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
            </div>

            <!-- Nominal -->
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Total Nominal (Rp)</label>
                <input type="number" name="nominal" min="0" required placeholder="Contoh: 850000"
                    class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                <p class="text-xs text-neutral-500 mt-1">Nominal ini akan otomatis tercatat sebagai pengeluaran.</p>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3" required placeholder="Contoh: Pembelian stok cangkul 10 unit"
                    class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary"></textarea>
            </div>

            <!-- Info -->
            <div class="rounded-lg bg-primary-pale border border-primary-light/30 p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-primary-dark shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm text-primary-dark">
                    <p class="font-medium">Otomatis tercatat sebagai pengeluaran</p>
                    <p class="text-xs mt-1">Setiap pembelian yang dicatat akan langsung masuk ke Laporan Keuangan sebagai pengeluaran.</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm text-neutral-500 hover:text-neutral-700 font-medium px-4 py-2.5">Batal</a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-5 py-2.5 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pembelian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection