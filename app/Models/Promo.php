<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promos';
    
    protected $fillable = [
        'judul_promo',
        'badge',
        'gambar',
        'cluster_id',
        'harga_awal',
        'harga_promo',
        'diskon',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'deskripsi'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function tipeRumah()
    {
        return $this->belongsToMany(TipeRumah::class, 'promo_tipe_rumah')
                    ->withTimestamps();
    }
}