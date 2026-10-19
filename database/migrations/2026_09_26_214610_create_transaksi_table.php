<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            $table->string('kode_transaksi', 50)->nullable()->unique();
            $table->foreignId('pelanggan_id')->nullable()->constrained('user')->nullOnDelete();
            $table->foreignId('kasir_id')->nullable()->constrained('user')->nullOnDelete();
            $table->string('nama_pelanggan')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('metode_pembayaran', 50)->nullable()->default('Tunai');
            $table->string('bukti_transfer')->nullable();
            $table->integer('ongkir')->default(0);
            $table->dateTime('tanggal_transaksi');
            $table->integer('total_harga');
            $table->integer('nominal_bayar')->default(0);
            $table->integer('kembalian')->default(0);
            $table->enum('status', ['menunggu_verifikasi', 'diproses', 'dikirim', 'selesai', 'ditolak'])->default('menunggu_verifikasi');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
