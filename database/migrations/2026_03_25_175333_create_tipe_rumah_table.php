<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipe_rumah', function (Blueprint $table) {
            $table->id('id_tipe');
            $table->foreignId('perumahan_id')->constrained('perumahan', 'id_perumahan')->onDelete('cascade');
            $table->string('nama_tipe');
            $table->string('slug')->nullable();
            $table->decimal('luas_bangunan', 10, 2)->default(0);
            $table->decimal('luas_tanah', 10, 2)->default(0);
            $table->integer('kamar_tidur')->default(0);
            $table->integer('kamar_mandi')->default(0);
            $table->integer('parkiran')->default(0);
            $table->decimal('harga', 15, 0);
            $table->decimal('harga_promo', 15, 0)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto_denah')->nullable();
            $table->json('foto_rumah')->nullable();
            $table->integer('total_unit')->default(0);
            $table->integer('unit_terjual')->default(0);
            $table->integer('unit_tersedia')->default(0);
            $table->enum('status', ['aktif', 'nonaktif', 'draft'])->default('draft');
            $table->timestamps();
            
            // Index untuk performance
            $table->index('perumahan_id');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipe_rumah');
    }
};