<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'catatan_keuangan';

    protected $fillable = [
        'user_id',
        'tanggal',
        'nominal',
        'keterangan',
        
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}