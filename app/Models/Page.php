<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'video',
        'status',
        'meta_data',
        'order'
    ];

    protected $casts = [
        'meta_data' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            $page->slug = Str::slug($page->title);
        });
        
        static::updating(function ($page) {
            $page->slug = Str::slug($page->title);
        });
    }

    // Accessor untuk mendapatkan URL video YouTube yang embeddable
    public function getEmbedVideoAttribute()
    {
        if (!$this->video) return null;
        
        // Konversi URL YouTube ke embed URL
        if (strpos($this->video, 'youtube.com/watch?v=') !== false) {
            $videoId = str_replace('https://www.youtube.com/watch?v=', '', $this->video);
            return 'https://www.youtube.com/embed/' . $videoId;
        } elseif (strpos($this->video, 'youtu.be/') !== false) {
            $videoId = str_replace('https://youtu.be/', '', $this->video);
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        
        return $this->video;
    }
}