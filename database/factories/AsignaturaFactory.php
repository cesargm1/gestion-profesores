<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AsignaturaFactory extends Factory
{
    public function definition(): array
    {
        $nombre = ucfirst(implode(' ', $this->faker->words($this->faker->numberBetween(1, 3))));
        return ['nombre' => $nombre,];
    }
}
