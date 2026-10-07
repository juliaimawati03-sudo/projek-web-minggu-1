@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('page-desc', 'Kelola pesanan masuk dari pelanggan')

@section('content')
<div class="space-y-6">

    {{-- 3 kartu status pesanan — datanya sama seperti versi lama
         (Menunggu Verifikasi, Sedang Diproses, Selesai Hari Ini),
         hanya tampilannya diganti ke gaya stat card admin:
         kotak putih + badge ikon hijau pojok kanan atas, bukan ikon warna-warni besar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Menunggu Verifikasi</p>
                <span class="w-9 h-9 rounded-lg bg-primary-xlight text-primary-dark flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">{{ $menungguVerifikasi ?? 0 }}</p>
            <p class="text-xs text-neutral-500 mt-1">Pesanan belum diverifikasi</p>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Sedang Diproses</p>
                <span class="w-9 h-9 rounded-lg bg-primary-xlight text-primary-dark flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582M19.418 15A7.978 7.978 0 0112 20a8 8 0 010-16c2.21 0 4.21.895 5.657 2.343M19.418 9l.582-5"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">{{ $sedangDiproses ?? 0 }}</p>
            <p class="text-xs text-neutral-500 mt-1">Pesanan sedang disiapkan</p>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5">
            <div class="flex items-center justify-between">
                <p class="text-neutral-500 text-sm">Selesai Hari Ini</p>
                <span class="w-9 h-9 rounded-lg bg-primary-xlight text-primary-dark flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-neutral-800 mt-3">{{ $selesaiHariIni ?? 0 }}</p>
            <p class="text-xs text-neutral-500 mt-1">Transaksi tuntas hari ini</p>
        </div>
    </div>

    {{-- Banner sambutan — fungsinya tetap sama (pesan selamat datang untuk kasir),
         tapi warnanya diganti dari biru ke gradasi hijau primary supaya konsisten
         dengan palette admin, bukan warna asing di luar design system --}}
    <div class="rounded-xl p-6 sm:p-8 text-white" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);">
        <h2 class="text-xl sm:text-2xl font-bold flex items-center gap-2">
            Halo, {{ auth()->user()->nama ?? 'Kasir' }}! 👋
        </h2>
        <p class="text-green-100 mt-2 max-w-xl text-sm sm:text-base">
            Ini adalah panel kasir SIMANTAP. Kamu bisa melihat pesanan yang masuk dari pelanggan dan mengelola status pesanan di sini.
        </p>
        <a href="{{ route('kasir.pesanan.index') }}"
           class="inline-flex items-center gap-2 mt-5 bg-white text-primary-dark text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-green-50 transition">
            Lihat Pesanan Masuk
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>
@endsection