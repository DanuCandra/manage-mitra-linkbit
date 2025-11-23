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
        Schema::table('mitra', function (Blueprint $table) {
            // Ubah column bandwidth dari string ke integer (unsigned)
            // PENTING: Pastikan data existing sudah numeric atau kosong
            $table->unsignedInteger('bandwidth')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            // Kembalikan ke string jika rollback
            $table->string('bandwidth')->nullable()->change();
        });
    }
};
