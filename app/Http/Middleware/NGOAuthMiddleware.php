<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\NGOVolunteer;
use Symfony\Component\HttpFoundation\Response;

class NGOAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If server session has the NGO user, allow through
        if (session()->has('ngo')) {
            return $next($request);
        }

        // 2. If session is gone but "Keep me logged in" cookie exists, restore the session
        if (Cookie::has('resqmeal_ngo_email')) {
            $email = Cookie::get('resqmeal_ngo_email');
            $ngo = NGOVolunteer::where('email', $email)->first();
            if ($ngo) {
                session(['ngo' => $ngo]);
                return $next($request);
            }
        }

        // 3. Not authenticated — send to NGO login
        return redirect('/ngo-login');
    }
}
