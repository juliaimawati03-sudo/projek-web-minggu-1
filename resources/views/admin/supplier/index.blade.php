@extends('layouts.admin')

@section('title', 'Kelola Supplier')
@section('page-title', 'Supplier')
@section('page-desc', 'Kelola data supplier pemasok produk alat pertanian')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Supplier Pemasok</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahSupplier">
                <i class="fas fa-plus mr-1"></i> Tambah Supplier Baru
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($supplier as $s)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="rounded bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                                         style="width: 48px; height: 48px; font-size: 20px; font-weight: bold;">
                                        {{ strtoupper(substr($s->nama_supplier, 0, 1)) }}
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-warning mr-1"
                                                onclick="bukaModalEditSupplier({{ $s->id }}, '{{ addslashes($s->nama_supplier) }}', '{{ addslashes($s->no_telepon) }}', '{{ addslashes(str_replace(["\r", "\n"], ' ', $s->alamat)) }}')"
                                                title="Edit Supplier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.supplier.destroy', $s->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus supplier {{ addslashes($s->nama_supplier) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Supplier">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <h5 class="font-weight-bold text-dark mb-2">{{ $s->nama_supplier }}</h5>
                                <p class="mb-1 text-muted small">
                                    <i class="fas fa-phone mr-1 text-success"></i> {{ $s->no_telepon }}
                                </p>
                                <p class="mb-3 text-muted small">
                                    <i class="fas fa-map-marker-alt mr-1 text-danger"></i> {{ $s->alamat }}
                                </p>
                            </div>
                            <div>
                                <hr class="my-2">
                                <small class="text-muted">
                                    Memasok <span class="text-primary font-weight-bold">{{ $s->products->count() }} jenis produk</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-truck fa-3x mb-2 text-gray-300"></i>
                    <p>Belum ada data supplier. Klik <strong>Tambah Supplier Baru</strong> untuk menambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal Tambah Supplier --}}
    <div class="modal fade" id="modalTambahSupplier" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.supplier.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-truck mr-1"></i> Tambah Supplier Baru</h5>
                        <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Supplier / Toko Pemasok <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" class="form-control" required placeholder="Contoh: CV Tani Makmur">
                        </div>
                        <div class="form-group">
                            <label>No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon" class="form-control" required placeholder="Contoh: 0812-3456-7890">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="3" class="form-control" required placeholder="Alamat gudang / toko supplier..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Supplier --}}
    <div class="modal fade" id="modalEditSupplier" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditSupplier" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Data Supplier</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" id="edit_nama_supplier" name="nama_supplier" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" id="edit_no_telepon" name="no_telepon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea id="edit_alamat" name="alamat" rows="3" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning font-weight-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function bukaModalEditSupplier(id, nama, telp, alamat) {
    document.getElementById('formEditSupplier').action = '/admin/supplier/' + id;
    document.getElementById('edit_nama_supplier').value = nama;
    document.getElementById('edit_no_telepon').value = telp;
    document.getElementById('edit_alamat').value = alamat;
    $('#modalEditSupplier').modal('show');
}
</script>
@endpush