<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';
    
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'perusahaan',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'tiktok',
        'status'
    ];
}