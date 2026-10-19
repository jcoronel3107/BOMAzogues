<?php

namespace App\Http\Controllers;

use App\EstacionNovedad;
use App\EstacionEmergencia;
use App\EstacionVehiculo;
use App\EstacionPersonal;
use App\Station;
use App\User;
use App\Vehiculo;
use App\Emergencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NovedadEnRevision;
use App\Notifications\NovedadAprobada;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\EmergenciaPrehospitalaria;   // ⬅️ AGREGAR SI FALTA
use App\EmergenciaFuego;              // ⬅️ AGREGAR SI FALTA

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
        $user = Auth::user();
        
        // Si el usuario tiene estación asignada, filtrar
        if ($user->station_id) {
            $novedades = EstacionNovedad::with(['estacion', 'usuarioElabora', 'usuarioRevisa', 'usuarioAprueba'])
                ->where('estacion_id', $user->station_id)
                ->latest()
                ->paginate(15);
        } else {
            // Si no tiene estación asignada (Super-Admin), ver todas
            $novedades = EstacionNovedad::with(['estacion', 'usuarioElabora', 'usuarioRevisa', 'usuarioAprueba'])
                ->latest()
                ->paginate(15);
        }
        
        return view('estacion_novedades.index', compact('novedades'));
    }
/* FUNCION CREATE ORIGINAL SIN BUSQUEDA DE EMERGENCIAS
    public function create()
    {
        $user = Auth::user();
        
        // Si el usuario tiene estación asignada, solo mostrar esa
        if ($user->station_id) {
            $estaciones = Station::where('id', $user->station_id)->get();
        } else {
            // Super-Admin puede ver todas
            $estaciones = Station::all();
        }
        
        $personal = User::all();
        $vehiculos = Vehiculo::all();
        
        return view('estacion_novedades.create', compact('estaciones', 'personal', 'vehiculos'));
    }
*/
    public function create()
    {
            $user = Auth::user();
            
            // Obtener estaciones permitidas
            if ($user->station_id) {
                $estaciones = Station::where('id', $user->station_id)->get();
                // Obtener emergencias de la estación del usuario para hoy
                $emergencias = Emergencia::where('estacion_id', $user->station_id)
                    ->whereDate('fecha', today())
                    ->with(['tipoIncidente', 'estacion', 'usuarios', 'vehiculos'])
                    ->get();
            } else {
                // Super-Admin puede ver todas
                $estaciones = Station::all();
                $emergencias = collect(); // vacío
            }
            
            $personal = User::all();
            $vehiculos = Vehiculo::all();
            
            return view('estacion_novedades.create', compact('estaciones', 'personal', 'vehiculos', 'emergencias'));
    }

    // Buscar emergencias por fecha
    public function buscarEmergencias(Request $request)
{
        try {
            $fecha = $request->input('fecha');
            $estacionId = $request->input('estacion_id');

            \Log::info('Buscando emergencias - Fecha: ' . $fecha . ' - Estación: ' . $estacionId);

            // ===== 1. EMERGENCIAS (módulo antiguo) =====
            $emergencias = Emergencia::where('estacion_id', $estacionId)
                ->whereDate('fecha', $fecha)
                ->with(['tipoIncidente', 'estacion', 'usuarios', 'vehiculos'])
                ->get()
                ->map(function ($e) {
                    return [
                        'id' => $e->id,
                        'codigo' => 'EMG-' . str_pad($e->id, 4, '0', STR_PAD_LEFT),
                        'tipo' => $e->tipoIncidente->nombre_incidente ?? 'Sin tipo',
                        'hora_salida' => $e->hora_salida_emergencia,
                        'hora_llegada' => $e->hora_llegada_emergencia,
                        'detalle' => $e->detalle_emergencia,
                        'personal' => $e->usuarios->count(),
                        'vehiculos' => $e->vehiculos->count(),
                    ];
                });

            // ===== 2. EMERGENCIAS PREHOSPITALARIAS =====
            $prehospitalarias = EmergenciaPrehospitalaria::where('estacion_id', $estacionId)
                ->whereDate('fecha_salida', $fecha)
                ->with(['vehiculo', 'personal', 'pacientes'])
                ->get()
                ->map(function ($e) {
                    return [
                        'id' => $e->id,
                        'codigo' => $e->codigo,
                        'tipo' => $e->tipo_emergencia,
                        'hora_salida' => $e->fecha_salida ? $e->fecha_salida->format('H:i') : null,
                        'hora_llegada' => $e->fecha_llegada_base ? $e->fecha_llegada_base->format('H:i') : null,
                        'detalle' => $e->motivo_llamado . ' - ' . $e->direccion,
                        'personal' => $e->personal->count(),
                        'vehiculos' => $e->vehiculo ? 1 : 0,
                        'pacientes' => $e->pacientes->count(),
                        'prioridad' => $e->prioridad,
                    ];
                });

            // ===== 3. EMERGENCIAS DE FUEGO =====
            $fuego = EmergenciaFuego::where('estacion_id', $estacionId)
                ->whereDate('fecha_salida', $fecha)
                ->with(['vehiculos', 'personal', 'pacientes'])
                ->get()
                ->map(function ($e) {
                    return [
                        'id' => $e->id,
                        'codigo' => $e->codigo,
                        'tipo' => $e->tipo_fuego,
                        'hora_salida' => $e->fecha_salida ? $e->fecha_salida->format('H:i') : null,
                        'hora_llegada' => $e->fecha_llegada_base ? $e->fecha_llegada_base->format('H:i') : null,
                        'detalle' => $e->motivo_llamado . ' - ' . $e->direccion,
                        'personal' => $e->personal->count(),
                        'vehiculos' => $e->vehiculos->count(),
                        'pacientes' => $e->pacientes->count(),
                        'nivel_riesgo' => $e->nivel_riesgo,
                    ];
                });

            return response()->json([
                'emergencias' => $emergencias,
                'prehospitalarias' => $prehospitalarias,
                'fuego' => $fuego,
                'totales' => [
                    'emergencias' => $emergencias->count(),
                    'prehospitalarias' => $prehospitalarias->count(),
                    'fuego' => $fuego->count(),
                    'total' => $emergencias->count() + $prehospitalarias->count() + $fuego->count(),
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al buscar emergencias: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'emergencias' => [],
                'prehospitalarias' => [],
                'fuego' => [],
            ], 500);
        }
}

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'estacion_id' => 'required|exists:stations,id',
            'observaciones' => 'nullable|string',
        ]);
        // Verificar que el usuario pertenece a la estación seleccionada
        $user = Auth::user();
        if ($user->station_id && $user->station_id != $request->estacion_id) {
            return redirect()->back()
            ->with('error', 'No tienes permiso para crear novedades en esta estación.')
            ->withInput();
        }

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
        
        // ===== ASOCIAR EMERGENCIAS EXISTENTES =====

        // Emergencias (módulo antiguo)
        if ($request->has('emergencias_asociadas')) {
            $novedad->emergenciasAsociadas()->sync($request->emergencias_asociadas);
        }

        // Emergencias Prehospitalarias
        if ($request->has('prehospitalarias_asociadas')) {
            $novedad->prehospitalariasAsociadas()->sync($request->prehospitalarias_asociadas);
        }

        // Emergencias de Fuego
        if ($request->has('fuego_asociadas')) {
            $novedad->fuegoAsociadas()->sync($request->fuego_asociadas);
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

        // ============================================
        // GUARDAR INTEGRANTES DE LA GUARDIA BOMBERIL
        // ============================================
        if ($request->has('integrantes_guardia')) {
            $integrantes = [];
            foreach ($request->integrantes_guardia as $integrante) {
                if (!empty($integrante['nombre'])) {
                    $integrantes[] = [
                        'nombre' => $integrante['nombre'],
                        'cedula' => $integrante['cedula'] ?? null,
                        'cargo' => $integrante['cargo'] ?? null,
                        'observaciones' => $integrante['observaciones'] ?? null,
                    ];
                }
            }
            if (!empty($integrantes)) {
                $novedad->update([
                    'integrantes_guardia' => $integrantes
                ]);
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
        'emergenciasAsociadas',           // ⬅️ NUEVA
        'prehospitalariasAsociadas',      // ⬅️ NUEVA
        'fuegoAsociadas',                 // ⬅️ NUEVA
        'vehiculos',
        'personal'
    ])->findOrFail($id);

    return view('estacion_novedades.show', compact('novedad'));
}

    public function edit($id)
{
    $novedad = EstacionNovedad::with([
        'emergencias',
        'emergenciasAsociadas',           // ⬅️ NUEVA
        'prehospitalariasAsociadas',      // ⬅️ NUEVA
        'fuegoAsociadas',                 // ⬅️ NUEVA
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

       
        // ===== RE-SINCRONIZAR EMERGENCIAS ASOCIADAS =====

        if ($request->has('emergencias_asociadas')) {
            $novedad->emergenciasAsociadas()->sync($request->emergencias_asociadas);
        } else {
            $novedad->emergenciasAsociadas()->detach();
        }

        if ($request->has('prehospitalarias_asociadas')) {
            $novedad->prehospitalariasAsociadas()->sync($request->prehospitalarias_asociadas);
        } else {
            $novedad->prehospitalariasAsociadas()->detach();
        }

        if ($request->has('fuego_asociadas')) {
            $novedad->fuegoAsociadas()->sync($request->fuego_asociadas);
        } else {
            $novedad->fuegoAsociadas()->detach();
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

    /**
 * Exportar todas las novedades a Excel
 */
    public function exportPdf($id)
{
    try {
        $novedad = EstacionNovedad::with([
            'estacion',
            'usuarioElabora',
            'usuarioRevisa',
            'usuarioAprueba',
            'emergencias',
            'emergenciasAsociadas',
            'emergenciasAsociadas.tipoIncidente',
            'emergenciasAsociadas.usuarios',
            'emergenciasAsociadas.vehiculos',
            'prehospitalariasAsociadas',
            'prehospitalariasAsociadas.pacientes',
            'fuegoAsociadas',
            'fuegoAsociadas.pacientes',
            'vehiculos.vehiculo',
            'personal.user'
        ])->findOrFail($id);

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(12, 10, 12); // Márgenes más pequeños

        // ============================================
        // CABECERA COMPACTA
        // ============================================
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(186, 6, 'NOVEDAD DE ESTACION', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(186, 5, 'NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT), 0, 1, 'C');
        $pdf->Ln(1);

        // Línea separadora
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $pdf->Ln(2);

        // ============================================
        // INFORMACION GENERAL COMPACTA (2 columnas)
        // ============================================
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(186, 5, 'INFORMACION GENERAL', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);

        // Fila 1: Fecha + Estación
        $pdf->Cell(25, 5, 'Fecha:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha)), 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'Estacion:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->estacion->nombre ?? 'N/A', 0, 1);

        // Fila 2: Estado + Elaborado por
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'Estado:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, ucfirst($novedad->estado), 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'Elaborado por:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->usuarioElabora->name ?? 'N/A', 0, 1);

        // Fila 3: Fecha elaboración + revisado por
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'F. Elaboracion:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->fecha_elaboracion instanceof \Carbon\Carbon ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_elaboracion)), 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'Revisado por:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->usuarioRevisa->name ?? 'N/A', 0, 1);

        // Fila 4: Fecha revisión + aprobado por
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'F. Revision:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->fecha_revision ? ($novedad->fecha_revision instanceof \Carbon\Carbon ? $novedad->fecha_revision->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_revision))) : 'N/A', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'Aprobado por:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->usuarioAprueba->name ?? 'N/A', 0, 1);

        // Fila 5: Fecha aprobación
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(25, 5, 'F. Aprobacion:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(68, 5, $novedad->fecha_aprobacion ? ($novedad->fecha_aprobacion instanceof \Carbon\Carbon ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_aprobacion))) : 'N/A', 0, 1);

        $pdf->Ln(2);

        // ============================================
        // OBSERVACIONES (compacta)
        // ============================================
        if ($novedad->observaciones) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'OBSERVACIONES GENERALES', 0, 1, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, $novedad->observaciones, 0, 'L');
            $pdf->Ln(1);
        }

        // ============================================
        // EMERGENCIAS MANUALES
        // ============================================
        if ($novedad->emergencias->count() > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'EMERGENCIAS ATENDIDAS', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(30, 4, 'Tipo', 1, 0, 'C');
            $pdf->Cell(45, 4, 'Lugar', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Ingreso', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Salida', 1, 0, 'C');
            $pdf->Cell(20, 4, 'Afectados', 1, 0, 'C');
            $pdf->Cell(20, 4, 'Vehiculos', 1, 0, 'C');
            $pdf->Cell(19, 4, 'Bomberos', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->emergencias as $key => $emergencia) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(30, 4, ucfirst($emergencia->tipo_emergencia), 1, 0, 'L');
                $pdf->Cell(45, 4, $emergencia->lugar, 1, 0, 'L');
                $pdf->Cell(22, 4, $emergencia->hora_ingreso, 1, 0, 'C');
                $pdf->Cell(22, 4, $emergencia->hora_salida ?? '-', 1, 0, 'C');
                $pdf->Cell(20, 4, $emergencia->numero_afectados, 1, 0, 'C');
                $pdf->Cell(20, 4, $emergencia->numero_vehiculos, 1, 0, 'C');
                $pdf->Cell(19, 4, $emergencia->numero_bomberos, 1, 1, 'C');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // EMERGENCIAS ASOCIADAS (MÓDULO GENERAL)
        // ============================================
        if ($novedad->emergenciasAsociadas->count() > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'EMERGENCIAS ASOCIADAS (MODULO GENERAL)', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(35, 4, 'Codigo', 1, 0, 'C');
            $pdf->Cell(45, 4, 'Tipo', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Salida', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Llegada', 1, 0, 'C');
            $pdf->Cell(20, 4, 'Personal', 1, 0, 'C');
            $pdf->Cell(34, 4, 'Vehiculos', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->emergenciasAsociadas as $key => $emergencia) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(35, 4, 'EMG-' . str_pad($emergencia->id, 4, '0', STR_PAD_LEFT), 1, 0, 'C');
                $pdf->Cell(45, 4, $emergencia->tipoIncidente->nombre_incidente ?? 'Sin tipo', 1, 0, 'L');
                $pdf->Cell(22, 4, $emergencia->hora_salida_emergencia ?? '-', 1, 0, 'C');
                $pdf->Cell(22, 4, $emergencia->hora_llegada_emergencia ?? '-', 1, 0, 'C');
                $pdf->Cell(20, 4, $emergencia->usuarios->count() ?? 0, 1, 0, 'C');
                $pdf->Cell(34, 4, $emergencia->vehiculos->count() ?? 0, 1, 1, 'C');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // EMERGENCIAS PREHOSPITALARIAS ASOCIADAS
        // ============================================
        if ($novedad->prehospitalariasAsociadas->count() > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'EMERGENCIAS PREHOSPITALARIAS ASOCIADAS', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(35, 4, 'Codigo', 1, 0, 'C');
            $pdf->Cell(45, 4, 'Tipo', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Prioridad', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Salida', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Llegada', 1, 0, 'C');
            $pdf->Cell(32, 4, 'Pacientes', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->prehospitalariasAsociadas as $key => $emergencia) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(35, 4, $emergencia->codigo, 1, 0, 'C');
                $pdf->Cell(45, 4, $emergencia->tipo_emergencia, 1, 0, 'L');
                $pdf->Cell(22, 4, $emergencia->prioridad, 1, 0, 'C');
                $pdf->Cell(22, 4, $emergencia->fecha_salida ? $emergencia->fecha_salida->format('H:i') : '-', 1, 0, 'C');
                $pdf->Cell(22, 4, $emergencia->fecha_llegada_base ? $emergencia->fecha_llegada_base->format('H:i') : '-', 1, 0, 'C');
                $pdf->Cell(32, 4, $emergencia->pacientes->count() ?? 0, 1, 1, 'C');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // EMERGENCIAS DE FUEGO ASOCIADAS
        // ============================================
        if ($novedad->fuegoAsociadas->count() > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'EMERGENCIAS DE FUEGO ASOCIADAS', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(35, 4, 'Codigo', 1, 0, 'C');
            $pdf->Cell(45, 4, 'Tipo', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Riesgo', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Salida', 1, 0, 'C');
            $pdf->Cell(22, 4, 'Hora Llegada', 1, 0, 'C');
            $pdf->Cell(32, 4, 'Pacientes', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->fuegoAsociadas as $key => $emergencia) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(35, 4, $emergencia->codigo, 1, 0, 'C');
                $pdf->Cell(45, 4, $emergencia->tipo_fuego, 1, 0, 'L');
                $pdf->Cell(22, 4, $emergencia->nivel_riesgo, 1, 0, 'C');
                $pdf->Cell(22, 4, $emergencia->fecha_salida ? $emergencia->fecha_salida->format('H:i') : '-', 1, 0, 'C');
                $pdf->Cell(22, 4, $emergencia->fecha_llegada_base ? $emergencia->fecha_llegada_base->format('H:i') : '-', 1, 0, 'C');
                $pdf->Cell(32, 4, $emergencia->pacientes->count() ?? 0, 1, 1, 'C');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // VEHICULOS
        // ============================================
        if ($novedad->vehiculos->count() > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'NOVEDADES DE VEHICULOS', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(30, 4, 'Vehiculo', 1, 0, 'C');
            $pdf->Cell(25, 4, 'Estado', 1, 0, 'C');
            $pdf->Cell(35, 4, 'Tipo Novedad', 1, 0, 'C');
            $pdf->Cell(30, 4, 'Fecha Reporte', 1, 0, 'C');
            $pdf->Cell(30, 4, 'Fecha Solucion', 1, 0, 'C');
            $pdf->Cell(28, 4, 'Kilometraje', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->vehiculos as $key => $vehiculo) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(30, 4, $vehiculo->vehiculo->placa ?? 'N/A', 1, 0, 'L');
                $pdf->Cell(25, 4, ucfirst($vehiculo->estado), 1, 0, 'L');
                $pdf->Cell(35, 4, $vehiculo->tipo_novedad, 1, 0, 'L');
                $pdf->Cell(30, 4, $vehiculo->fecha_reporte instanceof \Carbon\Carbon ? $vehiculo->fecha_reporte->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_reporte)), 1, 0, 'C');
                $pdf->Cell(30, 4, $vehiculo->fecha_solucion ? ($vehiculo->fecha_solucion instanceof \Carbon\Carbon ? $vehiculo->fecha_solucion->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_solucion))) : '-', 1, 0, 'C');
                $pdf->Cell(28, 4, $vehiculo->kilometraje ?? '-', 1, 1, 'C');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // PERSONAL
        // ============================================
        if ($novedad->personal->count() > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'PERSONAL', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(40, 4, 'Nombre', 1, 0, 'C');
            $pdf->Cell(30, 4, 'Cargo', 1, 0, 'C');
            $pdf->Cell(25, 4, 'Turno', 1, 0, 'C');
            $pdf->Cell(23, 4, 'Hora Entrada', 1, 0, 'C');
            $pdf->Cell(23, 4, 'Hora Salida', 1, 0, 'C');
            $pdf->Cell(37, 4, 'Estado', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->personal as $key => $persona) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(40, 4, $persona->user->name ?? 'N/A', 1, 0, 'L');
                $pdf->Cell(30, 4, $persona->cargo, 1, 0, 'L');
                $pdf->Cell(25, 4, ucfirst($persona->turno), 1, 0, 'L');
                $pdf->Cell(23, 4, $persona->hora_entrada ?? '-', 1, 0, 'C');
                $pdf->Cell(23, 4, $persona->hora_salida ?? '-', 1, 0, 'C');
                $pdf->Cell(37, 4, ucfirst($persona->estado), 1, 1, 'L');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // INTEGRANTES DE LA GUARDIA BOMBERIL
        // ============================================
        if ($novedad->integrantes_guardia && count($novedad->integrantes_guardia) > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(186, 5, 'INTEGRANTES DE LA GUARDIA BOMBERIL', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(8, 4, '#', 1, 0, 'C');
            $pdf->Cell(60, 4, 'Nombres y Apellidos', 1, 0, 'C');
            $pdf->Cell(35, 4, 'Cedula', 1, 0, 'C');
            $pdf->Cell(35, 4, 'Cargo', 1, 0, 'C');
            $pdf->Cell(48, 4, 'Observaciones', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            foreach ($novedad->integrantes_guardia as $key => $integrante) {
                $pdf->Cell(8, 4, $key + 1, 1, 0, 'C');
                $pdf->Cell(60, 4, $integrante['nombre'] ?? 'N/A', 1, 0, 'L');
                $pdf->Cell(35, 4, $integrante['cedula'] ?? 'N/A', 1, 0, 'C');
                $pdf->Cell(35, 4, $integrante['cargo'] ?? 'N/A', 1, 0, 'L');
                $pdf->Cell(48, 4, $integrante['observaciones'] ?? '-', 1, 1, 'L');
            }
            $pdf->Ln(1);
        }

        // ============================================
        // FIRMAS (HORIZONTAL - ULTRA COMPACTA)
        // ============================================
        $pdf->Ln(4);
        $pdf->SetDrawColor(0, 0, 0);

        // Líneas de firma
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(60, 3, '_____________________', 0, 0, 'C');
        $pdf->Cell(60, 3, '_____________________', 0, 0, 'C');
        $pdf->Cell(60, 3, '_____________________', 0, 1, 'C');
        $pdf->Ln(1);

        // Nombres
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 3, $novedad->usuarioElabora->name ?? '_________________________', 0, 0, 'C');
        $pdf->Cell(60, 3, $novedad->usuarioRevisa->name ?? '_________________________', 0, 0, 'C');
        $pdf->Cell(60, 3, $novedad->usuarioAprueba->name ?? '_________________________', 0, 1, 'C');
        $pdf->Ln(1);

        // Roles
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(60, 3, 'Elaborado por', 0, 0, 'C');
        $pdf->Cell(60, 3, 'Revisado por', 0, 0, 'C');
        $pdf->Cell(60, 3, 'Aprobado por', 0, 1, 'C');

        // Salida del PDF
        $nombreArchivo = 'Novedad_NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $nombreArchivo . '"');

    } catch (\Exception $e) {
        \Log::error('Error al generar PDF: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
    }
}

/**
 * Exportar emergencias de una novedad a Excel
 */
public function exportEmergencias($id)
{
    try {
        $novedad = EstacionNovedad::with([
            'estacion',
            'emergencias',
            'emergenciasAsociadas.tipoIncidente',
            'prehospitalariasAsociadas',
            'fuegoAsociadas',
        ])->findOrFail($id);

        $filename = 'novedad_' . $novedad->id . '_emergencias_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($novedad) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // ===== INFO DE LA NOVEDAD =====
            fputcsv($file, ['NOVEDAD DE ESTACIÓN']);
            fputcsv($file, ['Código:', 'NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT)]);
            fputcsv($file, ['Fecha:', $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha))]);
            fputcsv($file, ['Estación:', $novedad->estacion->nombre ?? 'N/A']);
            fputcsv($file, ['Estado:', ucfirst($novedad->estado)]);
            fputcsv($file, ['Elaborado por:', $novedad->usuarioElabora->name ?? 'N/A']);
            fputcsv($file, []);
            
            // ===== EMERGENCIAS MANUALES =====
            if ($novedad->emergencias->count() > 0) {
                fputcsv($file, ['EMERGENCIAS ATENDIDAS (MANUAL)']);
                fputcsv($file, ['#', 'Tipo', 'Lugar', 'Hora Ingreso', 'Hora Salida', 'Afectados', 'Vehículos', 'Bomberos', 'Descripción']);
                foreach ($novedad->emergencias as $key => $emergencia) {
                    fputcsv($file, [
                        $key + 1,
                        ucfirst($emergencia->tipo_emergencia),
                        $emergencia->lugar,
                        $emergencia->hora_ingreso,
                        $emergencia->hora_salida ?? '-',
                        $emergencia->numero_afectados,
                        $emergencia->numero_vehiculos,
                        $emergencia->numero_bomberos,
                        $emergencia->descripcion ?? '',
                    ]);
                }
                fputcsv($file, []);
            }
            
            // ===== EMERGENCIAS ASOCIADAS (MÓDULO GENERAL) =====
            if ($novedad->emergenciasAsociadas->count() > 0) {
                fputcsv($file, ['EMERGENCIAS ASOCIADAS (MÓDULO GENERAL)']);
                fputcsv($file, ['#', 'Código', 'Tipo', 'Hora Salida', 'Hora Llegada', 'Personal', 'Vehículos']);
                foreach ($novedad->emergenciasAsociadas as $key => $emergencia) {
                    fputcsv($file, [
                        $key + 1,
                        'EMG-' . str_pad($emergencia->id, 4, '0', STR_PAD_LEFT),
                        $emergencia->tipoIncidente->nombre_incidente ?? 'Sin tipo',
                        $emergencia->hora_salida_emergencia ?? '-',
                        $emergencia->hora_llegada_emergencia ?? '-',
                        $emergencia->usuarios->count() ?? 0,
                        $emergencia->vehiculos->count() ?? 0,
                    ]);
                }
                fputcsv($file, []);
            }
            
            // ===== EMERGENCIAS PREHOSPITALARIAS =====
            if ($novedad->prehospitalariasAsociadas->count() > 0) {
                fputcsv($file, ['EMERGENCIAS PREHOSPITALARIAS ASOCIADAS']);
                fputcsv($file, ['#', 'Código', 'Tipo', 'Prioridad', 'Hora Salida', 'Hora Llegada', 'Pacientes', 'Personal']);
                foreach ($novedad->prehospitalariasAsociadas as $key => $emergencia) {
                    fputcsv($file, [
                        $key + 1,
                        $emergencia->codigo,
                        $emergencia->tipo_emergencia,
                        $emergencia->prioridad,
                        $emergencia->fecha_salida ? $emergencia->fecha_salida->format('H:i') : '-',
                        $emergencia->fecha_llegada_base ? $emergencia->fecha_llegada_base->format('H:i') : '-',
                        $emergencia->pacientes->count() ?? 0,
                        $emergencia->personal->count() ?? 0,
                    ]);
                }
                fputcsv($file, []);
            }
            
            // ===== EMERGENCIAS DE FUEGO =====
            if ($novedad->fuegoAsociadas->count() > 0) {
                fputcsv($file, ['EMERGENCIAS DE FUEGO ASOCIADAS']);
                fputcsv($file, ['#', 'Código', 'Tipo', 'Riesgo', 'Hora Salida', 'Hora Llegada', 'Pacientes', 'Personal']);
                foreach ($novedad->fuegoAsociadas as $key => $emergencia) {
                    fputcsv($file, [
                        $key + 1,
                        $emergencia->codigo,
                        $emergencia->tipo_fuego,
                        $emergencia->nivel_riesgo,
                        $emergencia->fecha_salida ? $emergencia->fecha_salida->format('H:i') : '-',
                        $emergencia->fecha_llegada_base ? $emergencia->fecha_llegada_base->format('H:i') : '-',
                        $emergencia->pacientes->count() ?? 0,
                        $emergencia->personal->count() ?? 0,
                    ]);
                }
                fputcsv($file, []);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    } catch (\Exception $e) {
        \Log::error('Error al exportar emergencias: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al exportar: ' . $e->getMessage());
    }
}

}