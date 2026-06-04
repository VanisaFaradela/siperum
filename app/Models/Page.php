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

    public function getEmbedVideoAttribute()
    {
        if (!$this->video) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=)([^&]+)/', $this->video, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        if (preg_match('/(?:youtu\.be\/)([^?&]+)/', $this->video, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $this->video;
    }
}