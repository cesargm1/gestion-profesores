<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Horario;

class FaltaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'horario_id' => Horario::factory(),
            'mensaje' => $this->faker->sentence(),
            'cubierta' => $this->faker->boolean(),
            'fecha' => $this->faker->date(),
        ];
    }
}
