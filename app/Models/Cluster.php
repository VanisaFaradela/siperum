<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cluster extends Model
{
    use HasFactory;

    protected $table = 'cluster';
    protected $primaryKey = 'id_cluster';  // Kunci utama adalah id_cluster
    
    protected $fillable = [
        'nama_cluster',
        'slug',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'luas_total',
        'total_unit',
        'unit_terjual',
        'unit_tersedia',
        'deskripsi',
        'fasilitas',
        'logo',
        'foto_utama',
        'foto_lainnya',
        'latitude',
        'longitude',
        'nama_pengembang',
        'kontak_pengembang',
        'email_pengembang',
        'website',
        'status',
        'sertifikat',
        'listrik',
        'akses_air_bersih',
        'keamanan_24jam',
        'one_gate_system',
        'tanggal_launching',
        'tanggal_serah_terima',
        'views'
    ];

    protected $casts = [
        'fasilitas' => 'array',  // Ini akan otomatis handle JSON
        'foto_lainnya' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($cluster) {
            $cluster->slug = Str::slug($cluster->nama_cluster);
        });
    }

    public function tipeRumah()
    {
        return $this->hasMany(TipeRumah::class, 'cluster_id', 'id_cluster');
    }
}