@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Pengguna')
@section('page-desc', 'Kelola akun admin dan kasir yang mengakses sistem')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahPengguna">
                <i class="fas fa-plus mr-1"></i> Tambah Pengguna
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengguna as $u)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2"
                                         style="width: 32px; height: 32px; font-size: 14px;">
                                        {{ strtoupper(substr($u->nama, 0, 1)) }}
                                    </div>
                                    <span class="font-weight-bold">{{ $u->nama }}</span>
                                </div>
                            </td>
                            <td>{{ $u->username }}</td>
                            <td>
                                @if($u->role === 'admin')
                                    <span class="badge badge-primary">Admin</span>
                                @else
                                    <span class="badge badge-secondary">Kasir</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                        onclick="editPengguna({{ $u->id }}, '{{ $u->nama }}', '{{ $u->username }}', '{{ $u->role }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus {{ $u->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Pengguna --}}
    <div class="modal fade" id="modalTambahPengguna" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button class="close" type="button" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required placeholder="Contoh: Siti Aminah">
                        </div>

                        <div class="form-group">
                            <label>Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" required placeholder="Contoh: siti_kasir">
                        </div>

                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                        </div>

                        <div class="form-group mb-0">
                            <label>Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="kasir">Kasir</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Pengguna --}}
    <div class="modal fade" id="modalEditPengguna" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditPengguna" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pengguna</h5>
                        <button class="close" type="button" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="editNama" name="nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Username <span class="text-danger">*</span></label>
                            <input type="text" id="editUsername" name="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" class="form-control" minlength="6" placeholder="••••••••">
                        </div>

                        <div class="form-group mb-0">
                            <label>Role <span class="text-danger">*</span></label>
                            <select id="editRole" name="role" class="form-control" required>
                                <option value="kasir">Kasir</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function editPengguna(id, nama, username, role) {
    document.getElementById('formEditPengguna').action = '/admin/pengguna/' + id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editUsername').value = username;
    document.getElementById('editRole').value = role;
    $('#modalEditPengguna').modal('show');
}
</script>
@endpush