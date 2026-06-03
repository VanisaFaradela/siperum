<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_perumahan')->constrained('perumahan')->onDelete('cascade');
            $table->string('judul_promo');
            $table->string('badge')->nullable()->default('HOT DEAL');
            $table->text('deskripsi');
            $table->decimal('harga_awal', 15, 2)->nullable();
            $table->decimal('harga_promo', 15, 2);
            $table->integer('diskon_persen')->nullable();
            $table->string('gambar')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['active', 'expired', 'coming_soon'])->default('active');
            $table->integer('stok')->default(0);
            $table->text('syarat_ketentuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};