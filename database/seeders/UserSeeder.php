<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator SIMANTAP',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '081234567890',
                'alamat' => 'Kantor Toko SIMANTAP, Jl. Pertanian No. 1, Jombang',
                'latitude' => '-7.546835',
                'longitude' => '112.226512',
            ]
        );

        // 2. Kasir
        User::updateOrCreate(
            ['username' => 'kasir'],
            [
                'nama' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'no_hp' => '082345678901',
                'alamat' => 'Jl. Merdeka Barat No. 15, Jombang',
                'latitude' => '-7.549100',
                'longitude' => '112.228500',
            ]
        );

        User::updateOrCreate(
            ['username' => 'kasir2'],
            [
                'nama' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'no_hp' => '083456789012',
                'alamat' => 'Desa Candi Mulyo, Jombang',
                'latitude' => '-7.542000',
                'longitude' => '112.231000',
            ]
        );

        // 3. Pelanggan
        $pelanggan = [
            [
                'username' => 'pelanggan',
                'nama' => 'Pak Joko Santoso',
                'no_hp' => '081298765432',
                'alamat' => 'Dusun Sukamaju RT 02/RW 03, Kec. Subur Makmur, Jombang',
                'latitude' => '-7.550123',
                'longitude' => '112.235678',
            ],
            [
                'username' => 'hadi',
                'nama' => 'Hadi Prasetyo',
                'no_hp' => '085712349876',
                'alamat' => 'Jl. Raya Tembelang No. 45, Jombang',
                'latitude' => '-7.531200',
                'longitude' => '112.241500',
            ],
            [
                'username' => 'ahmad',
                'nama' => 'Ahmad Fauzi',
                'no_hp' => '083812345678',
                'alamat' => 'Desa Sambong Permai Blok B-12, Jombang',
                'latitude' => '-7.548000',
                'longitude' => '112.215000',
            ],
            [
                'username' => 'rina',
                'nama' => 'Rina Wati',
                'no_hp' => '087859563173',
                'alamat' => 'Jl. Wahid Hasyim No. 88, Jombang',
                'latitude' => '-7.555000',
                'longitude' => '112.230000',
            ],
            [
                'username' => 'dedi',
                'nama' => 'Dedi Kurniawan',
                'no_hp' => '085678901234',
                'alamat' => 'Dusun Plandaan RT 01/RW 01, Jombang',
                'latitude' => '-7.525000',
                'longitude' => '112.210000',
            ],
        ];

        foreach ($pelanggan as $p) {
            User::updateOrCreate(
                ['username' => $p['username']],
                [
                    'nama' => $p['nama'],
                    'password' => Hash::make('password'),
                    'role' => 'pelanggan',
                    'no_hp' => $p['no_hp'],
                    'alamat' => $p['alamat'],
                    'latitude' => $p['latitude'],
                    'longitude' => $p['longitude'],
                ]
            );
        }
    }
}
