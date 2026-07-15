<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRefererMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $referer = $request->header('referer');

        // Check if referer is empty or does not contain the app's host
        if (!$referer || !str_contains($referer, $request->getHost())) {
            abort(403, 'Access denied. Direct URL entry is not allowed.');
        }

        return $next($request);
    }
}
