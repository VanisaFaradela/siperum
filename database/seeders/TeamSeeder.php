<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $team = [
            [
                'nama' => 'Ir. Budi Hartono, M.M.',
                'jabatan' => 'Founder & CEO',
                'deskripsi' => 'Pendiri perusahaan dengan pengalaman lebih dari 15 tahun di bidang properti dan pengembangan kawasan.',
                'email' => 'budi@perumahan.com',
                'telepon' => '0812-3456-7890',
                'status' => 'aktif',
                'urutan' => 1
            ],
            [
                'nama' => 'Dewi Lestari, S.E.',
                'jabatan' => 'Direktur Marketing',
                'deskripsi' => 'Ahli pemasaran properti dengan pengalaman lebih dari 10 tahun.',
                'email' => 'dewi@perumahan.com',
                'telepon' => '0812-3456-7891',
                'status' => 'aktif',
                'urutan' => 2
            ],
            [
                'nama' => 'Ir. Ahmad Fauzi',
                'jabatan' => 'Direktur Operasional',
                'deskripsi' => 'Berpengalaman dalam manajemen proyek konstruksi skala besar.',
                'email' => 'ahmad@perumahan.com',
                'telepon' => '0812-3456-7892',
                'status' => 'aktif',
                'urutan' => 3
            ],
            [
                'nama' => 'Siti Nurjanah, S.E., M.Ak.',
                'jabatan' => 'Direktur Keuangan',
                'deskripsi' => 'Ahli dalam manajemen keuangan dan perpajakan perusahaan.',
                'email' => 'siti@perumahan.com',
                'telepon' => '0812-3456-7893',
                'status' => 'aktif',
                'urutan' => 4
            ],
        ];

        foreach ($team as $member) {
            Team::create($member);
        }
    }
}