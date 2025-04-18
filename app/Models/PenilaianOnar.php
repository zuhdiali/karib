<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianOnar extends Model
{
    use HasFactory;
    protected $table = 'penilaian_onar';

    protected $fillable = [
        'id_penilai',
        'id_nominasi',
        'tanggung_jawab',
        'disiplin',
        'loyal',
        'ramah',
        'melayani',
        'cekatan',
    ];

    public function penilai()
    {
        return $this->belongsTo(Pegawai::class, 'id_penilai', 'id');
    }
    public function nominasiOnar()
    {
        return $this->belongsTo(NominasiOnar::class, 'id_nominasi', 'id');
    }
}
