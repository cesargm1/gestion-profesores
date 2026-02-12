<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Asignatura;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\Franja;

class HorarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'dia' => $this->faker->randomElement([
                'Lunes','Martes','Miercoles','Jueves','Viernes',
            ]),
        
            'usuario_id' => Usuario::factory(),
            'asignatura_id' => Asignatura::factory(),
            'grupo_id' => Grupo::factory(),
            'aula_id' => Aula::factory(),
            'franja_id' => Franja::factory(),
        ];
    }
}
