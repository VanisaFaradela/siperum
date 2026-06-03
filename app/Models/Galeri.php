<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    
    protected $fillable = [
        'id_cluster',
        'judul_galeri',
        'foto',
        'kategori_foto',
        'kategori',
        'urutan',
        'status',
        'tanggal_upload'
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'id_cluster', 'id');
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }
        return asset('images/no-image.jpg');
    }
}