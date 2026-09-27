<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionDetailFactory extends Factory
{
    public function definition(): array
    {
        $jumlah = fake()->numberBetween(1, 10);
        $harga = fake()->numberBetween(10000, 500000);
        return [
            'transaksi_id' => Transaction::factory(),
            'produk_id' => Product::factory(),
            'jumlah' => $jumlah,
            'harga_satuan' => $harga,
            'subtotal' => $jumlah * $harga,
        ];
    }
}
