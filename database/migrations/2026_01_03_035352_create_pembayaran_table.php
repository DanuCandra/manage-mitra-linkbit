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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke tagihan
            $table->uuid('tagihan_id');
            $table->foreign('tagihan_id')
                ->references('id')->on('tagihan')
                ->onDelete('cascade');

            // Relasi ke account bank yang dipilih mitra
            $table->uuid('account_bank_id');
            $table->foreign('account_bank_id')
                ->references('id')->on('account_bank')
                ->onDelete('restrict');

            $table->string('no_pembayaran')->unique(); // PAY/2024/001

            // Jenis pembayaran: full = lunas semua, cicilan = bayar sebagian
            $table->enum('jenis_pembayaran', ['full', 'cicilan'])->default('full');

            $table->decimal('jumlah_bayar', 15, 2); // jumlah yang dibayar
            $table->date('tanggal_bayar'); // tanggal mitra melakukan pembayaran

            // Bukti pembayaran
            $table->string('bukti_bayar')->nullable(); // path file gambar
            $table->string('nama_pengirim')->nullable(); // nama yang transfer
            $table->string('bank_pengirim')->nullable(); // bank asal transfer
            $table->text('catatan')->nullable(); // catatan tambahan dari mitra

            // Status verifikasi dari admin: pending, diterima, ditolak
            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])
                ->default('pending');
            $table->text('alasan_ditolak')->nullable(); // jika ditolak, alasannya apa
            $table->timestamp('tanggal_verifikasi')->nullable(); // kapan admin verifikasi
            $table->foreignId('verified_by')->nullable() // admin yang verifikasi
                ->constrained('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
