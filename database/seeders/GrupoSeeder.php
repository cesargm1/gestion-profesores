<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        Grupo::factory()->count(12)->create();
    }
}
