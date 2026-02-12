<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
        'curso',
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
