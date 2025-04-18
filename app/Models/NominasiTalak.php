<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominasiTalak extends Model
{
    use HasFactory;

    protected $table = 'nominasi_talak';
    protected $fillable = [
        'id_talak',
        'id_pegawai',
    ];

    public function talak()
    {
        return $this->belongsTo(Talak::class, 'id_talak', 'id');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }
}
