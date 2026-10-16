<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kasir_id',
        'tanggal_transaksi',
        'total_harga',
        'nominal_bayar',
        'kembalian',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga' => 'integer',
        'nominal_bayar' => 'integer',
        'kembalian' => 'integer',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}