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
        Schema::create('account_bank', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_bank'); // BCA, Mandiri, BNI, dll
            $table->string('nomor_rekening');
            $table->string('atas_nama');
            $table->enum('status', ['aktif', 'tidak-aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_bank');
    }
};
