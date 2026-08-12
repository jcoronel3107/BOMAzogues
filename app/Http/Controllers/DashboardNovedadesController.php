<?php

namespace App\Http\Controllers;

use App\EstacionNovedad;
use App\EstacionEmergencia;
use App\Station;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardNovedadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:ver novedades');
    }

    public function index()
    {
        // 1. Total de novedades
        $totalNovedades = EstacionNovedad::count();
        
        // 2. Novedades por estado
        $novedadesPorEstado = EstacionNovedad::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get()
            ->pluck('total', 'estado')
            ->toArray();
        
        // 3. Novedades por estación
        $novedadesPorEstacion = EstacionNovedad::select('estacion_id', DB::raw('count(*) as total'))
            ->with('estacion')
            ->groupBy('estacion_id')
            ->get()
            ->map(function($item) {
                return [
                    'estacion' => $item->estacion->nombre ?? 'N/A',
                    'total' => $item->total
                ];
            });
        
        // 4. Novedades por mes (últimos 12 meses)
        $novedadesPorMes = EstacionNovedad::select(
                DB::raw('YEAR(fecha) as año'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('count(*) as total')
            )
            ->where('fecha', '>=', now()->subMonths(12))
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->get()
            ->map(function($item) {
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                return [
                    'mes' => $meses[$item->mes - 1] . ' ' . $item->año,
                    'total' => $item->total
                ];
            });
        
        // 5. Total de emergencias atendidas
        $totalEmergencias = EstacionEmergencia::count();
        
        // 6. Tipos de emergencias más comunes
        $tiposEmergencias = EstacionEmergencia::select('tipo_emergencia', DB::raw('count(*) as total'))
            ->groupBy('tipo_emergencia')
            ->orderBy('total', 'desc')
            ->get();
        
        // 7. Total de personal registrado en novedades
        $totalPersonal = DB::table('estacion_personal')->count();
        
        // 8. Total de vehículos con novedades
        $totalVehiculos = DB::table('estacion_vehiculos')->count();
        
        // 9. Estados de vehículos
        $estadosVehiculos = DB::table('estacion_vehiculos')
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();
        
        // 10. Últimas 10 novedades
        $ultimasNovedades = EstacionNovedad::with(['estacion', 'usuarioElabora'])
            ->latest()
            ->limit(10)
            ->get();
        
        return view('dashboard.novedades', compact(
            'totalNovedades',
            'novedadesPorEstado',
            'novedadesPorEstacion',
            'novedadesPorMes',
            'totalEmergencias',
            'tiposEmergencias',
            'totalPersonal',
            'totalVehiculos',
            'estadosVehiculos',
            'ultimasNovedades'
        ));
    }

    // Datos para gráficos (API)
    public function getChartData()
    {
        $novedadesPorMes = EstacionNovedad::select(
                DB::raw('YEAR(fecha) as año'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('count(*) as total')
            )
            ->where('fecha', '>=', now()->subMonths(12))
            ->groupBy('año', 'mes')
            ->orderBy('año', 'asc')
            ->orderBy('mes', 'asc')
            ->get()
            ->map(function($item) {
                $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return [
                    'mes' => $meses[$item->mes - 1] . ' ' . $item->año,
                    'total' => $item->total
                ];
            });

        return response()->json([
            'novedadesPorMes' => $novedadesPorMes,
        ]);
    }
}