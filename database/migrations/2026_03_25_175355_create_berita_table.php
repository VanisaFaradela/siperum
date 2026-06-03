<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel berita
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('konten');
            $table->string('gambar')->nullable();
            $table->string('kategori');
            $table->string('penulis');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->enum('jenis', ['berita', 'promo'])->default('berita');
            $table->date('tanggal_mulai_promo')->nullable();
            $table->date('tanggal_berakhir_promo')->nullable();
            $table->enum('popup', ['ya', 'tidak'])->default('tidak');
            $table->integer('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};