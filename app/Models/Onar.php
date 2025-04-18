<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onar extends Model
{
    use HasFactory;

    protected $table = 'onar';
    protected $fillable = [
        'nama',
        'tahun',
        'triwulan',
        'file_banner',
        'tgl_penilaian',
    ];

    public function nominasiOnar()
    {
        return $this->belongsToMany(NominasiOnar::class, 'nominasi_onar', 'id_onar', 'id_outsourcing')
            ->withPivot('id_outsourcing');
    }
}
