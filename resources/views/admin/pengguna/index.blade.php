@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Pengguna')
@section('page-desc', 'Kelola akun admin dan kasir yang mengakses sistem')

@section('content')
<div x-data="{ 
    modalOpen: false, 
    editId: null,
    formData: { nama: '', username: '', password: '', role: 'kasir' }
}" class="space-y-4">

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="bg-primary-xlight border border-primary-light/40 text-primary-dark text-sm px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" id="search-input" placeholder="Cari nama atau username..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
        </div>
        <button @click="modalOpen = true; editId = null; formData = { nama: '', username: '', password: '', role: 'kasir' }"
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
                    @forelse($pengguna as $u)
                    <tr class="hover:bg-neutral-50 pengguna-row" 
                        data-search="{{ strtolower($u->nama . ' ' . $u->username) }}">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-xlight text-primary-dark flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($u->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-neutral-700">{{ $u->nama }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-neutral-600">{{ $u->username }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $u->role === 'admin' ? 'bg-primary-xlight text-primary-dark' : 'bg-neutral-100 text-neutral-700' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-3">
                                <button @click="modalOpen = true; editId = {{ $u->id }}; formData = { nama: '{{ $u->nama }}', username: '{{ $u->username }}', password: '', role: '{{ $u->role }}' }" 
                                    class="text-primary font-medium hover:text-primary-dark text-sm">Edit</button>
                                <button @click="if(confirm('Yakin ingin menghapus {{ $u->nama }}?')) document.getElementById('delete-form-{{ $u->id }}').submit()"
                                    class="text-red-600 font-medium hover:text-red-700 text-sm">Hapus</button>
                                <form id="delete-form-{{ $u->id }}" 
                                    method="POST" 
                                    action="{{ route('admin.pengguna.destroy', $u->id) }}" 
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-neutral-500">
                            Belum ada data pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah/Edit Pengguna --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl w-full max-w-md p-6 shadow-xl">
            <h2 class="font-semibold text-neutral-800 mb-4" x-text="editId ? 'Edit Pengguna' : 'Tambah Pengguna'"></h2>
            
            <form :action="editId ? '{{ url('admin/pengguna') }}/' + editId : '{{ route('admin.pengguna.store') }}'" 
                  method="POST" class="space-y-4">
                @csrf
                <template x-if="editId">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="formData.nama" required 
                        placeholder="Contoh: Siti Aminah"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Username</label>
                    <input type="text" name="username" x-model="formData.username" required 
                        placeholder="Contoh: siti_kasir"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Password 
                        <span x-show="editId" class="text-xs text-neutral-400">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" x-model="formData.password"
                        :required="!editId"
                        placeholder="Minimal 6 karakter"
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Role</label>
                    <select name="role" x-model="formData.role" required 
                        class="w-full px-3 py-2.5 rounded-lg border border-neutral-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-light focus:border-primary">
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="modalOpen = false" 
                        class="text-sm text-neutral-500 hover:text-neutral-700 font-medium px-4 py-2.5">Batal</button>
                    <button type="submit" 
                        class="rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium px-5 py-2.5 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Search filter
document.getElementById('search-input')?.addEventListener('input', (e) => {
    const query = e.target.value.toLowerCase();
    document.querySelectorAll('.pengguna-row').forEach(row => {
        const match = row.dataset.search.includes(query);
        row.style.display = match ? '' : 'none';
    });
});
</script>
@endsection