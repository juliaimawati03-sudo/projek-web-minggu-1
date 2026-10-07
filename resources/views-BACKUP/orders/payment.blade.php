@extends('layouts.app')

@section('title', 'Instruksi Pembayaran - SIMANTAP')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-6 text-white text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-3">
                <span class="text-3xl">💳</span>
            </div>
            <h1 class="text-2xl font-bold mb-1">Instruksi Pembayaran</h1>
            <p class="text-green-50 text-sm">No. Pesanan: <span id="no-pesanan" class="font-mono font-bold">-</span></p>
        </div>

        <div class="p-6 space-y-6">

            {{-- Info Metode --}}
            <div>
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>📱</span> Transfer ke Metode Pembayaran
                </h2>

                <div id="box-metode" class="bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-2xl p-6 space-y-4">

                    {{-- Logo + Nama --}}
                    <div class="flex items-center gap-3 mb-2">
                        <div id="metode-logo" class="w-16 h-16 rounded-xl bg-white flex items-center justify-center shadow-sm overflow-hidden p-1.5 border border-white">
                            <img id="metode-img" src="" alt="" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <div class="text-sm text-orange-700 font-medium">Metode Pembayaran</div>
                            <div id="metode-name" class="text-xl font-bold text-orange-900">-</div>
                        </div>
                    </div>

                    {{-- Detail Nomor --}}
                    <div class="space-y-3 pt-3 border-t border-orange-200">
                        <div>
                            <div class="text-xs text-orange-700 font-medium mb-1">Nomor Tujuan</div>
                            <div class="flex items-center gap-3">
                                <span id="metode-nomor" class="font-mono font-bold text-lg text-orange-900">-</span>
                                <button onclick="copyNomor()" class="text-xs px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition flex items-center gap-1">
                                    📋 Salin
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-orange-700 font-medium mb-1">Atas Nama</div>
                            <div class="font-bold text-orange-900">Toko SIMANTAP</div>
                        </div>
                        <div>
                            <div class="text-xs text-orange-700 font-medium mb-1">Jumlah Transfer</div>
                            <div id="metode-total" class="font-extrabold text-2xl text-green-600">Rp0</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex gap-3">
                    <span class="text-yellow-500 text-xl shrink-0">⏰</span>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold mb-1">Selesaikan dalam 1×24 jam</p>
                        <p>Setelah transfer, upload bukti pembayaran di bawah ini. Pesanan akan diproses setelah pembayaran diverifikasi.</p>
                    </div>
                </div>
            </div>

            {{-- Upload Bukti Transfer --}}
            <div class="pt-4 border-t border-neutral-100">
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>📤</span> Upload Bukti Transfer
                </h2>

                <form id="form-upload" class="space-y-4">

                    {{-- Drop zone / file input --}}
                    <div id="drop-zone"
                         class="border-2 border-dashed border-neutral-300 hover:border-green-500 rounded-2xl p-8 text-center cursor-pointer transition">
                        <input type="file" id="file-input" accept="image/jpeg,image/png,application/pdf" class="hidden">
                        <div id="drop-content">
                            <div class="text-5xl mb-3">📎</div>
                            <p class="font-semibold text-neutral-700 mb-1">Klik untuk pilih file</p>
                            <p class="text-sm text-neutral-500">Format: JPG, PNG, PDF</p>
                            <p class="text-xs text-neutral-400 mt-1">Maksimal 2 MB</p>
                        </div>
                        <div id="preview-content" class="hidden">
                            <img id="preview-img" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg mb-3">
                            <p id="preview-name" class="text-sm text-neutral-600 font-medium break-all"></p>
                            <button type="button" onclick="resetFile(event)"
                                    class="mt-3 text-sm text-red-500 hover:text-red-700 underline">
                                Ganti File
                            </button>
                        </div>
                    </div>

                    <p id="error-file" class="hidden text-sm text-red-500">⚠️ Silakan upload bukti transfer terlebih dahulu</p>

                    {{-- Info box --}}
                    <div class="bg-neutral-50 border border-neutral-200 rounded-xl p-4 flex gap-3">
                        <span class="text-neutral-400 text-xl shrink-0">ℹ️</span>
                        <div class="text-sm text-neutral-600">
                            <p>Pastikan bukti transfer terlihat jelas — nominal, tanggal, dan status "Berhasil".</p>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3 pt-2">
                        <a href="{{ url('/checkout') }}"
                           class="flex-1 text-center px-4 py-3 border border-neutral-200 hover:border-neutral-300 text-neutral-700 font-semibold rounded-xl transition">
                            Kembali
                        </a>
                        <button type="submit" id="btn-upload"
                                class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                            <span>✓</span> Kirim Bukti Transfer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ============================================
// KONFIGURASI METODE PEMBAYARAN
// ============================================
const METODE_CONFIG = {
    'ShopeePay': {
        label: 'ShopeePay',
        nomor: '0878-5956-3173',
        logo: '{{ asset("images/shopeepay.png") }}',
    },
    'SeaBank': {
        label: 'SeaBank',
        nomor: '901229078240',
        logo: '{{ asset("images/seabank.png") }}',
    },
};

document.addEventListener('DOMContentLoaded', () => {
    loadOrderData();
    setupFileUpload();
});

function rupiah(n) {
    return 'Rp' + Number(n).toLocaleString('id-ID');
}

function loadOrderData() {
    const order = JSON.parse(localStorage.getItem('simantap_last_order') || 'null');

    if (!order || !order.payment_method) {
        alert('Data pesanan tidak ditemukan. Silakan isi form pemesanan terlebih dahulu.');
        window.location.href = "{{ url('/checkout') }}";
        return;
    }

    const metode = order.payment_method;
    const config = METODE_CONFIG[metode];

    if (!config) {
        alert('Metode pembayaran tidak dikenal: ' + metode);
        window.location.href = "{{ url('/checkout') }}";
        return;
    }

    // Isi data
    document.getElementById('no-pesanan').textContent = order.nomor;
    document.getElementById('metode-name').textContent = config.label;
    document.getElementById('metode-nomor').textContent = config.nomor;
    document.getElementById('metode-total').textContent = rupiah(order.total);

    // Logo
    const img = document.getElementById('metode-img');
    img.src = config.logo;
    img.alt = config.label;
}

function copyNomor() {
    const nomor = document.getElementById('metode-nomor').textContent.replace(/\D/g, '');
    navigator.clipboard.writeText(nomor).then(() => {
        alert('✅ Nomor berhasil disalin: ' + nomor);
    }).catch(() => {
        alert('Nomor: ' + nomor);
    });
}

let selectedFile = null;

function setupFileUpload() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');

    dropZone.addEventListener('click', (e) => {
        if (e.target.tagName !== 'BUTTON') {
            fileInput.click();
        }
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    // Drag & drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-green-500', 'bg-green-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-green-500', 'bg-green-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        if (e.dataTransfer.files.length > 0) {
            handleFile(e.dataTransfer.files[0]);
        }
    });

    // Submit form
    document.getElementById('form-upload').addEventListener('submit', handleUpload);
}

function handleFile(file) {
    const maxSize = 2 * 1024 * 1024; // 2 MB
    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

    if (!allowedTypes.includes(file.type)) {
        alert('❌ Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
        return;
    }

    if (file.size > maxSize) {
        alert('❌ Ukuran file terlalu besar. Maksimal 2 MB.');
        return;
    }

    selectedFile = file;

    const dropContent = document.getElementById('drop-content');
    const previewContent = document.getElementById('preview-content');
    const previewImg = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-name');

    dropContent.classList.add('hidden');
    previewContent.classList.remove('hidden');

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        previewImg.classList.add('hidden');
    }

    previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
    document.getElementById('error-file').classList.add('hidden');
}

function resetFile(e) {
    e.stopPropagation();
    selectedFile = null;
    document.getElementById('file-input').value = '';
    document.getElementById('drop-content').classList.remove('hidden');
    document.getElementById('preview-content').classList.add('hidden');
}

function handleUpload(e) {
    e.preventDefault();

    if (!selectedFile) {
        document.getElementById('error-file').classList.remove('hidden');
        document.getElementById('drop-zone').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // Simulasi upload berhasil
    const order = JSON.parse(localStorage.getItem('simantap_last_order') || 'null');
    if (order) {
        order.payment_proof_name = selectedFile.name;
        order.payment_status = 'Menunggu Verifikasi';
        order.uploaded_at = new Date().toISOString();
        localStorage.setItem('simantap_last_order', JSON.stringify(order));
    }

    // Hapus cart — pesanan sudah dibuat
    localStorage.removeItem('simantap_cart');

    // Tampilkan loading
    const btn = document.getElementById('btn-upload');
    btn.disabled = true;
    btn.innerHTML = '<span>⏳</span> Mengirim...';

    // Redirect ke halaman sukses
    setTimeout(() => {
        window.location.href = "{{ url('/orders/success') }}";
    }, 800);
}
</script>
@endpush