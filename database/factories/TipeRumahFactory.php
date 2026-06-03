<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TipeRumahFactory extends Factory
{
    protected $model = \App\Models\TipeRumah::class;

    public function definition(): array
    {
        $tipeList = ['36', '45', '54', '60', '72', '90', '120'];
        $tipe = $this->faker->randomElement($tipeList);
        $namaTipe = 'Tipe ' . $tipe;
        $luasBangunan = (int) $tipe;
        $luasTanah = $luasBangunan * $this->faker->numberBetween(1.5, 2.5);
        $harga = $luasBangunan * $this->faker->numberBetween(5000000, 10000000);
        $totalUnit = $this->faker->numberBetween(10, 50);
        $unitTerjual = $this->faker->numberBetween(0, $totalUnit);
        
        return [
            'perumahan_id' => 1,
            'nama_tipe' => $namaTipe,
            'slug' => Str::slug($namaTipe) . '_' . uniqid(), // Tambahkan uniqid agar slug unik
            'luas_bangunan' => $luasBangunan,
            'luas_tanah' => round($luasTanah, 2),
            'kamar_tidur' => $this->faker->numberBetween(2, 5),
            'kamar_mandi' => $this->faker->numberBetween(1, 3),
            'harga' => $harga,
            'harga_promo' => $this->faker->boolean(20) ? $harga * 0.9 : null,
            'total_unit' => $totalUnit,
            'unit_terjual' => $unitTerjual,
            'unit_tersedia' => $totalUnit - $unitTerjual,
            'status' => $this->faker->randomElement(['tersedia', 'promo', 'habis']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}