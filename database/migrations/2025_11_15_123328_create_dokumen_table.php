<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();  // ← UUID sebagai primary key

            // Relasi ke mitra (UUID)
            $table->uuid('mitra_id');
            $table->foreign('mitra_id')->references('id')->on('mitra')->onDelete('cascade');

            // Dokumen-dokumen
            $table->string('nib')->nullable();
            $table->string('sertif_standar')->nullable();
            $table->string('kso')->nullable();

            $table->string('foto_ktp')->nullable();
            $table->string('foto_usaha')->nullable();
            $table->string('foto_brosur')->nullable();

            $table->string('tahun')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
