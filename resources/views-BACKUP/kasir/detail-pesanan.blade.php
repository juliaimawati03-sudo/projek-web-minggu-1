@extends('layouts.kasir')

@section('title', 'Detail Pesanan - SIMANTAP')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', 'Verifikasi & kelola status pesanan')

@section('content')

    {{-- Tombol Kembali — hover warna disamakan ke primary --}}
    <a href="{{ url('/kasir/pesanan') }}"
       class="inline-flex items-center gap-2 text-sm text-neutral-600 hover:text-primary mb-6 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Pesanan
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Detail Pesanan --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Info Pesanan — card disamakan ke gaya admin (rounded-xl, border-neutral-200,
                 tanpa shadow berat), header gradient biru→indigo diganti ke gradasi primary --}}
            <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
                <div class="px-6 py-4 text-white" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <div class="text-xs text-green-100 mb-1">Nomor Pesanan</div>
                            <div class="font-mono font-bold text-xl">ORD-20260924-0003</div>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-amber-400 text-amber-900 inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Menunggu Verifikasi
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">

                    {{-- Data Pelanggan --}}
                    <div>
                        <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-dark" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Data Pelanggan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-neutral-500 mb-0.5">Nama Lengkap</div>
                                <div class="font-semibold text-neutral-800">Budi Santoso</div>
                            </div>
                            <div>
                                <div class="text-neutral-500 mb-0.5">Nomor HP</div>
                                <div class="font-semibold text-neutral-800">081234567890</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-neutral-500 mb-0.5">Alamat Lengkap</div>
                                <div class="font-semibold text-neutral-800">Jl. Pertanian No. 123, RT 01/RW 02, Desa Sukamaju</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-neutral-500 mb-0.5">Catatan</div>
                                <div class="text-neutral-700 italic">Tolong dikirim pagi hari</div>
                            </div>
                        </div>
                    </div>

                    {{-- Produk Dipesan --}}
                    <div class="pt-4 border-t border-neutral-100">
                        <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-dark" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 4a1 1 0 102 0 1 1 0 00-2 0zm10 0a1 1 0 102 0 1 1 0 00-2 0z"/></svg>
                            Produk Dipesan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 bg-neutral-50 rounded-lg p-3">
                                <div class="w-11 h-11 bg-primary-xlight rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-primary-dark" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-sm text-neutral-800">Pacul</div>
                                    <div class="text-xs text-neutral-500">Rp75.000 × 2</div>
                                </div>
                                <div class="font-bold text-neutral-800">Rp150.000</div>
                            </div>
                            <div class="flex items-center gap-3 bg-neutral-50 rounded-lg p-3">
                                <div class="w-11 h-11 bg-primary-xlight rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-primary-dark" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-sm text-neutral-800">Arit</div>
                                    <div class="text-xs text-neutral-500">Rp45.000 × 1</div>
                                </div>
                                <div class="font-bold text-neutral-800">Rp45.000</div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-neutral-100 flex justify-between items-center">
                            <span class="font-semibold text-neutral-700">Total</span>
                            <span class="font-extrabold text-2xl text-primary-dark">Rp195.000</span>
                        </div>
                    </div>

                    {{-- Bukti Transfer --}}
                    <div class="pt-4 border-t border-neutral-100">
                        <h3 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-dark" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 17a4 4 0 100-8 4 4 0 000 8z"/></svg>
                            Bukti Transfer
                        </h3>
                        <div class="bg-neutral-50 rounded-xl p-3 border border-neutral-200">
                            <div class="aspect-video bg-white rounded-lg flex items-center justify-center overflow-hidden">
                                <img src="https://via.placeholder.com/800x600/22c55e/ffffff?text=Bukti+Transfer+BRI"
                                     alt="Bukti Transfer"
                                     class="max-w-full max-h-full object-contain">
                            </div>
                            <div class="text-xs text-neutral-500 text-center mt-3 flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                bukti-transfer-budi.jpg (245 KB)
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Aksi Verifikasi — warna tombol sudah hijau sebelumnya (match primary),
                 cuma diganti ke token 'primary' biar konsisten dengan sistem warna admin --}}
            <div class="bg-white rounded-xl border border-neutral-200 p-6">
                <h3 class="font-bold text-neutral-800 mb-4">Aksi</h3>

                <div class="space-y-3">
                    <button onclick="verifikasiPesanan()"
                            class="w-full px-4 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Verifikasi Pembayaran
                    </button>
                    <button onclick="tolakPesanan()"
                            class="w-full px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak Bukti Transfer
                    </button>
                </div>

                <div class="mt-4 pt-4 border-t border-neutral-100">
                    <p class="text-xs text-neutral-500 leading-relaxed flex gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-primary-dark" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span><strong>Verifikasi</strong> akan mengubah status pesanan menjadi "Diproses" dan stok produk otomatis berkurang sesuai jumlah pesanan. <strong>Tolak</strong> akan meminta pelanggan mengirim ulang bukti transfer yang valid.</span>
                    </p>
                </div>
            </div>

            {{-- Ringkasan status — kartu tambahan bergaya admin untuk konteks tambahan --}}
            <div class="bg-primary-pale rounded-xl border border-primary-light/30 p-5">
                <p class="text-primary-dark text-sm font-semibold mb-1">Perlu segera diverifikasi</p>
                <p class="text-xs text-neutral-600 leading-relaxed">Pesanan sudah menunggu sejak 24 Sep 2026, 10:30. Periksa bukti transfer sebelum menekan verifikasi.</p>
            </div>
        </div>
    </div>

    <script>
    // ============ Aksi Verifikasi & Tolak ============
    // Logic sama persis seperti sebelumnya, hanya pesan alert disesuaikan (tanpa emoji)
    function verifikasiPesanan() {
        if (confirm('Verifikasi pembayaran untuk pesanan ini?\n\nStatus akan berubah menjadi "Diproses" dan stok produk otomatis berkurang.')) {
            alert('Pembayaran berhasil diverifikasi!\n\n(BACKEND NANTI: Update status & kurangi stok di database)');
            // Nanti: fetch ke backend, lalu redirect ke /kasir/pesanan
        }
    }

    function tolakPesanan() {
        if (confirm('Tolak bukti transfer pesanan ini?\n\nPelanggan akan diminta mengirim ulang bukti pembayaran yang valid.')) {
            alert('Bukti transfer ditolak.\n\n(BACKEND NANTI: Kirim notifikasi ke pelanggan)');
            // Nanti: fetch ke backend
        }
    }

    // ============ Cek Akses ============
    document.addEventListener('DOMContentLoaded', () => {
        const user = JSON.parse(localStorage.getItem('simantap_user') || 'null');
        if (!user || (user.role !== 'kasir' && user.role !== 'admin')) {
            window.location.href = '/login';
        }
    });
    </script>

@endsection