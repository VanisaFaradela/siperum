<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perumahan;
use App\Models\TipeRumah;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Kontak;
use App\Models\Message;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin
        Admin::create([
            'name' => 'Vanisa Super Admin',
            'email' => 'vanisasuper@gmail.com',
            'password' => Hash::make('vanisa111'),
        ]);
        $this->command->info('✅ Admin berhasil dibuat!');
        
        // Buat 10 perumahan
        $perumahans = Perumahan::factory(10)->create();
        $this->command->info('✅ 10 perumahan berhasil dibuat!');
        
        // Buat tipe rumah untuk setiap perumahan (2 tipe per perumahan)
        foreach ($perumahans as $perumahan) {
            TipeRumah::factory(2)->create(['perumahan_id' => $perumahan->id]);
        }
        $this->command->info('✅ 20 tipe rumah berhasil dibuat!');
        
        // Buat 10 berita
        Berita::factory(10)->create();
        $this->command->info('✅ 10 berita berhasil dibuat!');
        
        // Buat 10 galeri
        Galeri::factory(10)->create();
        $this->command->info('✅ 10 galeri berhasil dibuat!');
        
        // Buat 10 kontak
        Kontak::factory(10)->create();
        $this->command->info('✅ 10 kontak berhasil dibuat!');
        
        // Buat 10 pesan
        Message::factory(10)->create();
        $this->command->info('✅ 10 pesan berhasil dibuat!');
        
        $this->command->info('====================================');
        $this->command->info('✨ SEMUA DATA BERHASIL DIBUAT! ✨');
        $this->command->info('====================================');
        $this->command->info('Email Admin: vanisasuper@gmail.com');
        $this->command->info('Password: vanisa111');
    }
}