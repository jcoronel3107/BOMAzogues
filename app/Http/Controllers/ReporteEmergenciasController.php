<?php

namespace App\Http\Controllers;

use App\Emergencia;
use App\Incidente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteEmergenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $incidentes = Incidente::orderBy('nombre_incidente')->get();
        return view('reportes.emergencias', compact('incidentes'));
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ]);

        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;

        // Datos para el gráfico de pizza
        $datosGrafico = Incidente::select(
                'incidentes.id',
                'incidentes.nombre_incidente',
                DB::raw('COUNT(emergencias.id) as total')
            )
            ->leftJoin('emergencias', function($join) use ($fechaDesde, $fechaHasta) {
                $join->on('incidentes.id', '=', 'emergencias.tipo_incidente_id')
                    ->whereBetween('emergencias.fecha', [$fechaDesde, $fechaHasta]);
            })
            ->groupBy('incidentes.id', 'incidentes.nombre_incidente')
            ->orderByDesc('total')
            ->get();

        // Detalle de emergencias
        $emergencias = Emergencia::with(['tipoIncidente', 'estacion', 'parroquia'])
            ->whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->orderBy('fecha', 'desc')
            ->get();

        // Estadísticas adicionales
        $totalEmergencias = $emergencias->count();
        $totalEstaciones = $emergencias->groupBy('estacion_id')->count();
        $totalParroquias = $emergencias->groupBy('parroquia_id')->count();

        // Datos para el gráfico de barras (emergencias por día)
        $datosBarras = Emergencia::select(
                DB::raw('DATE(fecha) as fecha'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->groupBy(DB::raw('DATE(fecha)'))
            ->orderBy(DB::raw('DATE(fecha)'), 'asc')
            ->get();

        // Colores para el gráfico de pizza
        $colores = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', 
            '#e74a3b', '#858796', '#5a5c69', '#f8f9fc',
            '#d1d3e2', '#bac8f3', '#6f42c1', '#fd7e14',
            '#20c997', '#e83e8c', '#007bff', '#28a745'
        ];

        return view('reportes.emergencias-resultados', compact(
            'datosGrafico',
            'emergencias',
            'totalEmergencias',
            'totalEstaciones',
            'totalParroquias',
            'fechaDesde',
            'fechaHasta',
            'datosBarras',
            'colores'
        ));
    }

    // Exportar a PDF
    public function exportPdf(Request $request)
    {
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ]);

        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;

        $emergencias = Emergencia::with(['tipoIncidente', 'estacion', 'parroquia'])
            ->whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->orderBy('fecha', 'desc')
            ->get();

        $totalEmergencias = $emergencias->count();

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);

        // Título
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(180, 10, 'REPORTE DE EMERGENCIAS', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(180, 8, 'Periodo: ' . date('d/m/Y', strtotime($fechaDesde)) . ' al ' . date('d/m/Y', strtotime($fechaHasta)), 0, 1, 'C');
        $pdf->Ln(5);

        // Resumen
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(180, 8, 'RESUMEN', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(60, 8, 'Total Emergencias: ' . $totalEmergencias, 0, 1);

        // Tabla de emergencias
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 7, 'ID', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Fecha', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Incidente', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Estación', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Parroquia', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 9);
        foreach ($emergencias as $emergencia) {
            $pdf->Cell(20, 6, $emergencia->id, 1, 0, 'C');
            $pdf->Cell(30, 6, $emergencia->fecha->format('d/m/Y'), 1, 0, 'C');
            $pdf->Cell(50, 6, $emergencia->tipoIncidente->nombre_incidente ?? 'N/A', 1, 0, 'L');
            $pdf->Cell(40, 6, $emergencia->estacion->nombre ?? 'N/A', 1, 0, 'L');
            $pdf->Cell(40, 6, $emergencia->parroquia->nombre ?? 'N/A', 1, 1, 'L');
        }

        $pdf->Output('D', 'reporte_emergencias_' . date('Y-m-d') . '.pdf');
        exit;
    }
}