<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login.form')->with('error', 'Inicia sesión para continuar.');
        }
        return $next($request);
    }
}
