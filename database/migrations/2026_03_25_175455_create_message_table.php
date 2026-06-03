<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('subjek');
            $table->text('pesan');
            $table->enum('status', ['belum_dibaca', 'sudah_dibaca', 'dibalas'])->default('belum_dibaca');
            $table->timestamp('dibaca_pada')->nullable();
            $table->text('balasan')->nullable();
            $table->timestamp('dibalas_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};