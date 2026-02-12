<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'dia',
    ];

    public function faltas()
    {
        return $this->hasMany(Falta::class);
    } 

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    } 

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    } 

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function franja()
    {
        return $this->belongsTo(Franja::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    
}
