<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita'; 

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori',
        'gambar',
        'penulis',
        'status',
        'jenis',
        'tanggal_mulai_promo',
        'tanggal_berakhir_promo',
        'popup',
        'views',
        'published_at'
    ];

    protected $casts = [
        'tanggal_mulai_promo' => 'date',
        'tanggal_berakhir_promo' => 'date',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
}