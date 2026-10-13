@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Produk')
@section('page-desc', 'Kelola data produk alat dan sarana pertanian')

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
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahProduk">
                <i class="fas fa-plus mr-1"></i> Tambah Produk
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="80">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Supplier</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $p)
                        <tr>
                            <td>
                                <img src="{{ $p->gambarUrl() }}" alt="{{ $p->nama_produk }}"
                                     class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td class="font-weight-bold">{{ $p->nama_produk }}</td>
                            <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                            <td class="text-muted small">{{ $p->deskripsi }}</td>
                            <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($p->stok < 10)
                                    <span class="badge badge-danger">{{ $p->stok }} unit</span>
                                @else
                                    <span class="badge badge-success">{{ $p->stok }} unit</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus {{ $p->nama_produk }}?')">
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
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada produk. Klik "Tambah Produk" untuk menambah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Produk --}}
    <div class="modal fade" id="modalTambahProduk" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Produk</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Produk *</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Supplier *</label>
                            <select name="supplier_id" class="form-control" required>
                                <option value="">— Pilih Supplier —</option>
                                @foreach($supplier as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" name="gambar" class="form-control-file" accept="image/*">
                            <small class="text-muted">JPG/PNG/WEBP, maks 2 MB</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga *</label>
                                <input type="number" name="harga" class="form-control" required min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stok *</label>
                                <input type="number" name="stok" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection