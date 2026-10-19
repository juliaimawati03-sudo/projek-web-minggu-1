<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $kasir1 = User::where('username', 'kasir')->first();
        $kasir2 = User::where('username', 'kasir2')->first();
        $pelanggan1 = User::where('username', 'pelanggan')->first();
        $pelanggan2 = User::where('username', 'hadi')->first();
        $pelanggan3 = User::where('username', 'ahmad')->first();
        $pelanggan4 = User::where('username', 'rina')->first();
        $pelanggan5 = User::where('username', 'dedi')->first();

        $produkCangkul = Produk::where('nama_produk', 'like', '%Cangkul%')->first();
        $produkArit = Produk::where('nama_produk', 'like', '%Arit%')->first();
        $produkSprayer = Produk::where('nama_produk', 'like', '%Sprayer%')->first();
        $produkGaru = Produk::where('nama_produk', 'like', '%Garu%')->first();
        $produkMulsa = Produk::where('nama_produk', 'like', '%Mulsa%')->first();
        $produkSelang = Produk::where('nama_produk', 'like', '%Selang%')->first();
        $produkBendo = Produk::where('nama_produk', 'like', '%Bendo%')->first();

        // Daftar Pesanan & Transaksi Realistis
        $daftarTransaksi = [
            // 1. Menunggu Verifikasi (Kasir bisa langsung test verifikasi)
            [
                'kode_transaksi' => 'ORD-20261019-0001',
                'pelanggan_id' => $pelanggan1?->id,
                'kasir_id' => null,
                'nama_pelanggan' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Pertanian No. 123, RT 01/RW 02, Desa Sukamaju, Jombang',
                'latitude' => '-7.550123',
                'longitude' => '112.235678',
                'metode_pembayaran' => 'Transfer Bank BRI',
                'bukti_transfer' => 'bukti-transfer-budi.jpg',
                'ongkir' => 10000,
                'tanggal_transaksi' => Carbon::now()->subHours(2),
                'total_harga' => 225000,
                'nominal_bayar' => 225000,
                'kembalian' => 0,
                'status' => 'menunggu_verifikasi',
                'catatan' => 'Tolong dikirim pagi hari ke gubuk sawah dekat balai desa.',
                'items' => [
                    ['produk' => $produkCangkul, 'jumlah' => 2],
                    ['produk' => $produkArit, 'jumlah' => 1],
                ],
            ],
            // 2. Menunggu Verifikasi
            [
                'kode_transaksi' => 'ORD-20261019-0002',
                'pelanggan_id' => $pelanggan4?->id,
                'kasir_id' => null,
                'nama_pelanggan' => 'Siti Nurhaliza',
                'no_hp' => '082345678901',
                'alamat' => 'Dusun Ploso RT 03/RW 01, Kec. Ploso, Jombang',
                'latitude' => '-7.452100',
                'longitude' => '112.231200',
                'metode_pembayaran' => 'Transfer Bank BCA',
                'bukti_transfer' => 'bukti-transfer-siti.jpg',
                'ongkir' => 15000,
                'tanggal_transaksi' => Carbon::now()->subHours(4),
                'total_harga' => 335000,
                'nominal_bayar' => 335000,
                'kembalian' => 0,
                'status' => 'menunggu_verifikasi',
                'catatan' => 'Pastikan baterai sprayer sudah terisi.',
                'items' => [
                    ['produk' => $produkSprayer, 'jumlah' => 1],
                ],
            ],
            // 3. Menunggu Verifikasi
            [
                'kode_transaksi' => 'ORD-20261019-0003',
                'pelanggan_id' => $pelanggan3?->id,
                'kasir_id' => null,
                'nama_pelanggan' => 'Ahmad Fauzi',
                'no_hp' => '083456789012',
                'alamat' => 'Desa Sambong Permai Blok B-12, Jombang',
                'latitude' => '-7.548000',
                'longitude' => '112.215000',
                'metode_pembayaran' => 'ShopeePay',
                'bukti_transfer' => 'bukti-shopeepay-ahmad.jpg',
                'ongkir' => 0,
                'tanggal_transaksi' => Carbon::now()->subHours(6),
                'total_harga' => 150000,
                'nominal_bayar' => 150000,
                'kembalian' => 0,
                'status' => 'menunggu_verifikasi',
                'catatan' => 'Ambil sendiri di toko jam 4 sore.',
                'items' => [
                    ['produk' => $produkGaru, 'jumlah' => 1],
                    ['produk' => $produkCangkul, 'jumlah' => 1],
                ],
            ],
            // 4. Diproses
            [
                'kode_transaksi' => 'ORD-20261018-0004',
                'pelanggan_id' => $pelanggan4?->id,
                'kasir_id' => $kasir1?->id,
                'nama_pelanggan' => 'Rina Wati',
                'no_hp' => '084567890123',
                'alamat' => 'Jl. Wahid Hasyim No. 88, Jombang',
                'latitude' => '-7.555000',
                'longitude' => '112.230000',
                'metode_pembayaran' => 'Transfer Bank BRI',
                'bukti_transfer' => 'bukti-rina.jpg',
                'ongkir' => 10000,
                'tanggal_transaksi' => Carbon::now()->subDay(),
                'total_harga' => 290000,
                'nominal_bayar' => 290000,
                'kembalian' => 0,
                'status' => 'diproses',
                'catatan' => 'Sedang dikemas di gudang toko.',
                'items' => [
                    ['produk' => $produkMulsa, 'jumlah' => 1],
                ],
            ],
            // 5. Dikirim
            [
                'kode_transaksi' => 'ORD-20261018-0005',
                'pelanggan_id' => $pelanggan5?->id,
                'kasir_id' => $kasir1?->id,
                'nama_pelanggan' => 'Dedi Kurniawan',
                'no_hp' => '085678901234',
                'alamat' => 'Dusun Plandaan RT 01/RW 01, Jombang',
                'latitude' => '-7.525000',
                'longitude' => '112.210000',
                'metode_pembayaran' => 'COD / Bayar di Tempat',
                'bukti_transfer' => null,
                'ongkir' => 15000,
                'tanggal_transaksi' => Carbon::now()->subDay()->subHours(3),
                'total_harga' => 190000,
                'nominal_bayar' => 0,
                'kembalian' => 0,
                'status' => 'dikirim',
                'catatan' => 'Kurir toko sedang dalam perjalanan ke alamat tujuan.',
                'items' => [
                    ['produk' => $produkSelang, 'jumlah' => 1],
                ],
            ],
            // 6. Selesai (Riwayat Kasir & Transaksi Admin)
            [
                'kode_transaksi' => 'TRX-20261017-0006',
                'pelanggan_id' => $pelanggan1?->id,
                'kasir_id' => $kasir1?->id,
                'nama_pelanggan' => 'Pak Joko Santoso',
                'no_hp' => '081298765432',
                'alamat' => 'Dusun Sukamaju RT 02/RW 03, Jombang',
                'latitude' => '-7.550123',
                'longitude' => '112.235678',
                'metode_pembayaran' => 'Tunai',
                'bukti_transfer' => null,
                'ongkir' => 0,
                'tanggal_transaksi' => Carbon::now()->subDays(2)->setHour(10)->setMinute(15),
                'total_harga' => 350000,
                'nominal_bayar' => 400000,
                'kembalian' => 50000,
                'status' => 'selesai',
                'catatan' => 'Pembelian langsung di toko.',
                'items' => [
                    ['produk' => $produkCangkul, 'jumlah' => 2],
                    ['produk' => $produkArit, 'jumlah' => 4],
                ],
            ],
            // 7. Selesai
            [
                'kode_transaksi' => 'TRX-20261017-0007',
                'pelanggan_id' => $pelanggan2?->id,
                'kasir_id' => $kasir2?->id,
                'nama_pelanggan' => 'Hadi Prasetyo',
                'no_hp' => '085712349876',
                'alamat' => 'Jl. Raya Tembelang No. 45, Jombang',
                'latitude' => '-7.531200',
                'longitude' => '112.241500',
                'metode_pembayaran' => 'Tunai',
                'bukti_transfer' => null,
                'ongkir' => 0,
                'tanggal_transaksi' => Carbon::now()->subDays(2)->setHour(14)->setMinute(30),
                'total_harga' => 1250000,
                'nominal_bayar' => 1250000,
                'kembalian' => 0,
                'status' => 'selesai',
                'catatan' => 'Pembelian grosir kelompok tani.',
                'items' => [
                    ['produk' => $produkSprayer, 'jumlah' => 3],
                    ['produk' => $produkMulsa, 'jumlah' => 1],
                ],
            ],
            // 8. Selesai
            [
                'kode_transaksi' => 'TRX-20261016-0008',
                'pelanggan_id' => null,
                'kasir_id' => $kasir1?->id,
                'nama_pelanggan' => 'Pak Slamet (Pelanggan Tunai)',
                'no_hp' => '081233445566',
                'alamat' => 'Peterongan, Jombang',
                'latitude' => null,
                'longitude' => null,
                'metode_pembayaran' => 'Tunai',
                'bukti_transfer' => null,
                'ongkir' => 0,
                'tanggal_transaksi' => Carbon::now()->subDays(3)->setHour(9)->setMinute(45),
                'total_harga' => 175000,
                'nominal_bayar' => 200000,
                'kembalian' => 25000,
                'status' => 'selesai',
                'catatan' => 'Transaksi kasir offline.',
                'items' => [
                    ['produk' => $produkBendo, 'jumlah' => 1],
                    ['produk' => $produkArit, 'jumlah' => 2],
                ],
            ],
            // 9. Selesai
            [
                'kode_transaksi' => 'TRX-20261015-0009',
                'pelanggan_id' => null,
                'kasir_id' => $kasir2?->id,
                'nama_pelanggan' => 'Ibu Darmiati',
                'no_hp' => '081399887766',
                'alamat' => 'Diwek, Jombang',
                'latitude' => null,
                'longitude' => null,
                'metode_pembayaran' => 'QRIS',
                'bukti_transfer' => null,
                'ongkir' => 0,
                'tanggal_transaksi' => Carbon::now()->subDays(4)->setHour(11)->setMinute(20),
                'total_harga' => 280000,
                'nominal_bayar' => 280000,
                'kembalian' => 0,
                'status' => 'selesai',
                'catatan' => 'Lunas via QRIS.',
                'items' => [
                    ['produk' => $produkMulsa, 'jumlah' => 1],
                ],
            ],
            // 10. Selesai
            [
                'kode_transaksi' => 'TRX-20261014-0010',
                'pelanggan_id' => null,
                'kasir_id' => $kasir1?->id,
                'nama_pelanggan' => 'Kelompok Tani Subur',
                'no_hp' => '082233445577',
                'alamat' => 'Sumobito, Jombang',
                'latitude' => null,
                'longitude' => null,
                'metode_pembayaran' => 'Transfer Bank BRI',
                'bukti_transfer' => null,
                'ongkir' => 0,
                'tanggal_transaksi' => Carbon::now()->subDays(5)->setHour(16)->setMinute(0),
                'total_harga' => 450000,
                'nominal_bayar' => 500000,
                'kembalian' => 50000,
                'status' => 'selesai',
                'catatan' => 'Pembelian alat kebun.',
                'items' => [
                    ['produk' => $produkCangkul, 'jumlah' => 4],
                    ['produk' => $produkBendo, 'jumlah' => 2],
                ],
            ],
        ];

        foreach ($daftarTransaksi as $tData) {
            $items = $tData['items'] ?? [];
            unset($tData['items']);

            $transaksi = Transaksi::updateOrCreate(
                ['kode_transaksi' => $tData['kode_transaksi']],
                $tData
            );

            // Simpan detail transaksi
            DetailTransaksi::where('transaksi_id', $transaksi->id)->delete();
            $calculatedTotal = 0;

            foreach ($items as $item) {
                $p = $item['produk'];
                if ($p) {
                    $qty = $item['jumlah'];
                    $harga = $p->harga;
                    $subtotal = $qty * $harga;
                    $calculatedTotal += $subtotal;

                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $p->id,
                        'jumlah' => $qty,
                        'harga_satuan' => $harga,
                        'subtotal' => $subtotal,
                    ]);
                }
            }

            if ($calculatedTotal > 0 && empty($transaksi->total_harga)) {
                $transaksi->update(['total_harga' => $calculatedTotal + $transaksi->ongkir]);
            }
        }
    }
}
