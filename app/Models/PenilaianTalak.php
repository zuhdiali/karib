<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTalak extends Model
{
    use HasFactory;

    protected $table = 'penilaian_talak';

    protected $fillable = [
        'id_penilai',
        'id_nominasi',
        'orientasi_layanan',
        'akuntabel',
        'kompeten',
        'harmonis',
        'loyal',
        'adaptif',
        'kolaboratif',
    ];

    public function penilai()
    {
        return $this->belongsTo(Pegawai::class, 'id_penilai', 'id');
    }
    public function nominasiTalak()
    {
        return $this->belongsTo(NominasiTalak::class, 'id_nominasi', 'id');
    }
}
