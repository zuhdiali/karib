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
        Schema::create('talak', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan');
            $table->string('file_banner')->nullable();
            $table->date('tgl_penilaian')->nullable();
            $table->timestamps();
        });

        Schema::create('nominasi_talak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_talak')->constrained('talak')->onDelete('cascade');
            $table->foreignId('id_pegawai')->constrained('pegawais')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('penilaian_talak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penilai')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('id_nominasi')->constrained('nominasi_talak')->onDelete('cascade');
            $table->unsignedTinyInteger('orientasi_layanan')->nullable();
            $table->unsignedTinyInteger('akuntabel')->nullable();
            $table->unsignedTinyInteger('kompeten')->nullable();
            $table->unsignedTinyInteger('harmonis')->nullable();
            $table->unsignedTinyInteger('loyal')->nullable();
            $table->unsignedTinyInteger('adaptif')->nullable();
            $table->unsignedTinyInteger('kolaboratif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_talak');
        Schema::dropIfExists('nominasi_talak');
        Schema::dropIfExists('talak');
    }
};
