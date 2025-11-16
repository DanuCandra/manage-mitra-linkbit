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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID

            // ID Pelanggan dari ISP (optional)
            $table->string('id_pelanggan')->nullable();

            // Relasi ke mitra
            $table->uuid('mitra_id');
            $table->foreign('mitra_id')
                ->references('id')->on('mitra')
                ->onDelete('cascade');

            // Relasi ke produk
            $table->uuid('produk_id');
            $table->foreign('produk_id')
                ->references('id')->on('produk')
                ->onDelete('cascade');

            $table->string('nama');
            $table->string('nik')->nullable();
            $table->text('alamat')->nullable();

            $table->date('mulai_berlangganan')->nullable();

            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
