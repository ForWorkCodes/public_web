<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiJsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Проверяем, если запрос к API
        if ($request->is('api/*')) {
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}
