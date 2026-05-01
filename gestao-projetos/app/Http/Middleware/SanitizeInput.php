<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        // Percorre todos os inputs e remove tags HTML/Scripts perigosos
        array_walk_recursive($input, function (&$item) {
            if (is_string($item)) {
                $item = strip_tags($item); // Remove tags HTML
                $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            }
        });

        $request->merge($input);

        return $next($request);
    }
}