<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialRecordFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tanggal' => fake()->date(),
            'nominal' => fake()->numberBetween(50000, 2000000),
            'keterangan' => fake('id_ID')->sentence(),
            'jenis' => fake()->randomElement(['pemasukan', 'pengeluaran']),
        ];
    }
}
