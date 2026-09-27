<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $total = fake()->numberBetween(50000, 1000000);
        $nominal_bayar = $total + fake()->randomElement([0, 5000, 10000, 50000]);
        return [
            'kasir_id' => User::factory(),
            'tanggal_transaksi' => fake()->date(),
            'total_harga' => $total,
            'nominal_bayar' => $nominal_bayar,
            'kembalian' => $nominal_bayar - $total,
        ];
    }
}
