<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'pelanggan_id',
        'kasir_id',
        'nama_pelanggan',
        'no_hp',
        'alamat',
        'latitude',
        'longitude',
        'metode_pembayaran',
        'bukti_transfer',
        'ongkir',
        'tanggal_transaksi',
        'total_harga',
        'nominal_bayar',
        'kembalian',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga' => 'integer',
        'nominal_bayar' => 'integer',
        'kembalian' => 'integer',
        'ongkir' => 'integer',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}
