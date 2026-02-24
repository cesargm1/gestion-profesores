<?php
namespace App\Http\Middleware;

    class Authenticate extends Middleware
    {
    protected function redirectTo($request)
    {
    /* if (! $request->expectsJson())
    {
    return route('login’);
    } */
    }
    }