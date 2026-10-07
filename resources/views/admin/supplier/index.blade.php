@extends('layouts.admin')

@section('title', 'Kelola Supplier')
@section('page-title', 'Supplier')
@section('page-desc', 'Kelola data supplier pemasok produk')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Supplier</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahSupplier">
                <i class="fas fa-plus mr-1"></i> Tambah Supplier
            </button>
        </div>
        <div class="card-body">
            <div class="row">

                @php
                    $supplier = [
                        ['nama'=>'CV Tani Makmur','telp'=>'0812-3456-7890','alamat'=>'Jl. Raya Pertanian No. 12, Jombang','produk'=>18],
                        ['nama'=>'UD Sumber Subur','telp'=>'0821-9988-1122','alamat'=>'Jl. Merdeka No. 45, Jombang','produk'=>9],
                        ['nama'=>'Toko Agro Jaya','telp'=>'0813-2211-4455','alamat'=>'Jl. Diponegoro No. 7, Jombang','produk'=>14],
                    ];
                @endphp

                @foreach(($supplier ?? []) as $s)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="rounded bg-primary text-white d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px; font-size: 20px; font-weight: bold;">
                                    {{ strtoupper(substr($s['nama'], 0, 1)) }}
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <h5 class="font-weight-bold">{{ $s['nama'] }}</h5>
                            <p class="mb-1 text-muted small">
                                <i class="fas fa-phone mr-1"></i> {{ $s['telp'] }}
                            </p>
                            <p class="mb-3 text-muted small">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $s['alamat'] }}
                            </p>
                            <hr class="my-2">
                            <small class="text-muted">
                                Memasok <span class="text-primary font-weight-bold">{{ $s['produk'] }} produk</span>
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- Modal Tambah Supplier --}}
    <div class="modal fade" id="modalTambahSupplier" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.supplier.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Supplier</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Supplier *</label>
                            <input type="text" name="nama_supplier" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon *</label>
                            <input type="text" name="no_telepon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat *</label>
                            <textarea name="alamat" rows="3" class="form-control" required></textarea>
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