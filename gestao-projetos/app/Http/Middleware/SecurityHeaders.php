<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle( $request, Closure $next)
    {
        $response = $next($request);

        // Define que imagens e scripts só podem vir do próprio domínio
        $response->headers->set('Content-Security-Policy', "default-src 'self'; img-src 'self' data:;");
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
