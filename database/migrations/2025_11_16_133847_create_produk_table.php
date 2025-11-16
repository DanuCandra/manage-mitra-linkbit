<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->uuid('id')->primary();  // UUID

            // Relasi ke mitra
            $table->uuid('mitra_id');
            $table->foreign('mitra_id')
                ->references('id')->on('mitra')
                ->onDelete('cascade');

            $table->string('nama_produk');
            $table->string('bandwidth')->nullable();
            $table->integer('harga')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
