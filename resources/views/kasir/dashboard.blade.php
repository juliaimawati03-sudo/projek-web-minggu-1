@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('page-desc', 'Kelola pesanan masuk dari pelanggan')

@section('content')

    {{-- 3 Kartu Status --}}
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Verifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $menungguVerifikasi ?? 0 }}
                            </div>
                            <div class="text-xs text-muted mt-1">Pesanan belum diverifikasi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Sedang Diproses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $sedangDiproses ?? 0 }}
                            </div>
                            <div class="text-xs text-muted mt-1">Pesanan sedang disiapkan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $selesaiHariIni ?? 0 }}
                            </div>
                            <div class="text-xs text-muted mt-1">Transaksi tuntas hari ini</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Banner Sambutan (hijau, konsisten tema SIMANTAP) --}}
    <div class="card shadow mb-4" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%); border: none;">
        <div class="card-body text-white p-4">
            <h5 class="font-weight-bold mb-2">
                <i class="fas fa-hand-sparkles mr-1"></i>
                Halo, {{ auth()->user()->nama ?? 'Kasir' }}!
            </h5>
            <p class="mb-3 text-white-50">
                Ini adalah panel kasir SIMANTAP. Kamu bisa melihat pesanan yang masuk dari pelanggan dan mengelola status pesanan di sini.
            </p>
            <a href="{{ route('kasir.pesanan.index') }}"
               class="btn btn-light btn-sm text-success font-weight-bold">
                Lihat Pesanan Masuk <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

@endsection