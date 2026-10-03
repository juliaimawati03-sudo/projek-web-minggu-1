<?php

namespace Database\Seeders;

use App\Models\CatatanKeuangan;
use App\Models\User;
use Illuminate\Database\Seeder;

class CatatanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        CatatanKeuangan::factory()
            ->count(20)
            ->recycle($users)
            ->create();
    }
}