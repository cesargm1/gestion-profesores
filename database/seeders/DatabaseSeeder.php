<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    
    public function run(): void
    {
        $this->call([
            AsignaturaSeeder::class,
            AulaSeeder::class,
            FranjaSeeder::class,
            GrupoSeeder::class,
            UsuarioSeeder::class,
            HorarioSeeder::class,
            FaltaSeeder::class,
        ]);
    }
}
