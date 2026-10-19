<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaksi>
 */
class TransaksiFactory extends Factory
{
    public function definition(): array
    {
        $totalHarga = fake()->numberBetween(20000, 1000000);
        $nominalBayar = fake()->numberBetween(
            $totalHarga,
            $totalHarga + 500000
        );

        return [
            'kasir_id' => User::factory(),
            'tanggal_transaksi' => fake()->date(),
            'total_harga' => $totalHarga,
            'nominal_bayar' => $nominalBayar,
            'kembalian' => $nominalBayar - $totalHarga,
        ];
    }
}
