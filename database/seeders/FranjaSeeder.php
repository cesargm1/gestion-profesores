<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Franja;

class FranjaSeeder extends Seeder
{
    public function run(): void
    {
        Franja::factory()->count(12)->create();
    }
}
