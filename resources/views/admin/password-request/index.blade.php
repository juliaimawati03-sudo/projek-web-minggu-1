@extends('layouts.admin')

@section('title', 'Permintaan Reset Password')
@section('page-title', 'Permintaan Reset Password')
@section('page-desc', 'Kelola permintaan reset password dari pengguna')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Permintaan
                @if($pendingCount > 0)
                    <span class="badge badge-danger ml-2">{{ $pendingCount }} pending</span>
                @endif
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>No. HP</th>
                            <th>Pesan</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $i => $r)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="font-weight-bold">{{ $r->username }}</td>
                            <td>{{ $r->nama ?? '-' }}</td>
                            <td>{{ $r->no_telepon ?? '-' }}</td>
                            <td class="small text-muted">{{ $r->pesan ?? '-' }}</td>
                            <td class="small">{{ $r->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @if($r->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($r->status === 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($r->status === 'pending')
                                    <button class="btn btn-sm btn-success"
                                            onclick="resetPassword({{ $r->id }}, '{{ $r->username }}')">
                                        <i class="fas fa-key"></i> Reset
                                    </button>
                                    <form action="{{ route('admin.password-request.reject', $r->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Tolak permintaan ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">
                                        Diproses oleh {{ $r->resolver->nama ?? '-' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada permintaan reset password.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Reset Password --}}
    <div class="modal fade" id="modalReset" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formReset" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Reset Password User</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-1"></i>
                            Reset password untuk: <strong id="usernameTarget">-</strong>
                        </div>
                        <div class="form-group">
                            <label>Password Baru <span class="text-danger">*</span></label>
                            <input type="text" name="new_password" class="form-control" required minlength="6"
                                   placeholder="Minimal 6 karakter" value="password123">
                            <small class="text-muted">Catat password ini dan beritahu user via WhatsApp.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-key mr-1"></i> Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function resetPassword(id, username) {
    document.getElementById('formReset').action = '/admin/password-request/' + id + '/reset';
    document.getElementById('usernameTarget').textContent = username;
    $('#modalReset').modal('show');
}
</script>
@endpush