<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(Usuario::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $usuario = Usuario::create($validated);

        return response()->json($usuario, 201);
    }

    public function show($id)
    {
        return response()->json(Usuario::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $usuario->update($validated);

        return response()->json($usuario);
    }

    public function destroy($id)
    {
        Usuario::findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    public function horarios($id)
    {
        $usuario = Usuario::findOrFail($id);

        $horarios = $usuario->horarios()
            ->with(['asignatura', 'grupo', 'aula', 'franja'])
            ->get();

        return response()->json($horarios);
    }

}
