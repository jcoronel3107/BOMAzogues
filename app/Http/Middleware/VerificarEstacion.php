<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarEstacion
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Si el usuario no tiene estación asignada, redirigir
        if (!$user || !$user->station_id) {
            return redirect()->route('home')
                ->with('error', 'No tienes una estación asignada. Contacta al administrador.');
        }
        
        return $next($request);
    }
}