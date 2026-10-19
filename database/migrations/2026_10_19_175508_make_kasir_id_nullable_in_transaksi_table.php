<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Drop foreign key dulu (kalau ada)
            $table->dropForeign(['kasir_id']);

            // Ubah jadi nullable
            $table->foreignId('kasir_id')->nullable()->change();

            // Tambah FK kembali (nullable)
            $table->foreign('kasir_id')->references('id')->on('user')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['kasir_id']);
            $table->foreignId('kasir_id')->nullable(false)->change();
            $table->foreign('kasir_id')->references('id')->on('user')->cascadeOnDelete();
        });
    }
};