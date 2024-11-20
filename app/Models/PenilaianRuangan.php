<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianRuangan extends Model
{
    use HasFactory;

    protected $table = 'penilaian_ruangans';
    protected $fillable = [
        'penilai',
        'ruangan_id',
        'tanggal_penilaian',
        'kebersihan',
        'keindahan',
        'kerapian',
        'penampilan',
        'total_nilai',
        'tanggal_awal_mingguan'
    ];
}
