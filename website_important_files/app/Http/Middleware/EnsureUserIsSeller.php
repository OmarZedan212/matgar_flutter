<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSeller
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user(); // same as auth()->user()
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->seller) {
            return redirect()->route('seller.settings');
        }

        return $next($request);
    }
}
