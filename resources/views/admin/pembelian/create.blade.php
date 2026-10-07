@extends('layouts.admin')

@section('title', 'Pembelian Supplier')
@section('page-title', 'Pembelian ke Supplier')
@section('page-desc', 'Catat pembelian barang dari supplier (otomatis tercatat sebagai pengeluaran)')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-shopping-cart mr-1"></i> Form Pembelian
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pembelian.store') }}" method="POST">
                        @csrf

                        {{-- ===== DATA SUPPLIER (MANUAL) ===== --}}
                        <h6 class="font-weight-bold text-secondary mb-3 border-bottom pb-2">
                            <i class="fas fa-truck mr-1"></i> Data Supplier
                        </h6>

                        <div class="form-group">
                            <label>Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" class="form-control" required
                                   placeholder="Contoh: CV Tani Makmur"
                                   value="{{ old('nama_supplier') }}">
                            <small class="form-text text-muted">Ketik nama supplier secara manual.</small>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>No. Telepon Supplier</label>
                                <input type="text" name="no_telepon" class="form-control"
                                       placeholder="Contoh: 0812-3456-7890"
                                       value="{{ old('no_telepon') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Alamat Supplier</label>
                                <input type="text" name="alamat" class="form-control"
                                       placeholder="Contoh: Jl. Raya Pertanian No. 12"
                                       value="{{ old('alamat') }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ===== DETAIL PEMBELIAN ===== --}}
                        <h6 class="font-weight-bold text-secondary mb-3 border-bottom pb-2">
                            <i class="fas fa-boxes mr-1"></i> Detail Pembelian
                        </h6>

                        <div class="form-group">
                            <label>Tanggal Pembelian <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" required
                                   value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label>Total Nominal (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="nominal" class="form-control" required
                                   min="0" placeholder="Contoh: 850000"
                                   value="{{ old('nominal') }}">
                            <small class="form-text text-muted">
                                Nominal ini akan otomatis tercatat sebagai pengeluaran.
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" rows="3" class="form-control" required
                                      placeholder="Contoh: Pembelian stok cangkul 10 unit">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="alert alert-info d-flex align-items-start">
                            <i class="fas fa-info-circle mr-2 mt-1"></i>
                            <div class="small">
                                <strong>Otomatis tercatat sebagai pengeluaran</strong><br>
                                Setiap pembelian yang dicatat akan langsung masuk ke Laporan Keuangan sebagai pengeluaran (Kredit).
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i> Simpan Pembelian
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection