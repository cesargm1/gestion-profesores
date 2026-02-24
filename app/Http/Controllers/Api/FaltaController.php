<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Falta;
use Illuminate\Http\Request;

class FaltaController extends Controller
{
    public function index()
    {
        return response()->json(Falta::with(['usuario'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha' => 'required|date',
            'justificada' => 'required|boolean',
        ]);

        $falta = Falta::create($validated);

        return response()->json($falta, 201);
    }

    public function show($id)
    {
        return response()->json(Falta::with(['usuario'])->findOrFail($id));
    }

    public function porFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $faltas = Falta::with('usuario')
            ->whereDate('fecha', $request->fecha)
            ->get();

        return response()->json($faltas);
    }

    public function update(Request $request, $id)
    {
        $falta = Falta::findOrFail($id);

        $validated = $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
            'fecha' => 'sometimes|required|date',
            'justificada' => 'sometimes|required|boolean',
        ]);

        $falta->update($validated);

        return response()->json($falta);
    }

    public function destroy($id)
    {
        Falta::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
