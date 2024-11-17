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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('penilai', 20);
            $table->string('pegawai_yang_dinilai', 50);
            $table->date('tanggal_penilaian')->default(date('Y-m-d'));
            $table->tinyInteger('kebersihan');
            $table->tinyInteger('keindahan');
            $table->tinyInteger('kerapian');
            $table->tinyInteger('penampilan');
            $table->tinyInteger('total_nilai');
            $table->date('tanggal_awal_mingguan');
            $table->date('tanggal_awal_triwulanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
