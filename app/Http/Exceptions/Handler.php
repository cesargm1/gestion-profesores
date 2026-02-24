<?php

namespace App\Http\Exceptions;

    use Illuminate\Auth\AuthenticationException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Validation\ValidationException;
    use Throwable;
    class Handler extends ExceptionHandler
    {
        public function register()
        {
            $this->renderable(function (Throwable $exception)
            {
                if (request()->is('api*'))
                {
                    if ($exception instanceof ModelNotFoundException)
                    return response()->json(
                    ['error' => 'Elemento no encontrado'], 404);
                    else if ($exception instanceof AuthenticationException)
                    return response()->json(
                    ['error' => 'Usuario no autenticado'], 401);
                    else if ($exception instanceof ValidationException)
                    return response()->json(
                    ['error' => 'Datos no válidos'], 400);
                    else if (isset($exception))
                    return response()->json(
                    ['error' => 'Error en la aplicación ( '.
                    get_class($exception) . '):' .
                    $exception->getMessage()], 500);
                    }
                });
            }
        } 