<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu ya!');
        }

        if (Auth::user()->role !== 'owner') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun kamu bukan owner!');
        }

        return $next($request);
    }
}
