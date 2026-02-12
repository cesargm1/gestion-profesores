<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AulaFactory extends Factory
{
    public function definition(): array
    {
        $palabra = ucfirst($this->faker->lexify('????'));
        $numero = str_pad($this->faker->numberBetween(1, 500), 3, '0', STR_PAD_LEFT);

        return ['nombre' => $palabra . $numero,];
    }
}
