<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCarToken
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o token existe no header
        if (!$request->header('X-Car-Token')) {
            return response()->json(['error' => 'Token não fornecido'], 401);
        }

        // Verifica se o token é válido
        if ($request->header('X-Car-Token') !== config('services.car.token')) {
            return response()->json(['error' => 'Token inválido'], 403);
        }

        return $next($request);
    }
}