<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\FinancialRecord;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun admin statis
        User::factory()->create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Data Master (User Kasir, Supplier, Product)
        $kasirs = User::factory(5)->create(['role' => 'kasir']);
        $suppliers = Supplier::factory(5)->create();
        
        $products = collect();
        foreach ($suppliers as $supplier) {
            $products = $products->merge(Product::factory(3)->create([
                'supplier_id' => $supplier->id,
            ]));
        }

        // 3. Data Transaksi
        foreach ($kasirs as $kasir) {
            $transactions = Transaction::factory(2)->create([
                'kasir_id' => $kasir->id,
            ]);

            foreach ($transactions as $transaction) {
                $product = $products->random();
                TransactionDetail::factory()->create([
                    'transaksi_id' => $transaction->id,
                    'produk_id' => $product->id,
                ]);
            }
        }

        // 4. Data Pengeluaran
        foreach ($suppliers as $supplier) {
            Expense::factory(2)->create([
                'supplier_id' => $supplier->id,
            ]);
        }

        // 5. Data Catatan Keuangan
        foreach ($kasirs as $kasir) {
            FinancialRecord::factory(2)->create([
                'user_id' => $kasir->id,
            ]);
        }
    }
}
