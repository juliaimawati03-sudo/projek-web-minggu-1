<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        if ($suppliers->isEmpty()) {
            return;
        }

        $s1 = $suppliers[0]->id;
        $s2 = $suppliers[1]->id ?? $s1;
        $s3 = $suppliers[2]->id ?? $s1;
        $s4 = $suppliers[3]->id ?? $s1;
        $s5 = $suppliers[4]->id ?? $s1;

        $produk = [
            // Kategori: pengolahan-tanah
            [
                'supplier_id' => $s5,
                'nama_produk' => 'Cangkul Baja EGA Super Kuat',
                'kategori' => 'pengolahan-tanah',
                'deskripsi' => 'Cangkul tempa baja pilihan asli EGA, tajam, kokoh, dan tahan benturan batu padas.',
                'gambar' => null,
                'harga' => 85000,
                'stok' => 35,
            ],
            [
                'supplier_id' => $s5,
                'nama_produk' => 'Garu Tanah 4 Mata Baja',
                'kategori' => 'pengolahan-tanah',
                'deskripsi' => 'Garu pembalik tanah dan pembersih sisa jerami sawah 4 mata baja tempa kuat.',
                'gambar' => null,
                'harga' => 65000,
                'stok' => 20,
            ],
            [
                'supplier_id' => $s1,
                'nama_produk' => 'Sekop Pasir & Tanah Gagang Kayu',
                'kategori' => 'pengolahan-tanah',
                'deskripsi' => 'Sekop plat baja tebal dengan gagang kayu jati kokoh, nyaman untuk pengerukan tanah bedengan.',
                'gambar' => null,
                'harga' => 75000,
                'stok' => 25,
            ],
            [
                'supplier_id' => $s4,
                'nama_produk' => 'Bajak Singkal Mini Tangan',
                'kategori' => 'pengolahan-tanah',
                'deskripsi' => 'Alat pembalik tanah manual singkal mini cocok untuk bedengan sayur dan lahan sempit.',
                'gambar' => null,
                'harga' => 220000,
                'stok' => 8,
            ],

            // Kategori: pemotong
            [
                'supplier_id' => $s5,
                'nama_produk' => 'Arit Rumput Baja Tempa Tajam',
                'kategori' => 'pemotong',
                'deskripsi' => 'Arit potong rumput tajam dan awet diasah, gagang kayu nyaman digenggam.',
                'gambar' => null,
                'harga' => 45000,
                'stok' => 40,
            ],
            [
                'supplier_id' => $s5,
                'nama_produk' => 'Bendo / Parang Tebas Kayu Tebal',
                'kategori' => 'pemotong',
                'deskripsi' => 'Parang tebas ranting kayu dan bambu, baja per sepuh kualitas tinggi.',
                'gambar' => null,
                'harga' => 55000,
                'stok' => 30,
            ],
            [
                'supplier_id' => $s3,
                'nama_produk' => 'Gunting Dahan & Ranting Tanaman',
                'kategori' => 'pemotong',
                'deskripsi' => 'Gunting stek ranting tanaman buah & bunga, mata pisau stainless anti karat.',
                'gambar' => null,
                'harga' => 60000,
                'stok' => 18,
            ],
            [
                'supplier_id' => $s1,
                'nama_produk' => 'Sabit Bergerigi Padi Panen',
                'kategori' => 'pemotong',
                'deskripsi' => 'Sabit khusus panen padi dengan gerigi micro halus, mempercepat panen tanpa rontok.',
                'gambar' => null,
                'harga' => 40000,
                'stok' => 50,
            ],

            // Kategori: pertanian
            [
                'supplier_id' => $s4,
                'nama_produk' => 'Sprayer Gendong Tanaman 16L Elektrik',
                'kategori' => 'pertanian',
                'deskripsi' => 'Tangki semprot hama 16 liter baterai charger otomatis, tekanan semprot stabil dan kuat.',
                'gambar' => null,
                'harga' => 320000,
                'stok' => 12,
            ],
            [
                'supplier_id' => $s2,
                'nama_produk' => 'Selang Irigasi Pertanian 2 Inch (50 Meter)',
                'kategori' => 'pertanian',
                'deskripsi' => 'Selang buang terpal pompa air irigasi sawah tebal anti sobek panjang 50 meter.',
                'gambar' => null,
                'harga' => 175000,
                'stok' => 15,
            ],
            [
                'supplier_id' => $s2,
                'nama_produk' => 'Mulsa Plastik Hitam Perak 1 Roll',
                'kategori' => 'pertanian',
                'deskripsi' => 'Plastik mulsa penutup tanah lebar 120cm panjang 500m mencegah gulma dan menjaga kelembaban.',
                'gambar' => null,
                'harga' => 280000,
                'stok' => 10,
            ],
            [
                'supplier_id' => $s3,
                'nama_produk' => 'Gembor / Penyiram Tanaman 10 Liter',
                'kategori' => 'pertanian',
                'deskripsi' => 'Emrat penyiram tanaman plastik tebal lubang kucuran halus merata.',
                'gambar' => null,
                'harga' => 45000,
                'stok' => 22,
            ],

            // Kategori: ternak
            [
                'supplier_id' => $s4,
                'nama_produk' => 'Mesin Chopper Pakan Ternak Manual / Engkol',
                'kategori' => 'ternak',
                'deskripsi' => 'Alat perajang rumput gajah & jerami pakan sapi kambing manual pisau putar ganda.',
                'gambar' => null,
                'harga' => 380000,
                'stok' => 6,
            ],
            [
                'supplier_id' => $s3,
                'nama_produk' => 'Tempat Pakan Ayam Otomatis 5 Kg',
                'kategori' => 'ternak',
                'deskripsi' => 'Feeder tempat makan ayam gantung kapasitas 5 kg bahan plastik lentur tahan banting.',
                'gambar' => null,
                'harga' => 35000,
                'stok' => 45,
            ],
            [
                'supplier_id' => $s3,
                'nama_produk' => 'Nipple Drinker Otomatis Unggas (Paket 10 Pcs)',
                'kategori' => 'ternak',
                'deskripsi' => 'Dot minum ayam otomatis anti bocor dengan mangkok mangkok penampung tetesan air.',
                'gambar' => null,
                'harga' => 40000,
                'stok' => 60,
            ],
            [
                'supplier_id' => $s2,
                'nama_produk' => 'Terpal Penutup Kandang & Jerami A3 (4x6 Meter)',
                'kategori' => 'ternak',
                'deskripsi' => 'Terpal plastik waterproof tebal tipe A3 tahan panas dan hujan ukuran 4x6 meter.',
                'gambar' => null,
                'harga' => 95000,
                'stok' => 16,
            ],
        ];

        foreach ($produk as $p) {
            Produk::updateOrCreate(
                ['nama_produk' => $p['nama_produk']],
                $p
            );
        }
    }
}
