<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';

    protected $fillable = [
        'penilai',
        'pegawai_id',
        'tanggal_penilaian',
        'kebersihan',
        'keindahan',
        'kerapian',
        'penampilan',
        'total_nilai',
        'tanggal_awal_mingguan',
        'tanggal_awal_triwulanan'
    ];
}
