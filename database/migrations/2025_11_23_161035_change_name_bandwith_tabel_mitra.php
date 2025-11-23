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
            // Rename column dari 'bandwith' ke 'bandwidth'
            $table->renameColumn('bandwith', 'bandwidth');
        });
    }

    public function down(): void
    {
        Schema::table('mitra', function (Blueprint $table) {
            // Kembalikan ke nama lama jika rollback
            $table->renameColumn('bandwidth', 'bandwith');
        });
    }
};
