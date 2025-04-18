<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talak extends Model
{
    use HasFactory;

    protected $table = 'talak';
    protected $fillable = [
        'nama',
        'tahun',
        'triwulan',
        'file_banner',
        'tgl_penilaian',
    ];

    public function nominasiTalak()
    {
        return $this->belongsToMany(NominasiTalak::class, 'nominasi_talak', 'id_talak', 'id_pegawai')
            ->withPivot('id_pegawai');
    }
}
