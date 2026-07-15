<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Donor;
use Symfony\Component\HttpFoundation\Response;

class DonorAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If session has donor, user is logged in
        if (session()->has('donor')) {
            return $next($request);
        }

        // 2. If no session, but 'Keep me logged in' cookie exists, restore session
        if (Cookie::has('resqmeal_donor_email')) {
            $email = Cookie::get('resqmeal_donor_email');
            $donor = Donor::where('email', $email)->first();
            if ($donor) {
                session(['donor' => $donor]);
                return $next($request);
            }
        }

        // 3. Otherwise, redirect to login
        return redirect('/login');
    }
}
