<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleIs
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!session()->has('user_rol') || session('user_rol') !== $role) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder aquí.');
        }
        return $next($request);
    }
}
