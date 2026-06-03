<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KontakFactory extends Factory
{
    protected $model = \App\Models\Kontak::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['belum_dibaca', 'sudah_dibaca', 'dibalas']);
        
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->email(),
            'telepon' => $this->faker->phoneNumber(),
            'perusahaan' => $this->faker->company(),
            'pesan' => $this->faker->paragraph(),
            'status' => $status,
            'dibaca_pada' => $status != 'belum_dibaca' ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
            'balasan' => $status == 'dibalas' ? $this->faker->paragraph() : null,
            'dibalas_pada' => $status == 'dibalas' ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}