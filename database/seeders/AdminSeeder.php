<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Vanisa Super Admin',
                'email' => 'vanisasuper@gmail.com',
                'password' => Hash::make('vanisa111'),
            ],
        ];

        foreach ($admins as $admin) {
            // Cek apakah email sudah ada sebelum insert
            if (!Admin::where('email', $admin['email'])->exists()) {
                Admin::create($admin);
                $this->command->info("Admin {$admin['name']} berhasil ditambahkan!");
            } else {
                $this->command->warn("Admin dengan email {$admin['email']} sudah ada!");
            }
        }
    }
}