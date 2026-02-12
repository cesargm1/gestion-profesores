<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franja extends Model
{
    use HasFactory;

    protected $table = 'franjas';

    protected $fillable = [
        'inicio',
        'final',
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
