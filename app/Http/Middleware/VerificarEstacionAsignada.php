<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarEstacionAsignada
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Super-Admin y admin pueden pasar sin estación
        if ($user->hasRole('Super-Admin') || $user->hasRole('admin')) {
            return $next($request);
        }

        // Otros usuarios deben tener estación asignada
        if (!$user->station_id) {
            abort(403, 'No tienes una estación asignada. Contacta al administrador para que te asigne una.');
        }

        return $next($request);
    }
}