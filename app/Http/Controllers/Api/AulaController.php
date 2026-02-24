<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        return response()->json(Aula::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
        ]);

        $aula = Aula::create($validated);

        return response()->json($aula, 201);
    }

    public function show($id)
    {
        return response()->json(Aula::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $aula = Aula::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'capacidad' => 'sometimes|required|integer|min:1',
        ]);

        $aula->update($validated);

        return response()->json($aula);
    }

    public function destroy($id)
    {
        Aula::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
