<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BeritaFactory extends Factory
{
    protected $model = \App\Models\Berita::class;

    public function definition(): array
    {
        $judul = $this->faker->sentence(6);
        $status = $this->faker->randomElement(['draft', 'published']);
        
        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'konten' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            'gambar' => null,
            'kategori' => $this->faker->randomElement(['Info Perumahan', 'Tips & Trik', 'Promo', 'Event', 'Pengumuman', 'Artikel']),
            'penulis' => $this->faker->name(),
            'status' => $status,
            'views' => $this->faker->numberBetween(0, 1000),
            'published_at' => $status == 'published' ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}