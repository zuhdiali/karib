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
        Schema::table('penilaian_ruangans', function (Blueprint $table) {
            $table->renameColumn('ruangan_yang_dinilai', 'ruangan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_ruangans', function (Blueprint $table) {
            $table->renameColumn('ruangan_id', 'ruangan_yang_dinilai');
        });
    }
};
