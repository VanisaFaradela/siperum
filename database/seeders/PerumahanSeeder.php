<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perumahan;
use Illuminate\Support\Str;

class PerumahanSeeder extends Seeder
{
    public function run(): void
    {
        $perumahanData = [
            [
                'nama_perumahan' => 'Graha Estate',
                'slug' => 'graha-estate',
                'alamat' => 'Jl. Raya Graha No. 123',
                'kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12345',
                'luas_total' => 50000,
                'total_unit' => 250,
                'unit_terjual' => 180,
                'unit_tersedia' => 70,
                'deskripsi' => 'Perumahan modern dengan fasilitas lengkap',
                'fasilitas' => json_encode(['Taman', 'Playground', 'Keamanan 24 Jam']),
                'nama_pengembang' => 'PT Graha Sejahtera',
                'kontak_pengembang' => '081234567890',
                'email_pengembang' => 'info@grahaestate.com',
                'website' => 'https://grahaestate.com',
                'status' => 'aktif',
                'sertifikat' => 'SHM',
                'listrik' => '2200',
                'akses_air_bersih' => true,
                'keamanan_24jam' => true,
                'one_gate_system' => true,
                'views' => 1250,
            ],
            [
                'nama_perumahan' => 'Permata Hijau Residence',
                'slug' => 'permata-hijau-residence',
                'alamat' => 'Jl. Permata Hijau No. 45',
                'kota' => 'Jakarta Barat',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12346',
                'luas_total' => 75000,
                'total_unit' => 350,
                'unit_terjual' => 210,
                'unit_tersedia' => 140,
                'deskripsi' => 'Perumahan hijau dengan konsep eco-friendly',
                'fasilitas' => json_encode(['Kolam Renang', 'Fitness Center', 'Jogging Track']),
                'nama_pengembang' => 'PT Permata Hijau',
                'kontak_pengembang' => '081234567891',
                'email_pengembang' => 'info@permatahijau.com',
                'website' => 'https://permatahijau.com',
                'status' => 'aktif',
                'sertifikat' => 'HGB',
                'listrik' => '3500',
                'akses_air_bersih' => true,
                'keamanan_24jam' => true,
                'one_gate_system' => false,
                'views' => 980,
            ],
            [
                'nama_perumahan' => 'Bumi Asri Park',
                'slug' => 'bumi-asri-park',
                'alamat' => 'Jl. Bumi Asri No. 78',
                'kota' => 'Tangerang',
                'provinsi' => 'Banten',
                'kode_pos' => '12347',
                'luas_total' => 100000,
                'total_unit' => 500,
                'unit_terjual' => 320,
                'unit_tersedia' => 180,
                'deskripsi' => 'Perumahan dengan area hijau terluas',
                'fasilitas' => json_encode(['Taman Kota', 'Danau Buatan', 'Area BBQ']),
                'nama_pengembang' => 'PT Bumi Asri',
                'kontak_pengembang' => '081234567892',
                'email_pengembang' => 'info@bumiasri.com',
                'website' => 'https://bumiasri.com',
                'status' => 'aktif',
                'sertifikat' => 'SHM',
                'listrik' => '2200',
                'akses_air_bersih' => true,
                'keamanan_24jam' => true,
                'one_gate_system' => true,
                'views' => 2100,
            ],
        ];

        foreach ($perumahanData as $data) {
            Perumahan::create($data);
        }
    }
}