<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class FranjaFactory extends Factory
{
    public function definition(): array
    {
        $inicio = Carbon::createFromTime(
            $this->faker->numberBetween(8, 18),
            $this->faker->randomElement([0, 30]),
            0
        );

        $duracion = $this->faker->numberBetween(50, 120);

        $final = (clone $inicio)->addMinutes($duracion);

        return [
            'inicio' => $inicio->format('H:i:s'),
            'final'  => $final->format('H:i:s'),
        ];
    }
}
