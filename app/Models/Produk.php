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
        'kategori',
        'deskripsi',
        'gambar',
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

    public function gambarUrl(): string
    {
        if ($this->gambar && file_exists(storage_path('app/public/'.$this->gambar))) {
            return asset('storage/'.$this->gambar);
        }

        return 'https://via.placeholder.com/80x80?text=No+Image';
    }
}
