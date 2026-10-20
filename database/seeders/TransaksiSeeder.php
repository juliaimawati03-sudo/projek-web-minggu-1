<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'kasir')->get();

        if ($users->isEmpty()) {
            User::factory()
                ->count(5)
                ->create(['role' => 'kasir']);

            $users = User::where('role', 'kasir')->get();
        }

        Transaksi::factory()
            ->count(20)
            ->recycle($users)
            ->create();
    }
}