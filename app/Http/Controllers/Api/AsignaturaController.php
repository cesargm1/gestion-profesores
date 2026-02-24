<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function index()
    {
        return response()->json(Asignatura::all());
    }

    public function store(Request $request)
    {
        $asignatura = Asignatura::create($request->all());

        return response()->json($asignatura, 201);
    }

    public function show($id)
    {
        $asignatura = Asignatura::findOrFail($id);

        return response()->json($asignatura);
    }

    public function update(Request $request, $id)
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->update($request->all());

        return response()->json($asignatura);
    }

    public function destroy($id)
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->delete();

        return response()->json(null, 204);
    }
}
