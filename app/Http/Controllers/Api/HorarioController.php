<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        return response()->json(
            Horario::with(['asignatura', 'grupo', 'aula', 'franja', 'usuario'])->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grupo_id' => 'required|exists:grupos,id',
            'aula_id' => 'required|exists:aulas,id',
            'franja_id' => 'required|exists:franjas,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'dia_semana' => 'required|string',
        ]);

        $horario = Horario::create($validated);

        return response()->json($horario->load(['asignatura', 'grupo', 'aula', 'franja', 'usuario']), 201);
    }

    public function show($id)
    {
        return response()->json(
            Horario::with(['asignatura', 'grupo', 'aula', 'franja', 'usuario'])
                ->findOrFail($id)
        );
    }

    public function porUsuario($usuarioId)
    {
        return Horario::where('usuario_id', $usuarioId)->get();
    }

    public function update(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);

        $validated = $request->validate([
            'asignatura_id' => 'sometimes|required|exists:asignaturas,id',
            'grupo_id' => 'sometimes|required|exists:grupos,id',
            'aula_id' => 'sometimes|required|exists:aulas,id',
            'franja_id' => 'sometimes|required|exists:franjas,id',
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
            'dia_semana' => 'sometimes|required|string',
        ]);

        $horario->update($validated);

        return response()->json(
            $horario->load(['asignatura', 'grupo', 'aula', 'franja', 'usuario'])
        );
    }

    public function destroy($id)
    {
        Horario::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
