<?php

namespace App\Http\Controllers;

use App\Emergencia;
use App\EmergenciaPrehospitalaria;
use App\EmergenciaFuego;
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

        // ===== ESTADÍSTICAS GENERALES =====
        $totalEmergencias = Emergencia::count();
        $totalNovedades = EstacionNovedad::count();
        $totalEstaciones = Station::count();
        $totalUsuarios = User::count();

        // ===== EMERGENCIAS DE HOY =====
        $emergenciasHoy = Emergencia::whereDate('fecha', today())->count();
        $novedadesHoy = EstacionNovedad::whereDate('fecha', today())->count();

        // ===== EMERGENCIAS PREHOSPITALARIAS =====
        $totalEmergenciasPrehospitalarias = EmergenciaPrehospitalaria::count();
        $emergenciasPrehospitalariasHoy = EmergenciaPrehospitalaria::whereDate('fecha_salida', today())->count();

        // ===== EMERGENCIAS DE FUEGO =====
        $totalEmergenciasFuego = EmergenciaFuego::count();
        $emergenciasFuegoHoy = EmergenciaFuego::whereDate('fecha_salida', today())->count();

        // ===== ÚLTIMAS 5 EMERGENCIAS =====
        $ultimasEmergencias = Emergencia::with(['tipoIncidente', 'estacion'])
            ->latest()
            ->limit(5)
            ->get();

        // ===== ÚLTIMAS 5 NOVEDADES =====
        $ultimasNovedades = EstacionNovedad::with(['estacion', 'usuarioElabora'])
            ->latest()
            ->limit(5)
            ->get();

        return view('welcome', compact(
            'user',
            'totalEmergencias',
            'totalNovedades',
            'totalEstaciones',
            'totalUsuarios',
            'emergenciasHoy',
            'novedadesHoy',
            'totalEmergenciasPrehospitalarias',
            'emergenciasPrehospitalariasHoy',
            'totalEmergenciasFuego',
            'emergenciasFuegoHoy',
            'ultimasEmergencias',
            'ultimasNovedades'
        ));
    }
}