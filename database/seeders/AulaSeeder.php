<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulaSeeder extends Seeder
{
    public function run(): void
    {
        Aula::factory()->count(30)->create();
    }
}
