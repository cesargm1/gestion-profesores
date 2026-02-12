<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GrupoFactory extends Factory
{
    public function definition(): array
    {
        $curso = $this->faker->randomElement([1, 2]);

        $longitud = $this->faker->numberBetween(3, 4);

        $siglas = strtoupper($this->faker->lexify(str_repeat('?', $longitud)));

        return [
            'curso' => $curso,
            'nombre' => $curso . $siglas,
        ];
    }
}
