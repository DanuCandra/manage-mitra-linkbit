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
        Schema::create('mitra', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // jika user dihapus, mitra ikut terhapus

            $table->string('nama_mitra');
            $table->string('nik')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('npwp')->nullable();
            $table->text('alamat')->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->string('nama_brand')->nullable();
            $table->string('no_nib')->nullable();
            $table->string('no_sertif_standar')->nullable();
            $table->string('tikor')->nullable();
            $table->string('bandwith')->nullable();
            $table->integer('jml_karyawan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
