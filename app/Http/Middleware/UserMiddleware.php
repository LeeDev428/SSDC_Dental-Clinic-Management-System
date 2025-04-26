<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and is a regular user
        if (Auth::check() && Auth::user()->usertype === 'user') {
            return $next($request); // Proceed if the user is a regular user
        }

        // Redirect if the user is not a regular user
        return redirect('/')->with('error', 'You do not have user access.');
    }
}
