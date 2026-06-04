<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TipeRumah extends Model
{
    use HasFactory;

    protected $table = 'tipe_rumah';
    protected $primaryKey = 'id_tipe';
    
    protected $fillable = [
        'cluster_id',        // Foreign key ke cluster
        'nama_tipe',
        'slug',
        'luas_bangunan',
        'luas_tanah',
        'kamar_tidur',
        'kamar_mandi',
        'parkiran',
        'harga',
        'harga_promo',
        'deskripsi',
        'foto_denah',
        'foto_rumah',
        'total_unit',
        'unit_terjual',
        'unit_tersedia',
        'status',
        'blok',
        'nomor_unit',
        'status_unit'
    ];

    protected $casts = [
        'foto_rumah' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tipe) {
            $tipe->slug = Str::slug($tipe->nama_tipe);
        });
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'cluster_id', 'id_cluster');
    }
}