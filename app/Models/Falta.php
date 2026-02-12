<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    use HasFactory;

    protected $table = 'faltas';

    protected $fillable = [
        'horario_id',
        'fecha',
        'cubierta',
        'mensaje',
    ];
    
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
