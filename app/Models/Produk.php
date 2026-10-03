<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'supplier_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }
}