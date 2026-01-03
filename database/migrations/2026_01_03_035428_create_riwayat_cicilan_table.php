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
        Schema::create('riwayat_cicilan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke tagihan
            $table->uuid('tagihan_id');
            $table->foreign('tagihan_id')
                ->references('id')->on('tagihan')
                ->onDelete('cascade');

            // Relasi ke pembayaran
            $table->uuid('pembayaran_id');
            $table->foreign('pembayaran_id')
                ->references('id')->on('pembayaran')
                ->onDelete('cascade');

            $table->integer('cicilan_ke'); // cicilan ke-1, ke-2, dst
            $table->decimal('jumlah_cicilan', 15, 2);
            $table->date('tanggal_cicilan');
            $table->enum('status', ['diterima', 'pending', 'ditolak'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_cicilan');
    }
};
