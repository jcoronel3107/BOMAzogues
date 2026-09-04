<?php

namespace App\Helpers;

use App\User;

class EstacionHelper
{
    public static function getEstacionesPermitidas()
    {
        $user = auth()->user();
        
        if (!$user) {
            return collect();
        }
        
        if ($user->station_id) {
            return \App\Station::where('id', $user->station_id)->get();
        }
        
        // Super-Admin o Admin ven todas
        if ($user->hasRole(['Super-Admin', 'Admin'])) {
            return \App\Station::all();
        }
        
        return collect();
    }
    
    public static function usuarioPerteneceAEstacion($estacion_id)
    {
        $user = auth()->user();
        if (!$user || !$user->station_id) {
            return false;
        }
        return $user->station_id == $estacion_id;
    }
}