<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cluster', function (Blueprint $table) {
            $table->id('id_cluster');
            $table->string('nama_cluster');
            $table->string('slug')->unique();
            $table->text('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos')->nullable();
            $table->decimal('luas_total', 10, 2)->nullable();
            $table->integer('total_unit')->default(0);
            $table->integer('unit_terjual')->default(0);
            $table->integer('unit_tersedia')->default(0);
            $table->text('deskripsi')->nullable();
            $table->text('fasilitas')->nullable();
            $table->string('logo')->nullable();
            $table->string('foto_utama')->nullable();
            $table->json('foto_lainnya')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('nama_pengembang');
            $table->string('kontak_pengembang');
            $table->string('email_pengembang')->nullable();
            $table->string('website')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'draft'])->default('draft');
            $table->enum('sertifikat', ['SHM', 'HGB', 'HPL', 'Lainnya'])->default('SHM');
            $table->string('listrik')->nullable();
            $table->boolean('akses_air_bersih')->default(true);
            $table->boolean('keamanan_24jam')->default(false);
            $table->boolean('one_gate_system')->default(false);
            $table->date('tanggal_launching')->nullable();
            $table->date('tanggal_serah_terima')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cluster');
    }
};