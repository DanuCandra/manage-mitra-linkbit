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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'mitra'])->default('mitra')->after('password');
            $table->string('nama_lengkap')->nullable()->after('role');
            $table->string('no_hp')->nullable()->after('nama_lengkap');
            $table->enum('status', ['aktif', 'tidak-aktif'])->default('aktif')->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nama_lengkap', 'no_hp', 'status']);
        });
    }
};
