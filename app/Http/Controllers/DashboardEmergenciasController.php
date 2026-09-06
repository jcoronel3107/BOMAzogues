<?php

namespace App\Http\Controllers;

use App\Emergencia;
use App\Station;
use App\Parroquia;
use App\Vehiculo;
use App\Incidente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardEmergenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. Estaciones con más emergencias
        $estacionesTop = Station::select('stations.id', 'stations.nombre', DB::raw('COUNT(emergencias.id) as total'))
            ->leftJoin('emergencias', 'stations.id', '=', 'emergencias.estacion_id')
            ->groupBy('stations.id', 'stations.nombre')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 2. Emergencias más repetidas (por tipo de incidente)
        $emergenciasMasRepetidas = Incidente::select('incidentes.id', 'incidentes.nombre_incidente', DB::raw('COUNT(emergencias.id) as total'))
            ->leftJoin('emergencias', 'incidentes.id', '=', 'emergencias.tipo_incidente_id')
            ->groupBy('incidentes.id', 'incidentes.nombre_incidente')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 3. Número de emergencias por parroquias
        $emergenciasPorParroquia = Parroquia::select('parroquias.id', 'parroquias.nombre', DB::raw('COUNT(emergencias.id) as total'))
            ->leftJoin('emergencias', 'parroquias.id', '=', 'emergencias.parroquia_id')
            ->groupBy('parroquias.id', 'parroquias.nombre')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 4. Vehículo que más atiende emergencias
        $vehiculosTop = Vehiculo::select('vehiculos.id', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', DB::raw('COUNT(emergencia_vehiculo.emergencia_id) as total'))
            ->leftJoin('emergencia_vehiculo', 'vehiculos.id', '=', 'emergencia_vehiculo.vehiculo_id')
            ->groupBy('vehiculos.id', 'vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 5. Estadísticas generales
        $totalEmergencias = Emergencia::count();
        $totalEstaciones = Station::count();
        $totalParroquias = Parroquia::count();
        $totalVehiculos = Vehiculo::count();
        $totalIncidentes = Incidente::count();

        // 6. Emergencias por mes (últimos 12 meses)
        $emergenciasPorMes = Emergencia::select(
                DB::raw('YEAR(fecha) as año'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('COUNT(*) as total')
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

        // 7. Últimas 10 emergencias
        $ultimasEmergencias = Emergencia::with(['tipoIncidente', 'estacion', 'parroquia'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.emergencias', compact(
            'estacionesTop',
            'emergenciasMasRepetidas',
            'emergenciasPorParroquia',
            'vehiculosTop',
            'totalEmergencias',
            'totalEstaciones',
            'totalParroquias',
            'totalVehiculos',
            'totalIncidentes',
            'emergenciasPorMes',
            'ultimasEmergencias'
        ));
    }

    // Datos para gráficos (API)
    public function getChartData()
    {
        // Datos para gráfico de barras: emergencias por mes
        $emergenciasPorMes = Emergencia::select(
                DB::raw('YEAR(fecha) as año'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('COUNT(*) as total')
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

        // Datos para gráfico de pastel: emergencias por tipo
        $emergenciasPorTipo = Incidente::select('incidentes.nombre_incidente', DB::raw('COUNT(emergencias.id) as total'))
            ->leftJoin('emergencias', 'incidentes.id', '=', 'emergencias.tipo_incidente_id')
            ->groupBy('incidentes.nombre_incidente')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json([
            'emergenciasPorMes' => $emergenciasPorMes,
            'emergenciasPorTipo' => $emergenciasPorTipo,
        ]);
    }
}