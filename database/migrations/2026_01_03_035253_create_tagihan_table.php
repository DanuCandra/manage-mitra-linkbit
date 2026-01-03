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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke mitra
            $table->uuid('mitra_id');
            $table->foreign('mitra_id')
                ->references('id')->on('mitra')
                ->onDelete('cascade');

            $table->string('no_tagihan')->unique(); // contoh: INV/2024/001
            $table->string('keterangan')->nullable(); // Tagihan Bandwidth Januari 2024

            // Detail bandwidth - OTOMATIS DARI TABEL MITRA
            // Admin tidak perlu input bandwidth, sistem ambil dari mitra.bandwidth
            // Admin hanya input harga_bandwidth saja

            $table->decimal('harga_bandwidth', 15, 2); // HANYA INI yang diisi admin

            // Total dan status (akan dihitung otomatis = harga_bandwidth)
            $table->decimal('total_tagihan', 15, 2);
            $table->decimal('total_dibayar', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2);

            // Tanggal
            $table->date('tanggal_tagihan'); // kapan tagihan dibuat
            $table->date('tanggal_jatuh_tempo'); // batas waktu pembayaran

            // Status: belum_bayar, cicilan, lunas, terlambat
            $table->enum('status_pembayaran', ['belum_bayar', 'cicilan', 'lunas', 'terlambat'])
                ->default('belum_bayar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
