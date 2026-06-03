<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perumahan>
 */
class PerumahanFactory extends Factory
{
    protected $model = \App\Models\Perumahan::class;

    public function definition(): array
    {
        $nama = $this->faker->company() . ' ' . $this->faker->randomElement(['Residence', 'Park', 'Estate', 'Housing']);
        $totalUnit = $this->faker->numberBetween(50, 500);
        $unitTerjual = $this->faker->numberBetween(0, $totalUnit);
        
        return [
            'nama_perumahan' => $nama,
            'slug' => Str::slug($nama),
            'alamat' => $this->faker->streetAddress(),
            'kota' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
            'kode_pos' => $this->faker->postcode(),
            'luas_total' => $this->faker->numberBetween(10000, 200000),
            'total_unit' => $totalUnit,
            'unit_terjual' => $unitTerjual,
            'unit_tersedia' => $totalUnit - $unitTerjual,
            'deskripsi' => $this->faker->paragraph(),
            'fasilitas' => json_encode($this->faker->randomElements(['Taman', 'Playground', 'Kolam Renang', 'Fitness Center', 'Jogging Track', 'Masjid', 'Sekolah', 'Mini Market'], 3)),
            'nama_pengembang' => $this->faker->company(),
            'kontak_pengembang' => $this->faker->phoneNumber(),
            'email_pengembang' => $this->faker->email(),
            'website' => $this->faker->url(),
            'status' => $this->faker->randomElement(['aktif', 'nonaktif', 'draft']),
            'sertifikat' => $this->faker->randomElement(['SHM', 'HGB', 'HPL']),
            'listrik' => $this->faker->randomElement(['450', '900', '1300', '2200', '3500']),
            'akses_air_bersih' => $this->faker->boolean(),
            'keamanan_24jam' => $this->faker->boolean(),
            'one_gate_system' => $this->faker->boolean(),
            'views' => $this->faker->numberBetween(0, 5000),
        ];
    }
}