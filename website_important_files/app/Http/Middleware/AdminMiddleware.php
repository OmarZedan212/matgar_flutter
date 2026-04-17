<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); 

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->is_admin) {
            return redirect()->route('seller.dashboard');
        }

        return $next($request);
    }
}
