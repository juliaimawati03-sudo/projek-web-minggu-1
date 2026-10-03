@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Pengguna')
@section('page-desc', 'Kelola akun admin dan kasir yang mengakses sistem')

@section('content')
<div x-data="{ modalOpen: false, editId: null }" class="space-y-4">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" placeholder="Cari nama atau username..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        </div>
        <button @click="modalOpen = true; editId = null"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-4 py-2.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </button>
    </div>

    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-neutral-100 text-neutral-500 text-left">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Username</th>
                        <th class="px-5 py-3 font-medium">Role</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @php
                        $pengguna = [
                            ['id'=>1,'nama'=>'Admin Utama','username'=>'admin01','role'=>'admin'],
                            ['id'=>2,'nama'=>'Siti Aminah','username'=>'siti_kasir','role'=>'kasir'],
                            ['id'=>3,'nama'=>'Budi Santoso','username'=>'budi_kasir','role'=>'kasir'],
                        ];
                    @endphp
                    @foreach(($pengguna ?? $pengguna) as $u)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-xlight text-primary-dark flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($u['nama'], 0, 1)) }}
                                </div>
                                <span class="font-medium text-neutral-700">{{ $u['nama'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-neutral-600">{{ $u['username'] }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $u['role'] === 'admin' ? 'bg-primary-xlight text-primary-dark' : 'bg-neutral-100 text-neutral-700' }}">
                                {{ ucfirst($u['role']) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-3">
                                <button @click="modalOpen = true; editId = {{ $u['id'] }}" class="text-primary font-medium hover:text-primary-dark text-sm">Edit</button>
                                <button class="text-red-600 font-medium hover:text-red-700 text-sm">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal tambah/edit pengguna -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl w-full max-w-md p-6 shadow-xl">
            <h2 class="font-semibold text-neutral-800 mb-4" x-text="editId ? 'Edit Pengguna' : 'Tambah Pengguna'"></h2>
            <form method="POST" action="{{ route('admin.pengguna.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Contoh: Siti Aminah"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Username</label>
                    <input type="text" name="username" required placeholder="Contoh: siti_kasir"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Role</label>
                    <select name="role" required class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
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