<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Franja;
use Illuminate\Http\Request;

class FranjaController extends Controller
{
    public function index()
    {
        return response()->json(Franja::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $franja = Franja::create($validated);

        return response()->json($franja, 201);
    }

    public function show($id)
    {
        return response()->json(Franja::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $franja = Franja::findOrFail($id);

        $validated = $request->validate([
            'hora_inicio' => 'sometimes|required|date_format:H:i',
            'hora_fin' => 'sometimes|required|date_format:H:i|after:hora_inicio',
        ]);

        $franja->update($validated);

        return response()->json($franja);
    }

    public function destroy($id)
    {
        Franja::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
