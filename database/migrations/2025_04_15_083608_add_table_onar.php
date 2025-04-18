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
        Schema::create('outsourcing', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('flag')->nullable();
            $table->timestamps();
        });

        Schema::create('onar', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan');
            $table->string('file_banner')->nullable();
            $table->date('tgl_penilaian')->nullable();
            $table->timestamps();
        });

        Schema::create('nominasi_onar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_onar')->constrained('onar')->onDelete('cascade');
            $table->foreignId('id_outsourcing')->constrained('outsourcing')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('penilaian_onar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penilai')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('id_nominasi')->constrained('nominasi_onar')->onDelete('cascade');
            $table->unsignedTinyInteger('tanggung_jawab')->nullable();
            $table->unsignedTinyInteger('disiplin')->nullable();
            $table->unsignedTinyInteger('loyal')->nullable();
            $table->unsignedTinyInteger('ramah')->nullable();
            $table->unsignedTinyInteger('melayani')->nullable();
            $table->unsignedTinyInteger('cekatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outsourcing');
        Schema::dropIfExists('penilaian_onar');
        Schema::dropIfExists('nominasi_onar');
        Schema::dropIfExists('onar');
    }
};
