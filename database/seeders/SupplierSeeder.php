<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'nama_supplier' => 'CV Tani Makmur Jombang',
                'no_telepon' => '0812-3456-7890',
                'alamat' => 'Jl. Raya Pertanian No. 12, Peterongan, Jombang',
            ],
            [
                'nama_supplier' => 'UD Sumber Subur Mojokerto',
                'no_telepon' => '0821-9988-1122',
                'alamat' => 'Jl. Merdeka No. 45, Magersari, Mojokerto',
            ],
            [
                'nama_supplier' => 'Toko Agro Jaya Kediri',
                'no_telepon' => '0813-2211-4455',
                'alamat' => 'Jl. Diponegoro No. 7, Pare, Kediri',
            ],
            [
                'nama_supplier' => 'PT Pandawa Alat Tani Surabaya',
                'no_telepon' => '0852-7788-9900',
                'alamat' => 'Kawasan Industri SIER Blok C-9, Surabaya',
            ],
            [
                'nama_supplier' => 'Sentra Baja Logam Tani Klaten',
                'no_telepon' => '0819-3344-5566',
                'alamat' => 'Jl. Cor Logam Ceper No. 8, Klaten',
            ],
            [
                'nama_supplier' => 'Agri Makmur Nusantara Malang',
                'no_telepon' => '0812-8877-6655',
                'alamat' => 'Jl. Raya Karangploso No. 23, Malang',
            ],
        ];

        foreach ($suppliers as $s) {
            Supplier::updateOrCreate(
                ['nama_supplier' => $s['nama_supplier']],
                $s
            );
        }
    }
}
