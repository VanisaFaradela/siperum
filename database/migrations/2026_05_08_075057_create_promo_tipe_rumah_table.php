<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_tipe_rumah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->constrained('promo')->onDelete('cascade');
            $table->foreignId('tipe_rumah_id')->constrained('tipe_rumah')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_tipe_rumah');
    }
};