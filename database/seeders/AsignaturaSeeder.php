<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asignatura;

class AsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        Asignatura::factory()->count(10)->create();
    }
}
