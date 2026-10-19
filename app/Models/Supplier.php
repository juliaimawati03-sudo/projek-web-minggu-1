<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'nama_supplier',
        'no_telepon',
        'alamat',
    ];

    public function products()
    {
        return $this->hasMany(Produk::class, 'supplier_id');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'supplier_id');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'supplier_id');
    }
}
