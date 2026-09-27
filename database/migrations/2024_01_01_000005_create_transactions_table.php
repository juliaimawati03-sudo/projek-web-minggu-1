<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('nominal_bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
