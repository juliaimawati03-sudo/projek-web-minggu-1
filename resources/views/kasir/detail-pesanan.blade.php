@extends('layouts.kasir')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-desc', 'Verifikasi & kelola status pesanan')

@section('content')

    <a href="{{ url('/kasir/pesanan') }}" class="btn btn-sm btn-secondary mb-3">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Pesanan
    </a>

    <div class="row">

        {{-- Kolom Kiri: Detail --}}
        <div class="col-lg-8 mb-4">

            <div class="card shadow mb-4">
                <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <div class="small text-white-50 mb-1">Nomor Pesanan</div>
                            <div class="font-weight-bold" style="font-family: monospace; font-size: 20px;">ORD-20260924-0003</div>
                        </div>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
                        </span>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Data Pelanggan --}}
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-user text-success mr-1"></i> Data Pelanggan
                    </h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Nama Lengkap</div>
                            <div class="font-weight-bold">Budi Santoso</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Nomor HP</div>
                            <div class="font-weight-bold">081234567890</div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="text-muted small mb-1">Alamat Lengkap</div>
                            <div class="font-weight-bold">Jl. Pertanian No. 123, RT 01/RW 02, Desa Sukamaju</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small mb-1">Catatan</div>
                            <div class="font-italic">Tolong dikirim pagi hari</div>
                        </div>
                    </div>

                    <hr>

                    {{-- Produk Dipesan --}}
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-shopping-cart text-success mr-1"></i> Produk Dipesan
                    </h6>

                    <div class="d-flex align-items-center mb-2 p-3 bg-light rounded">
                        <div class="rounded bg-success text-white d-flex align-items-center justify-content-center mr-3"
                             style="width: 44px; height: 44px;">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="font-weight-bold">Pacul</div>
                            <div class="text-muted small">Rp75.000 × 2</div>
                        </div>
                        <div class="font-weight-bold">Rp150.000</div>
                    </div>

                    <div class="d-flex align-items-center mb-2 p-3 bg-light rounded">
                        <div class="rounded bg-success text-white d-flex align-items-center justify-content-center mr-3"
                             style="width: 44px; height: 44px;">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="font-weight-bold">Arit</div>
                            <div class="text-muted small">Rp45.000 × 1</div>
                        </div>
                        <div class="font-weight-bold">Rp45.000</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
                        <span class="font-weight-bold">Total</span>
                        <span class="h4 mb-0 font-weight-bold text-success">Rp195.000</span>
                    </div>

                    <hr>

                    {{-- Bukti Transfer --}}
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-camera text-success mr-1"></i> Bukti Transfer
                    </h6>
                    <div class="bg-light rounded p-3 border">
                        <img src="https://via.placeholder.com/800x600/22c55e/ffffff?text=Bukti+Transfer+BRI"
                             alt="Bukti Transfer"
                             class="img-fluid rounded mb-2">
                        <div class="text-center text-muted small">
                            <i class="fas fa-paperclip mr-1"></i> bukti-transfer-budi.jpg (245 KB)
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi --}}
        <div class="col-lg-4 mb-4">

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h6 class="font-weight-bold text-dark mb-3">Aksi</h6>

                    <button onclick="verifikasiPesanan()" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-check mr-1"></i> Verifikasi Pembayaran
                    </button>

                    <button onclick="tolakPesanan()" class="btn btn-outline-danger btn-block">
                        <i class="fas fa-times mr-1"></i> Tolak Bukti Transfer
                    </button>

                    <div class="alert alert-info small mt-3 mb-0">
                        <i class="fas fa-info-circle mr-1"></i>
                        <strong>Verifikasi</strong> akan mengubah status pesanan menjadi "Diproses".
                        <strong>Tolak</strong> akan meminta pelanggan mengirim ulang bukti transfer.
                    </div>
                </div>
            </div>

            <div class="card shadow-sm" style="background: #F0FDF4; border: 1px solid #BBF7D0;">
                <div class="card-body">
                    <div class="font-weight-bold text-success mb-1">Perlu segera diverifikasi</div>
                    <p class="small text-muted mb-0">
                        Pesanan sudah menunggu sejak 24 Sep 2026, 10:30. Periksa bukti transfer sebelum menekan verifikasi.
                    </p>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
function verifikasiPesanan() {
    if (confirm('Verifikasi pembayaran untuk pesanan ini?\n\nStatus akan berubah menjadi "Diproses".')) {
        alert('Pembayaran berhasil diverifikasi!');
    }
}

function tolakPesanan() {
    if (confirm('Tolak bukti transfer pesanan ini?')) {
        alert('Bukti transfer ditolak.');
    }
}
</script>
@endpush