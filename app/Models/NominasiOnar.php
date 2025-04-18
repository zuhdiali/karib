<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominasiOnar extends Model
{
    use HasFactory;

    protected $table = 'nominasi_onar';
    protected $fillable = [
        'id_onar',
        'id_outsourcing',
    ];

    public function onar()
    {
        return $this->belongsTo(Onar::class, 'id_onar', 'id');
    }
    public function outsourcing()
    {
        return $this->belongsTo(Outsourcing::class, 'id_outsourcing', 'id');
    }
}
