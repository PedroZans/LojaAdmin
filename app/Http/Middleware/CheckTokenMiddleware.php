<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        // Rotas que não exigem token
        $excecoes = [
        'v1/ibge/municipios-rj',
        'v1/ibge/municipios',
        'produtos', // GET index
        'produtos/*' // Adicionei para testes
    ];
            // DEBUG: Logs para verificação 
                dd([
                    'header' => $request->header('X-Car-Token'),
                    'server' => $request->server('HTTP_X_CAR_TOKEN'),
                    'method' => $request->method(),
                    'path' => $request->path()
                    ]);

        // Se for uma rota isenta, libera sem exigir token
        if (in_array($request->path(), $excecoes)) {
            return $next($request);
        }

        // Leitura segura do token do cabeçalho (evita problemas com headers personalizados)
        $token = $request->server('HTTP_X_CAR_TOKEN');

        // Token esperado
        $tokenValido = 'Ph!15102003';

        if ($token !== $tokenValido) {
            return response()->json(['message' => 'Token inválido'], 403);
        }

        return $next($request);
    }
}
