<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id('id_galeri');
            $table->unsignedBigInteger('id_cluster');
            $table->string('judul_galeri', 150)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('kategori_foto', 100)->nullable();
            $table->string('kategori', 255)->nullable();
            $table->integer('urutan')->default(0);
            $table->string('status', 20)->default('aktif');
            $table->date('tanggal_upload')->nullable();
            $table->timestamps();
            
            $table->foreign('id_cluster')
                  ->references('id_cluster')
                  ->on('cluster')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};