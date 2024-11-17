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
        Schema::table('penilaians', function (Blueprint $table) {
            $table->tinyInteger('pegawai_yang_dinilai')->change();
            $table->renameColumn('pegawai_yang_dinilai', 'pegawai_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->string('pegawai_id')->change();
            $table->renameColumn('pegawai_id', 'pegawai_yang_dinilai');
        });
    }
};
