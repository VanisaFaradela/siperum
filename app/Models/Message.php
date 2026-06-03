<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'message';  // tanpa s

    protected $fillable = [
        'nama', 'email', 'telepon', 'subjek', 'pesan',
        'status', 'dibaca_pada', 'balasan', 'dibalas_pada'
    ];

    protected $casts = [
        'dibaca_pada' => 'datetime',
        'dibalas_pada' => 'datetime',
    ];
}