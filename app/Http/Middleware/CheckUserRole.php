<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Kick them to login if they aren't authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Compare the user's role column to the route requirement parameter
        if (auth()->user()->role !== $role) {
            // If an Admin tries to open the Guard Terminal, let them pass or redirect gracefully
            if ($role === 'guard' && auth()->user()->role === 'admin') {
                return $next($request); // Optional: Let admins see the terminal if desired
            }

            // Otherwise block access with an explicit unauthorized message or redirect
            return response()->view('welcome', [], 403)->with('error', 'Unauthorized access profile clearance.');
        }

        return $next($request);
    }
}
