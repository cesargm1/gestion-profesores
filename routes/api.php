<?php
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Api\AsignaturaController;
use App\Http\Controllers\Api\AulaController;
use App\Http\Controllers\Api\FaltaController;
use App\Http\Controllers\Api\FranjaController;
use App\Http\Controllers\Api\GrupoController;
use App\Http\Controllers\Api\HorarioController;
use App\Http\Controllers\Api\UsuarioController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', fn(Request $request) => $request->user());
});

Route::get(
    'usuarios/{usuario}/horarios',
    [HorarioController::class, 'porUsuario']
);

Route::get('faltas/por-fecha', [FaltaController::class, 'porFecha']);

Route::apiResource('asignaturas', AsignaturaController::class);
Route::apiResource('aulas', AulaController::class);
Route::apiResource('faltas', FaltaController::class);
Route::apiResource('franjas', FranjaController::class);
Route::apiResource('grupos', GrupoController::class);
Route::apiResource('horarios', HorarioController::class);
Route::apiResource('usuarios', UsuarioController::class);
