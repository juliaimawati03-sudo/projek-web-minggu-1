@extends('layouts.admin')

@section('title', 'Kelola Supplier')
@section('page-title', 'Supplier')
@section('page-desc', 'Kelola data supplier pemasok produk')

@section('content')
<div x-data="{ modalOpen: false }" class="space-y-4">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" placeholder="Cari nama supplier..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        </div>
        <button @click="modalOpen = true"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-4 py-2.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Supplier
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $supplier = [
                ['nama'=>'CV Tani Makmur','telp'=>'0812-3456-7890','alamat'=>'Jl. Raya Pertanian No. 12, Jombang','produk'=>18],
                ['nama'=>'UD Sumber Subur','telp'=>'0821-9988-1122','alamat'=>'Jl. Merdeka No. 45, Jombang','produk'=>9],
                ['nama'=>'Toko Agro Jaya','telp'=>'0813-2211-4455','alamat'=>'Jl. Diponegoro No. 7, Jombang','produk'=>14],
            ];
        @endphp
        @foreach(($supplier ?? $supplier) as $s)
        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-lg bg-primary-xlight text-primary-dark flex items-center justify-center font-semibold">
                    {{ strtoupper(substr($s['nama'], 0, 1)) }}
                </div>
                <div class="flex items-center gap-2">
                    <button class="text-primary hover:text-primary-dark"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828z"/></svg></button>
                    <button class="text-red-600 hover:text-red-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </div>
            </div>
            <h3 class="font-semibold text-neutral-800 mt-3">{{ $s['nama'] }}</h3>
            <p class="text-sm text-neutral-500 mt-1">{{ $s['telp'] }}</p>
            <p class="text-sm text-neutral-500 mt-1">{{ $s['alamat'] }}</p>
            <div class="mt-4 pt-3 border-t border-neutral-100 text-xs text-neutral-500">
                Memasok <span class="text-primary-dark font-medium">{{ $s['produk'] }} produk</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal tambah supplier -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl w-full max-w-lg p-6 shadow-xl">
            <h2 class="font-semibold text-neutral-800 mb-4">Tambah Supplier</h2>
            <form method="POST" action="{{ route('admin.supplier.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Supplier</label>
                    <input type="text" name="nama_supplier" required placeholder="Contoh: CV Tani Makmur"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">No. Telepon</label>
                    <input type="text" name="no_telepon" required placeholder="0812-3456-7890"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="3" required placeholder="Alamat lengkap supplier"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="modalOpen = false" class="text-sm text-neutral-500 hover:text-neutral-700 font-medium px-4 py-2.5">Batal</button>
                    <button type="submit" class="rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-5 py-2.5 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection