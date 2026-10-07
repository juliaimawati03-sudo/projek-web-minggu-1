@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Produk')
@section('page-desc', 'Kelola data produk alat dan sarana pertanian')

@section('content')
<div x-data="{ modalOpen: false, editId: null }" class="space-y-4">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" placeholder="Cari nama produk..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        </div>
        <button @click="modalOpen = true; editId = null"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-4 py-2.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </button>
    </div>

    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-neutral-100 text-neutral-500 text-left">
                        <th class="px-5 py-3 font-medium">Nama Produk</th>
                        <th class="px-5 py-3 font-medium">Supplier</th>
                        <th class="px-5 py-3 font-medium">Deskripsi</th>
                        <th class="px-5 py-3 font-medium">Harga</th>
                        <th class="px-5 py-3 font-medium">Stok</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @php
                        $produk = [
                            ['id'=>1,'nama'=>'Cangkul Baja EGA','supplier'=>'CV Tani Makmur','deskripsi'=>'Cangkul baja tahan karat, gagang kayu','harga'=>85000,'stok'=>24],
                            ['id'=>2,'nama'=>'Pupuk NPK Mutiara 1kg','supplier'=>'UD Sumber Subur','deskripsi'=>'Pupuk majemuk untuk semua jenis tanaman','harga'=>35000,'stok'=>6],
                            ['id'=>3,'nama'=>'Benih Cabai Hibrida','supplier'=>'Toko Agro Jaya','deskripsi'=>'Benih cabai unggul, daya tumbuh tinggi','harga'=>40000,'stok'=>45],
                            ['id'=>4,'nama'=>'Sprayer Elektrik 16L','supplier'=>'CV Tani Makmur','deskripsi'=>'Alat semprot hama bertenaga baterai','harga'=>320000,'stok'=>3],
                        ];
                    @endphp
                    @foreach(($produk ?? $produk) as $p)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3 font-medium text-neutral-700">{{ $p['nama'] }}</td>
                        <td class="px-5 py-3 text-neutral-600">{{ $p['supplier'] }}</td>
                        <td class="px-5 py-3 text-neutral-500 max-w-xs truncate">{{ $p['deskripsi'] }}</td>
                        <td class="px-5 py-3 text-neutral-700 font-medium">Rp {{ number_format($p['harga'], 0, ',', '.') }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $p['stok'] < 10 ? 'bg-red-50 text-red-600' : 'bg-primary-xlight text-primary-dark' }}">
                                {{ $p['stok'] }} unit
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-3">
                                <button @click="modalOpen = true; editId = {{ $p['id'] }}" class="text-primary font-medium hover:text-primary-dark text-sm">Edit</button>
                                <button class="text-red-600 font-medium hover:text-red-700 text-sm">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal tambah/edit produk -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl w-full max-w-lg p-6 shadow-xl">
            <h2 class="font-semibold text-neutral-800 mb-4" x-text="editId ? 'Edit Produk' : 'Tambah Produk'"></h2>
            <form method="POST" action="{{ route('admin.produk.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Produk</label>
                    <input type="text" name="nama_produk" required placeholder="Contoh: Cangkul Baja EGA"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Supplier</label>
                    <select name="supplier_id" required class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                        <option value="1">CV Tani Makmur</option>
                        <option value="2">UD Sumber Subur</option>
                        <option value="3">Toko Agro Jaya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Harga</label>
                        <input type="number" name="harga" min="0" required placeholder="0"
                            class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1.5">Stok</label>
                        <input type="number" name="stok" min="0" required placeholder="0"
                            class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                    </div>
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