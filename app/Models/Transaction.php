<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'kasir_id',
        'tanggal_transaksi',
        'total_harga',
        'nominal_bayar',
        'kembalian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
