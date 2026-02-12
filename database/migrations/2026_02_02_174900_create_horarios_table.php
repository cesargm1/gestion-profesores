<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            $table->string('dia');

            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('asignatura_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grupo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('aula_id')->constrained()->cascadeOnDelete();
            $table->foreignId('franja_id')->constrained('franjas')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
