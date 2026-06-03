<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GaleriFactory extends Factory
{
    protected $model = \App\Models\Galeri::class;

    public function definition(): array
    {
        $kategoriList = ['umum', 'fasilitas', 'rumah', 'lingkungan', 'event', 'promo'];
        
        return [
            'id_perumahan' => 1,
            'judul_galeri' => $this->faker->sentence(3),
            'foto' => 'storage/galeri/dummy_' . $this->faker->numberBetween(1, 10) . '.jpg',
            'kategori_foto' => $this->faker->randomElement($kategoriList),
            'tanggal_upload' => now()->toDateString(),
            'kategori' => $this->faker->randomElement($kategoriList),
            'status' => $this->faker->randomElement(['aktif', 'nonaktif']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}