<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'rol' => $this->faker->randomElement([
                'admin',
                'profesor',
            ]),
        ];
    }
}
