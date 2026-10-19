<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Hanya tambahkan kolom yang BENAR-BENAR BELUM ADA di migration awal
            // (Hapus 'kode_transaksi', 'ongkir', dll jika sudah dibuat di create_transaksi_table)
            
            if (!Schema::hasColumn('transaksi', 'pelanggan_id')) {
                $table->foreignId('pelanggan_id')->nullable()->after('id')->constrained('user')->nullOnDelete();
            }
            if (!Schema::hasColumn('transaksi', 'nama_pelanggan')) {
                $table->string('nama_pelanggan')->nullable()->after('pelanggan_id');
            }
            if (!Schema::hasColumn('transaksi', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('nama_pelanggan');
            }
            if (!Schema::hasColumn('transaksi', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('transaksi', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('transaksi', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('transaksi', 'bukti_transfer')) {
                $table->string('bukti_transfer')->nullable()->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('transaksi', 'status')) {
                $table->string('status')->default('pending')->after('bukti_transfer');
            }
            if (!Schema::hasColumn('transaksi', 'catatan')) {
                $table->text('catatan')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn([
                'pelanggan_id', 'nama_pelanggan', 'no_hp', 'alamat', 
                'latitude', 'longitude', 'bukti_transfer', 'status', 'catatan'
            ]);
        });
    }
};