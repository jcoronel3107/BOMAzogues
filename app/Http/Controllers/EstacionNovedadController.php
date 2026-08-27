<?php

namespace App\Http\Controllers;

use App\EstacionNovedad;
use App\EstacionEmergencia;
use App\EstacionVehiculo;
use App\EstacionPersonal;
use App\Station;
use App\User;
use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NovedadEnRevision;
use App\Notifications\NovedadAprobada;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class EstacionNovedadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:ver novedades')->only(['index', 'show']);
        $this->middleware('can:crear novedades')->only(['create', 'store']);
        $this->middleware('can:editar novedades')->only(['edit', 'update']);
        $this->middleware('can:eliminar novedades')->only(['destroy']);
        $this->middleware('can:revisar novedades')->only(['enviarRevision']);
        $this->middleware('can:aprobar novedades')->only(['aprobar']);
    }

    public function index()
{
    $novedades = EstacionNovedad::with(['estacion', 'usuarioElabora', 'usuarioRevisa', 'usuarioAprueba', 'usuarioRatifica'])
        ->latest()
        ->paginate(15);
    
    return view('estacion_novedades.index', compact('novedades'));
}

    public function create()
    {
        $estaciones = Station::all();
        $personal = User::all();
        $vehiculos = Vehiculo::all();
        
        return view('estacion_novedades.create', compact('estaciones', 'personal', 'vehiculos'));
    }

    public function store(Request $request)
    {
         $request->validate([
        'fecha' => 'required|date',
        'estacion_id' => 'required|exists:stations,id',
        'observaciones' => 'nullable|string',
        ]);

        $novedad = EstacionNovedad::create([
        'fecha' => $request->fecha,
        'estacion_id' => $request->estacion_id,
        'usuario_elabora_id' => Auth::id(),
        'usuario_crea_id' => Auth::id(),
        'estado' => 'elaboracion',
        'fecha_elaboracion' => now(),
        'fecha_creacion' => now(),
        'observaciones' => $request->observaciones,
        ]);

        // Guardar emergencias
        if ($request->has('emergencias')) {
            foreach ($request->emergencias as $emergencia) {
                if (!empty($emergencia['tipo']) && !empty($emergencia['lugar'])) {
                    EstacionEmergencia::create([
                        'estacion_novedad_id' => $novedad->id,
                        'tipo_emergencia' => $emergencia['tipo'],
                        'lugar' => $emergencia['lugar'],
                        'direccion' => $emergencia['direccion'] ?? null,
                        'sector' => $emergencia['sector'] ?? null,
                        'hora_ingreso' => $emergencia['hora_ingreso'],
                        'hora_salida' => $emergencia['hora_salida'] ?? null,
                        'numero_afectados' => $emergencia['afectados'] ?? 0,
                        'numero_vehiculos' => $emergencia['vehiculos'] ?? 0,
                        'numero_bomberos' => $emergencia['bomberos'] ?? 0,
                        'descripcion' => $emergencia['descripcion'] ?? null,
                        'recursos_utilizados' => $emergencia['recursos'] ?? null,
                        'observaciones' => $emergencia['observaciones'] ?? null,
                    ]);
                }
            }
        }

        // Guardar novedades de vehículos
        if ($request->has('vehiculos')) {
            foreach ($request->vehiculos as $vehiculo) {
                if (!empty($vehiculo['vehiculo_id'])) {
                    EstacionVehiculo::create([
                        'estacion_novedad_id' => $novedad->id,
                        'vehiculo_id' => $vehiculo['vehiculo_id'],
                        'estado' => $vehiculo['estado'],
                        'tipo_novedad' => $vehiculo['tipo_novedad'],
                        'descripcion' => $vehiculo['descripcion'] ?? null,
                        'acciones_tomadas' => $vehiculo['acciones'] ?? null,
                        'kilometraje' => $vehiculo['kilometraje'] ?? null,
                        'fecha_reporte' => $vehiculo['fecha_reporte'],
                        'fecha_solucion' => $vehiculo['fecha_solucion'] ?? null,
                    ]);
                }
            }
        }

        // Guardar personal
        if ($request->has('personal')) {
            foreach ($request->personal as $persona) {
                if (!empty($persona['user_id'])) {
                    EstacionPersonal::create([
                        'estacion_novedad_id' => $novedad->id,
                        'user_id' => $persona['user_id'],
                        'cargo' => $persona['cargo'],
                        'turno' => $persona['turno'],
                        'hora_entrada' => $persona['hora_entrada'] ?? null,
                        'hora_salida' => $persona['hora_salida'] ?? null,
                        'estado' => $persona['estado'],
                        'observaciones' => $persona['observaciones'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('estacion-novedades.index')
            ->with('success', 'Novedad creada exitosamente. Código: NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT));
    }

    public function show($id)
    {
        $novedad = EstacionNovedad::with([
            'estacion',
            'usuarioElabora',
            'usuarioRevisa',
            'usuarioAprueba',
            'emergencias',
            'vehiculos.vehiculo',
            'personal.user'
        ])->findOrFail($id);

        return view('estacion_novedades.show', compact('novedad'));
    }

    public function edit($id)
    {
        $novedad = EstacionNovedad::with([
            'emergencias',
            'vehiculos',
            'personal'
        ])->findOrFail($id);

        if (!$novedad->puedeEditar()) {
            return redirect()->route('estacion-novedades.index')
                ->with('error', 'Esta novedad no puede ser editada porque ya fue aprobada.');
        }

        $estaciones = Station::all();
        $personal = User::all();
        $vehiculos = Vehiculo::all();

        return view('estacion_novedades.edit', compact('novedad', 'estaciones', 'personal', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        $novedad = EstacionNovedad::findOrFail($id);

        if (!$novedad->puedeEditar()) {
            return redirect()->route('estacion-novedades.index')
                ->with('error', 'Esta novedad no puede ser editada porque ya fue aprobada.');
        }

        $novedad->update([
            'fecha' => $request->fecha,
            'estacion_id' => $request->estacion_id,
            'observaciones' => $request->observaciones,
        ]);

        // Eliminar registros antiguos y crear nuevos
        $novedad->emergencias()->delete();
        $novedad->vehiculos()->delete();
        $novedad->personal()->delete();

        // Guardar emergencias
        if ($request->has('emergencias')) {
            foreach ($request->emergencias as $emergencia) {
                if (!empty($emergencia['tipo']) && !empty($emergencia['lugar'])) {
                    EstacionEmergencia::create([
                        'estacion_novedad_id' => $novedad->id,
                        'tipo_emergencia' => $emergencia['tipo'],
                        'lugar' => $emergencia['lugar'],
                        'direccion' => $emergencia['direccion'] ?? null,
                        'sector' => $emergencia['sector'] ?? null,
                        'hora_ingreso' => $emergencia['hora_ingreso'],
                        'hora_salida' => $emergencia['hora_salida'] ?? null,
                        'numero_afectados' => $emergencia['afectados'] ?? 0,
                        'numero_vehiculos' => $emergencia['vehiculos'] ?? 0,
                        'numero_bomberos' => $emergencia['bomberos'] ?? 0,
                        'descripcion' => $emergencia['descripcion'] ?? null,
                        'recursos_utilizados' => $emergencia['recursos'] ?? null,
                        'observaciones' => $emergencia['observaciones'] ?? null,
                    ]);
                }
            }
        }

        // Guardar novedades de vehículos
        if ($request->has('vehiculos')) {
            foreach ($request->vehiculos as $vehiculo) {
                if (!empty($vehiculo['vehiculo_id'])) {
                    EstacionVehiculo::create([
                        'estacion_novedad_id' => $novedad->id,
                        'vehiculo_id' => $vehiculo['vehiculo_id'],
                        'estado' => $vehiculo['estado'],
                        'tipo_novedad' => $vehiculo['tipo_novedad'],
                        'descripcion' => $vehiculo['descripcion'] ?? null,
                        'acciones_tomadas' => $vehiculo['acciones'] ?? null,
                        'kilometraje' => $vehiculo['kilometraje'] ?? null,
                        'fecha_reporte' => $vehiculo['fecha_reporte'],
                        'fecha_solucion' => $vehiculo['fecha_solucion'] ?? null,
                    ]);
                }
            }
        }

        // Guardar personal
        if ($request->has('personal')) {
            foreach ($request->personal as $persona) {
                if (!empty($persona['user_id'])) {
                    EstacionPersonal::create([
                        'estacion_novedad_id' => $novedad->id,
                        'user_id' => $persona['user_id'],
                        'cargo' => $persona['cargo'],
                        'turno' => $persona['turno'],
                        'hora_entrada' => $persona['hora_entrada'] ?? null,
                        'hora_salida' => $persona['hora_salida'] ?? null,
                        'estado' => $persona['estado'],
                        'observaciones' => $persona['observaciones'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('estacion-novedades.index')
            ->with('success', 'Novedad actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $novedad = EstacionNovedad::findOrFail($id);

        if (!$novedad->puedeEditar()) {
            return redirect()->route('estacion-novedades.index')
                ->with('error', 'No se puede eliminar una novedad aprobada.');
        }

        $novedad->delete();

        return redirect()->route('estacion-novedades.index')
            ->with('success', 'Novedad eliminada exitosamente.');
    }

    // Enviar a revisión
    public function enviarRevision($id)
    {
        try {
            $novedad = EstacionNovedad::with(['estacion', 'usuarioElabora'])->findOrFail($id);
        if ($novedad->estado !== EstacionNovedad::ESTADO_ELABORACION) {
        return redirect()->route('estacion-novedades.index')
            ->with('error', 'Esta novedad no puede enviarse a revisión.');
        }
            
        /*if ($novedad->estado !== 'elaboracion') {
                return redirect()->route('estacion-novedades.index')
                    ->with('error', 'Esta novedad no puede enviarse a revisión.');
            } */

            $novedad->estado = 'revision';
            $novedad->fecha_revision = now();
            $novedad->usuario_revisa_id = Auth::id();
            $novedad->save();

            // Enviar notificaciones
            try {
                // 1. Notificar al usuario que elaboró
                if ($novedad->usuarioElabora && $novedad->usuarioElabora->id != Auth::id()) {
                    $novedad->usuarioElabora->notify(new NovedadEnRevision($novedad, Auth::user()));
                }

                // 2. Notificar a los revisores
                $revisores = User::role(['Revisor', 'Aprobador', 'Super-Admin', 'admin'])->get();
                if ($revisores->count() > 0) {
                    Notification::send($revisores, new NovedadEnRevision($novedad, Auth::user()));
                }
            } catch (\Exception $e) {
                \Log::error('Error al enviar notificaciones: ' . $e->getMessage());
            }

            return redirect()->route('estacion-novedades.index')
                ->with('success', 'Novedad enviada a revisión exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('estacion-novedades.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Aprobar
    public function aprobar($id)
    {
        try {
            $novedad = EstacionNovedad::with(['estacion', 'usuarioElabora'])->findOrFail($id);
            if ($novedad->estado !== EstacionNovedad::ESTADO_REVISION) {
        return redirect()->route('estacion-novedades.index')
            ->with('error', 'Esta novedad no está en estado de revisión.');
            }
            /*
            if ($novedad->estado !== 'revision') {
                return redirect()->route('estacion-novedades.index')
                    ->with('error', 'Esta novedad no está en estado de revisión.');
            }*/

            $novedad->estado = 'aprobado';
            $novedad->fecha_aprobacion = now();
            $novedad->usuario_aprueba_id = Auth::id();
            $novedad->bloqueado = true;
            $novedad->save();

            // Enviar notificaciones
            try {
                // Notificar al usuario que elaboró
                if ($novedad->usuarioElabora) {
                    $novedad->usuarioElabora->notify(new NovedadAprobada($novedad, Auth::user()));
                }

                // Notificar a los revisores y aprobadores
                $usuarios = User::role(['Revisor', 'Aprobador', 'Super-Admin', 'admin'])->get();
                if ($usuarios->count() > 0) {
                    Notification::send($usuarios, new NovedadAprobada($novedad, Auth::user()));
                }
            } catch (\Exception $e) {
                \Log::error('Error al enviar notificaciones: ' . $e->getMessage());
            }

            return redirect()->route('estacion-novedades.index')
                ->with('success', 'Novedad aprobada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('estacion-novedades.index')
                ->with('error', 'Error al aprobar: ' . $e->getMessage());
        }
    }

    public function exportPdf($id)
    {
        try {
            $novedad = EstacionNovedad::with([
                'estacion',
                'usuarioElabora',
                'usuarioRevisa',
                'usuarioAprueba',
                'emergencias',
                'vehiculos.vehiculo',
                'personal.user'
            ])->findOrFail($id);

            $pdf = new \FPDF('P', 'mm', 'A4');
            $pdf->AddPage();
            $pdf->SetMargins(15, 15, 15);

            // Título
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(180, 10, 'NOVEDAD DE ESTACION', 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(180, 8, 'NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT), 0, 1, 'C');
            $pdf->Ln(5);

            // Línea separadora
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Line(15, 40, 195, 40);
            $pdf->Ln(5);

            // INFORMACION GENERAL
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(180, 8, 'INFORMACION GENERAL', 0, 1, 'L');
            $pdf->SetFont('Arial', '', 11);

            $pdf->Cell(50, 8, 'Fecha:', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(130, 8, $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha)), 0, 1);
            
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(50, 8, 'Estacion:', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(130, 8, $novedad->estacion->nombre ?? 'N/A', 0, 1);

            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(50, 8, 'Estado:', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(130, 8, ucfirst($novedad->estado), 0, 1);

            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(50, 8, 'Elaborado por:', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(130, 8, $novedad->usuarioElabora->name ?? 'N/A', 0, 1);

            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(50, 8, 'Fecha Elaboracion:', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(130, 8, $novedad->fecha_elaboracion instanceof \Carbon\Carbon ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_elaboracion)), 0, 1);

            if ($novedad->usuarioRevisa) {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(50, 8, 'Revisado por:', 0, 0);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(130, 8, $novedad->usuarioRevisa->name, 0, 1);

                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(50, 8, 'Fecha Revision:', 0, 0);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(130, 8, $novedad->fecha_revision instanceof \Carbon\Carbon ? $novedad->fecha_revision->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_revision)), 0, 1);
            }

            if ($novedad->usuarioAprueba) {
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(50, 8, 'Aprobado por:', 0, 0);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(130, 8, $novedad->usuarioAprueba->name, 0, 1);

                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(50, 8, 'Fecha Aprobacion:', 0, 0);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(130, 8, $novedad->fecha_aprobacion instanceof \Carbon\Carbon ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_aprobacion)), 0, 1);
            }

            // Observaciones
            if ($novedad->observaciones) {
                $pdf->Ln(3);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(180, 8, 'OBSERVACIONES GENERALES', 0, 1, 'L');
                $pdf->SetFont('Arial', '', 11);
                $pdf->MultiCell(180, 6, $novedad->observaciones, 0, 'L');
            }

            $pdf->Ln(3);

            // EMERGENCIAS
            if ($novedad->emergencias->count() > 0) {
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(180, 8, 'EMERGENCIAS ATENDIDAS', 0, 1, 'L');
                $pdf->SetFont('Arial', 'B', 10);
                
                $pdf->Cell(10, 6, '#', 1, 0, 'C');
                $pdf->Cell(30, 6, 'Tipo', 1, 0, 'C');
                $pdf->Cell(40, 6, 'Lugar', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Hora Ingreso', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Hora Salida', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Afectados', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Vehículos', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Bomberos', 1, 1, 'C');

                $pdf->SetFont('Arial', '', 9);
                foreach ($novedad->emergencias as $key => $emergencia) {
                    $pdf->Cell(10, 6, $key + 1, 1, 0, 'C');
                    $pdf->Cell(30, 6, ucfirst($emergencia->tipo_emergencia), 1, 0, 'L');
                    $pdf->Cell(40, 6, $emergencia->lugar, 1, 0, 'L');
                    $pdf->Cell(25, 6, $emergencia->hora_ingreso, 1, 0, 'C');
                    $pdf->Cell(25, 6, $emergencia->hora_salida ?? '-', 1, 0, 'C');
                    $pdf->Cell(20, 6, $emergencia->numero_afectados, 1, 0, 'C');
                    $pdf->Cell(20, 6, $emergencia->numero_vehiculos, 1, 0, 'C');
                    $pdf->Cell(20, 6, $emergencia->numero_bomberos, 1, 1, 'C');
                }
                $pdf->Ln(3);
            }

            // VEHICULOS
            if ($novedad->vehiculos->count() > 0) {
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(180, 8, 'NOVEDADES DE VEHICULOS', 0, 1, 'L');
                $pdf->SetFont('Arial', 'B', 10);
                
                $pdf->Cell(10, 6, '#', 1, 0, 'C');
                $pdf->Cell(30, 6, 'Vehículo', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Estado', 1, 0, 'C');
                $pdf->Cell(35, 6, 'Tipo Novedad', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Fecha Reporte', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Fecha Solución', 1, 0, 'C');
                $pdf->Cell(20, 6, 'Kilometraje', 1, 1, 'C');

                $pdf->SetFont('Arial', '', 9);
                foreach ($novedad->vehiculos as $key => $vehiculo) {
                    $pdf->Cell(10, 6, $key + 1, 1, 0, 'C');
                    $pdf->Cell(30, 6, $vehiculo->vehiculo->placa ?? 'N/A', 1, 0, 'L');
                    $pdf->Cell(25, 6, ucfirst($vehiculo->estado), 1, 0, 'L');
                    $pdf->Cell(35, 6, $vehiculo->tipo_novedad, 1, 0, 'L');
                    $pdf->Cell(25, 6, $vehiculo->fecha_reporte instanceof \Carbon\Carbon ? $vehiculo->fecha_reporte->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_reporte)), 1, 0, 'C');
                    $pdf->Cell(25, 6, $vehiculo->fecha_solucion ? ($vehiculo->fecha_solucion instanceof \Carbon\Carbon ? $vehiculo->fecha_solucion->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_solucion))) : '-', 1, 0, 'C');
                    $pdf->Cell(20, 6, $vehiculo->kilometraje ?? '-', 1, 1, 'C');
                }
                $pdf->Ln(3);
            }

            // PERSONAL
            if ($novedad->personal->count() > 0) {
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(180, 8, 'PERSONAL', 0, 1, 'L');
                $pdf->SetFont('Arial', 'B', 10);
                
                $pdf->Cell(10, 6, '#', 1, 0, 'C');
                $pdf->Cell(35, 6, 'Nombre', 1, 0, 'C');
                $pdf->Cell(30, 6, 'Cargo', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Turno', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Hora Entrada', 1, 0, 'C');
                $pdf->Cell(25, 6, 'Hora Salida', 1, 0, 'C');
                $pdf->Cell(30, 6, 'Estado', 1, 1, 'C');

                $pdf->SetFont('Arial', '', 9);
                foreach ($novedad->personal as $key => $persona) {
                    $pdf->Cell(10, 6, $key + 1, 1, 0, 'C');
                    $pdf->Cell(35, 6, $persona->user->name ?? 'N/A', 1, 0, 'L');
                    $pdf->Cell(30, 6, $persona->cargo, 1, 0, 'L');
                    $pdf->Cell(25, 6, ucfirst($persona->turno), 1, 0, 'L');
                    $pdf->Cell(25, 6, $persona->hora_entrada ?? '-', 1, 0, 'C');
                    $pdf->Cell(25, 6, $persona->hora_salida ?? '-', 1, 0, 'C');
                    $pdf->Cell(30, 6, ucfirst($persona->estado), 1, 1, 'L');
                }
            }

            // FIRMAS
            $pdf->Ln(8);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(180, 8, 'FIRMAS DE RESPONSABLES', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->SetFont('Arial', '', 11);

            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, '_________________________', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, 'Firma', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(60, 10, $novedad->usuarioElabora->name ?? '_________________________', 0, 0);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, 'ELABORADO POR', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Ln(5);

            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, '_________________________', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, 'Firma', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(60, 10, $novedad->usuarioRevisa->name ?? '_________________________', 0, 0);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, 'REVISADO POR', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Ln(5);

            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, '_________________________', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, 'Firma', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(60, 10, $novedad->usuarioAprueba->name ?? '_________________________', 0, 0);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(60, 10, '', 0, 1);
            $pdf->Cell(60, 10, '', 0, 0);
            $pdf->Cell(60, 10, 'APROBADO POR', 0, 0);
            $pdf->Cell(60, 10, '', 0, 1);

            // Pie de página
            $pdf->SetY(-15);
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(180, 5, 'Documento generado por el Sistema de Incidentes - ' . date('Y'), 0, 0, 'C');

            $tempFile = storage_path('app/temp_pdf_' . uniqid() . '.pdf');
            $pdf->Output('F', $tempFile);
            
            $content = file_get_contents($tempFile);
            @unlink($tempFile);
            
            return response($content, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="novedad-NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT) . '.pdf"');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
        }
    }

    // Ratificar novedad
    public function ratificar($id)
    {
        try {
            $novedad = EstacionNovedad::with(['estacion', 'usuarioElabora'])->findOrFail($id);
            
            // Validar que el usuario tenga el permiso
            if (!auth()->user()->can('ratificar novedades')) {
                return redirect()->route('estacion-novedades.index')
                    ->with('error', 'No tienes permiso para ratificar novedades.');
            }
            
            // Validar que la novedad esté en estado aprobado
            if (!$novedad->puedeRatificar()) {
                return redirect()->route('estacion-novedades.index')
                    ->with('error', 'Solo se pueden ratificar novedades aprobadas.');
            }
            
            $novedad->estado = EstacionNovedad::ESTADO_RATIFICADO;
            $novedad->usuario_ratifica_id = Auth::id();
            $novedad->fecha_ratificacion = now();
            $novedad->bloqueado = true;
            $novedad->save();
            
            return redirect()->route('estacion-novedades.index')
                ->with('success', 'Novedad ratificada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->route('estacion-novedades.index')
                ->with('error', 'Error al ratificar: ' . $e->getMessage());
        }
    }

    public function enviarCorreo($id)
{
    try {
        $novedad = EstacionNovedad::with([
            'estacion',
            'usuarioElabora',
            'usuarioRevisa',
            'usuarioAprueba',
            'usuarioRatifica'
        ])->findOrFail($id);
        
        // Log para verificar
        \Log::info('Intentando enviar correo para novedad ID: ' . $id);
        
        // Enviar correo al usuario que elaboró
        if ($novedad->usuarioElabora) {
            $novedad->usuarioElabora->notify(new \App\Notifications\NovedadEnRevision($novedad, Auth::user()));
            \Log::info('Correo enviado al elaborador: ' . $novedad->usuarioElabora->name);
        }
        
        // Enviar a los revisores
        $revisores = User::role(['Revisor', 'Aprobador', 'Ratificador', 'Super-Admin', 'admin'])->get();
        if ($revisores->count() > 0) {
            \Illuminate\Support\Facades\Notification::send($revisores, new \App\Notifications\NovedadEnRevision($novedad, Auth::user()));
            \Log::info('Correo enviado a ' . $revisores->count() . ' revisores');
        }
        
        return redirect()->back()->with('success', '✅ Correo enviado exitosamente.');
        
    } catch (\Exception $e) {
        \Log::error('Error al enviar correo: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al enviar correo: ' . $e->getMessage());
    }
}
}