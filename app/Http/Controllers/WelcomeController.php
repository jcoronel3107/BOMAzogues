<?php

namespace App\Http\Controllers;

use App\Emergencia;
use App\EstacionNovedad;
use App\Station;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Estadísticas generales
        $totalEmergencias = Emergencia::count();
        $totalNovedades = EstacionNovedad::count();
        $totalEstaciones = Station::count();
        $totalUsuarios = User::count();
        
        // Últimas 5 emergencias
        $ultimasEmergencias = Emergencia::with(['tipoIncidente', 'estacion'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Últimas 5 novedades
        $ultimasNovedades = EstacionNovedad::with(['estacion', 'usuarioElabora'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Emergencias de hoy
        $emergenciasHoy = Emergencia::whereDate('fecha', today())->count();
        
        // Novedades de hoy
        $novedadesHoy = EstacionNovedad::whereDate('fecha', today())->count();
        
        return view('welcome', compact(
            'user',
            'totalEmergencias',
            'totalNovedades',
            'totalEstaciones',
            'totalUsuarios',
            'ultimasEmergencias',
            'ultimasNovedades',
            'emergenciasHoy',
            'novedadesHoy'
        ));
    }
}