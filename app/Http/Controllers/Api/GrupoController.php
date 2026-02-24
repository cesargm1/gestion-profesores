<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        return response()->json(Grupo::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $grupo = Grupo::create($validated);

        return response()->json($grupo, 201);
    }

    public function show($id)
    {
        return response()->json(Grupo::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
        ]);

        $grupo->update($validated);

        return response()->json($grupo);
    }

    public function destroy($id)
    {
        Grupo::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
