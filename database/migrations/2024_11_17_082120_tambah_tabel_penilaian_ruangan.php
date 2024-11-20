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
        Schema::create('penilaian_ruangans', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('penilai');
            $table->tinyInteger('ruangan_yang_dinilai');
            $table->date('tanggal_penilaian');
            $table->tinyInteger('kebersihan');
            $table->tinyInteger('keindahan');
            $table->tinyInteger('kerapian');
            $table->tinyInteger('penampilan');
            $table->tinyInteger('total_nilai');
            $table->date('tanggal_awal_mingguan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_ruangans');
    }
};
