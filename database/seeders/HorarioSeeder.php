<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        Horario::factory()->count(50)->create();
    }
}
