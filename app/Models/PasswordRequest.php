<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordRequest extends Model
{
    protected $table = 'password_requests';

    protected $fillable = [
        'username', 'nama', 'no_telepon', 'pesan',
        'status', 'resolved_at', 'resolved_by',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}