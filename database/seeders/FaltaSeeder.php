<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Falta;

class FaltaSeeder extends Seeder
{
    public function run(): void
    {
        Falta::factory()->count(30)->create();
    }
}
