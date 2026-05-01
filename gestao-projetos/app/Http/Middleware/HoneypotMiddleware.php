<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HoneypotMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Se o campo 'address_secondary' estiver preenchido, é um bot
        if ($request->filled('address_secondary')) {
            // Resposta Honeypot: Retornamos sucesso falso ou erro silencioso
            // para não dar pistas ao atacante
            return response()->json(['message' => 'Processado com sucesso'], 200);
        }

        return $next($request);
    }
}
