<?php

namespace App\Http\Controllers;

use App\EmergenciaFuego;
use App\PacienteEmergenciaFuego;
use App\EmergenciaFuegoArchivo;
use App\InsumoMedico;
use App\Vehiculo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmergenciaFuegoController extends Controller
{
    // ============================================================
    //  INDEX
    // ============================================================
    public function index(Request $request)
    {
        $query = EmergenciaFuego::with(['vehiculos', 'usuarioRegistra', 'pacientes', 'personal']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo', 'LIKE', "%{$buscar}%")
                  ->orWhere('direccion', 'LIKE', "%{$buscar}%")
                  ->orWhere('motivo_llamado', 'LIKE', "%{$buscar}%")
                  ->orWhere('referencia', 'LIKE', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) $query->where('estado', $request->estado);
        if ($request->filled('tipo_fuego')) $query->where('tipo_fuego', $request->tipo_fuego);
        if ($request->filled('nivel_riesgo')) $query->where('nivel_riesgo', $request->nivel_riesgo);
        if ($request->filled('fecha_desde')) $query->whereDate('fecha_salida', '>=', $request->fecha_desde);
        if ($request->filled('fecha_hasta')) $query->whereDate('fecha_salida', '<=', $request->fecha_hasta);

        $query->orderBy('fecha_salida', 'desc');

        $perPage = $request->get('per_page', 10);
        $emergencias = $query->paginate($perPage)->withQueryString();

        $resumen = [
            'total' => EmergenciaFuego::count(),
            'en_curso' => EmergenciaFuego::where('estado', 'En curso')->count(),
            'extinguidos' => EmergenciaFuego::where('estado', 'Extinguido')->count(),
            'hoy' => EmergenciaFuego::whereDate('fecha_salida', today())->count(),
        ];

        $tipos = EmergenciaFuego::getTiposFuego();
        $niveles = EmergenciaFuego::getNivelesRiesgo();
        $estados = EmergenciaFuego::getEstados();
        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();

        return view('emergencias_fuego.index', compact(
            'emergencias', 'resumen', 'tipos', 'niveles', 'estados', 'vehiculos', 'personal'
        ));
    }

    // ============================================================
    //  CREATE
    // ============================================================
    public function create()
    {
        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();
        $insumos = InsumoMedico::orderBy('descripcion')->get();
        $parroquias = \App\Parroquia::orderBy('nombre')->get();
        $herramientas = \App\Herramienta::orderBy('descripcion')->get();
        $tipos = EmergenciaFuego::getTiposFuego();
        $niveles = EmergenciaFuego::getNivelesRiesgo();
        $estados = EmergenciaFuego::getEstados();

        return view('emergencias_fuego.create', compact(
            'vehiculos', 'personal', 'insumos', 'parroquias', 'herramientas',
            'tipos', 'niveles', 'estados'
        ));
    }

    // ============================================================
    //  STORE
    // ============================================================
    public function store(Request $request)
    {
        $request->validate([
            'fecha_salida' => 'required|date',
            'direccion' => 'required|string|max:255',
            'motivo_llamado' => 'required|string|max:255',
            'tipo_fuego' => 'required|string',
            'nivel_riesgo' => 'required|in:Bajo,Medio,Alto,Crítico',
            'personal' => 'required|array|min:1',
            'personal.*.user_id' => 'required|exists:users,id',
            'personal.*.rol_en_emergencia' => 'required|string',
            'vehiculos' => 'required|array|min:1',
            'vehiculos.*.vehiculo_id' => 'required|exists:vehiculos,id',
            'pacientes' => 'nullable|array',
            'insumos' => 'nullable|array',
            'insumos.*.insumo_medico_id' => 'required|exists:insumos_medicos,id',
            'insumos.*.cantidad' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            $emergencia = EmergenciaFuego::create([
                'codigo' => EmergenciaFuego::generarCodigo(),
                'fecha_salida' => $request->fecha_salida,
                'fecha_llegada_sitio' => $request->fecha_llegada_sitio,
                'fecha_control' => $request->fecha_control,
                'fecha_extincion' => $request->fecha_extincion,
                'fecha_llegada_base' => $request->fecha_llegada_base,
                'direccion' => $request->direccion,
                'referencia' => $request->referencia,
                'parroquia_id' => $request->parroquia_id,
                'sector' => $request->sector,
                'motivo_llamado' => $request->motivo_llamado,
                'tipo_fuego' => $request->tipo_fuego,
                'nivel_riesgo' => $request->nivel_riesgo,
                'causa_probable' => $request->causa_probable,
                'area_afectada_m2' => $request->area_afectada_m2,
                'perdidas_estimadas' => $request->perdidas_estimadas,
                'moneda' => $request->moneda ?? 'USD',
                'agua_utilizada_litros' => $request->agua_utilizada_litros,
                'espuma_utilizada_litros' => $request->espuma_utilizada_litros,
                'quimico_utilizado_litros' => $request->quimico_utilizado_litros,
                'victimas_ilesos' => $request->victimas_ilesos ?? 0,
                'victimas_heridos' => $request->victimas_heridos ?? 0,
                'victimas_fallecidos' => $request->victimas_fallecidos ?? 0,
                'requirio_apoyo_externo' => $request->has('requirio_apoyo_externo'),
                'detalle_apoyo' => $request->detalle_apoyo,
                'usuario_registra_id' => auth()->id(),
                'observaciones_generales' => $request->observaciones_generales,
                'estado' => 'En curso',
            ]);

            // Personal
            foreach ($request->personal as $p) {
                $emergencia->personal()->attach($p['user_id'], [
                    'rol_en_emergencia' => $p['rol_en_emergencia']
                ]);
            }

            // Vehículos
            foreach ($request->vehiculos as $v) {
                $emergencia->vehiculos()->attach($v['vehiculo_id'], [
                    'rol_en_emergencia' => $v['rol_en_emergencia'] ?? null,
                    'km_salida' => $v['km_salida'] ?? null,
                    'km_llegada' => $v['km_llegada'] ?? null,
                ]);
            }

            // Pacientes (opcional)
            if ($request->has('pacientes')) {
                foreach ($request->pacientes as $pac) {
                    if (empty($pac['nombre_completo'])) continue;
                    PacienteEmergenciaFuego::create([
                        'emergencia_fuego_id' => $emergencia->id,
                        'nombre_completo' => $pac['nombre_completo'],
                        'edad' => $pac['edad'] ?? null,
                        'sexo' => $pac['sexo'] ?? 'Indefinido',
                        'cedula' => $pac['cedula'] ?? null,
                        'telefono' => $pac['telefono'] ?? null,
                        'condicion' => $pac['condicion'] ?? 'Ileso',
                        'tipo_lesion' => $pac['tipo_lesion'] ?? null,
                        'hospital_destino' => $pac['hospital_destino'] ?? null,
                        'frecuencia_cardiaca' => $pac['frecuencia_cardiaca'] ?? null,
                        'frecuencia_respiratoria' => $pac['frecuencia_respiratoria'] ?? null,
                        'saturacion_oxigeno' => $pac['saturacion_oxigeno'] ?? null,
                        'temperatura' => $pac['temperatura'] ?? null,
                        'observaciones' => $pac['observaciones'] ?? null,
                    ]);
                }
            }

            // Insumos
            if ($request->has('insumos')) {
                foreach ($request->insumos as $ins) {
                    $emergencia->insumos()->attach($ins['insumo_medico_id'], [
                        'cantidad' => $ins['cantidad'],
                        'observaciones' => $ins['observaciones'] ?? null,
                    ]);

                    InsumoMedico::where('id', $ins['insumo_medico_id'])
                                ->decrement('cantidad', $ins['cantidad']);
                }
            }
            // Herramientas
            if ($request->has('herramientas')) {
                foreach ($request->herramientas as $herr) {
                    if (empty($herr['herramienta_id'])) continue;
                    $emergencia->herramientas()->attach($herr['herramienta_id'], [
                        'cantidad' => $herr['cantidad'] ?? 1,
                        'observaciones' => $herr['observaciones'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('emergencias-fuego.show', $emergencia)
                ->with('success', 'Emergencia de fuego registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ============================================================
    //  SHOW
    // ============================================================
    public function show(EmergenciaFuego $emergenciaFuego)
    {
        $emergenciaFuego->load([
            'vehiculos', 'usuarioRegistra', 'personal', 'pacientes', 'insumos', 'archivos'
        ]);

        return view('emergencias_fuego.show', compact('emergenciaFuego'));
    }

    // ============================================================
    //  EDIT
    // ============================================================
    public function edit(EmergenciaFuego $emergenciaFuego)
    {
        $emergenciaFuego->load(['personal', 'pacientes', 'insumos', 'vehiculos', 'archivos', 'herramientas']);

        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();
        $insumos = InsumoMedico::orderBy('descripcion')->get();
        $parroquias = \App\Parroquia::orderBy('nombre')->get();
        $herramientas = \App\Herramienta::orderBy('descripcion')->get();
        $tipos = EmergenciaFuego::getTiposFuego();
        $niveles = EmergenciaFuego::getNivelesRiesgo();
        $estados = EmergenciaFuego::getEstados();

        return view('emergencias_fuego.edit', compact(
            'emergenciaFuego', 'vehiculos', 'personal', 'insumos',
            'parroquias', 'herramientas', 'tipos', 'niveles', 'estados'
        ));
    }

    // ============================================================
    //  UPDATE
    // ============================================================
    public function update(Request $request, EmergenciaFuego $emergenciaFuego)
    {
        $request->validate([
            'fecha_salida' => 'required|date',
            'direccion' => 'required|string|max:255',
            'motivo_llamado' => 'required|string|max:255',
            'tipo_fuego' => 'required|string',
            'nivel_riesgo' => 'required|in:Bajo,Medio,Alto,Crítico',
            'estado' => 'required|string',
            'personal' => 'required|array|min:1',
            'vehiculos' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $emergenciaFuego->update([
                'fecha_salida' => $request->fecha_salida,
                'fecha_llegada_sitio' => $request->fecha_llegada_sitio,
                'fecha_control' => $request->fecha_control,
                'fecha_extincion' => $request->fecha_extincion,
                'fecha_llegada_base' => $request->fecha_llegada_base,
                'direccion' => $request->direccion,
                'referencia' => $request->referencia,
                'parroquia_id' => $request->parroquiia_id,
                'sector' => $request->sector,
                'motivo_llamado' => $request->motivo_llamado,
                'tipo_fuego' => $request->tipo_fuego,
                'nivel_riesgo' => $request->nivel_riesgo,
                'causa_probable' => $request->causa_probable,
                'area_afectada_m2' => $request->area_afectada_m2,
                'perdidas_estimadas' => $request->perdidas_estimadas,
                'agua_utilizada_litros' => $request->agua_utilizada_litros,
                'espuma_utilizada_litros' => $request->espuma_utilizada_litros,
                'quimico_utilizado_litros' => $request->quimico_utilizado_litros,
                'victimas_ilesos' => $request->victimas_ilesos ?? 0,
                'victimas_heridos' => $request->victimas_heridos ?? 0,
                'victimas_fallecidos' => $request->victimas_fallecidos ?? 0,
                'requirio_apoyo_externo' => $request->has('requirio_apoyo_externo'),
                'detalle_apoyo' => $request->detalle_apoyo,
                'observaciones_generales' => $request->observaciones_generales,
                'estado' => $request->estado,
            ]);

            // Personal
            $personalSync = [];
            foreach ($request->personal as $p) {
                $personalSync[$p['user_id']] = ['rol_en_emergencia' => $p['rol_en_emergencia']];
            }
            $emergenciaFuego->personal()->sync($personalSync);

            // Vehículos
            $vehiculosSync = [];
            foreach ($request->vehiculos as $v) {
                $vehiculosSync[$v['vehiculo_id']] = [
                    'rol_en_emergencia' => $v['rol_en_emergencia'] ?? null,
                    'km_salida' => $v['km_salida'] ?? null,
                    'km_llegada' => $v['km_llegada'] ?? null,
                ];
            }
            $emergenciaFuego->vehiculos()->sync($vehiculosSync);

            // Pacientes
            $emergenciaFuego->pacientes()->delete();
            if ($request->has('pacientes')) {
                foreach ($request->pacientes as $pac) {
                    if (empty($pac['nombre_completo'])) continue;
                    PacienteEmergenciaFuego::create([
                        'emergencia_fuego_id' => $emergenciaFuego->id,
                        'nombre_completo' => $pac['nombre_completo'],
                        'edad' => $pac['edad'] ?? null,
                        'sexo' => $pac['sexo'] ?? 'Indefinido',
                        'cedula' => $pac['cedula'] ?? null,
                        'telefono' => $pac['telefono'] ?? null,
                        'condicion' => $pac['condicion'] ?? 'Ileso',
                        'tipo_lesion' => $pac['tipo_lesion'] ?? null,
                        'hospital_destino' => $pac['hospital_destino'] ?? null,
                        'frecuencia_cardiaca' => $pac['frecuencia_cardiaca'] ?? null,
                        'frecuencia_respiratoria' => $pac['frecuencia_respiratoria'] ?? null,
                        'saturacion_oxigeno' => $pac['saturacion_oxigeno'] ?? null,
                        'temperatura' => $pac['temperatura'] ?? null,
                        'observaciones' => $pac['observaciones'] ?? null,
                    ]);
                }
            }

            // Insumos: restaurar y reinsertar
            foreach ($emergenciaFuego->insumos as $insumoViejo) {
                InsumoMedico::where('id', $insumoViejo->id)
                            ->increment('cantidad', $insumoViejo->pivot->cantidad);
            }
            $emergenciaFuego->insumos()->detach();

            if ($request->has('insumos')) {
                foreach ($request->insumos as $ins) {
                    $emergenciaFuego->insumos()->attach($ins['insumo_medico_id'], [
                        'cantidad' => $ins['cantidad'],
                        'observaciones' => $ins['observaciones'] ?? null,
                    ]);
                    InsumoMedico::where('id', $ins['insumo_medico_id'])
                                ->decrement('cantidad', $ins['cantidad']);
                }
            }
            // Herramientas: re-sincronizar
            $emergenciaFuego->herramientas()->detach();
            if ($request->has('herramientas')) {
                foreach ($request->herramientas as $herr) {
                    if (empty($herr['herramienta_id'])) continue;
                    $emergenciaFuego->herramientas()->attach($herr['herramienta_id'], [
                        'cantidad' => $herr['cantidad'] ?? 1,
                        'observaciones' => $herr['observaciones'] ?? null,
                    ]);
                }
            }




            DB::commit();

            return redirect()
                ->route('emergencias-fuego.show', $emergenciaFuego)
                ->with('success', 'Emergencia de fuego actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ============================================================
    //  DESTROY
    // ============================================================
    public function destroy(EmergenciaFuego $emergenciaFuego)
    {
        // Restaurar stock de insumos
        foreach ($emergenciaFuego->insumos as $ins) {
            InsumoMedico::where('id', $ins->id)->increment('cantidad', $ins->pivot->cantidad);
        }

        // Eliminar archivos del storage
        foreach ($emergenciaFuego->archivos as $archivo) {
            if (Storage::disk('public')->exists($archivo->ruta)) {
                Storage::disk('public')->delete($archivo->ruta);
            }
        }

        $emergenciaFuego->delete();

        return redirect()
            ->route('emergencias-fuego.index')
            ->with('success', 'Emergencia de fuego eliminada correctamente.');
    }

    // ============================================================
    //  ARCHIVOS
    // ============================================================
    public function subirArchivos(Request $request, EmergenciaFuego $emergenciaFuego)
    {
        $limiteTotalMb = config('filesystems.emergencias_archivos.limite_mb', 50);
        $limiteArchivoMb = config('filesystems.emergencias_archivos.max_archivo_mb', 10);
        $limiteTotalBytes = $limiteTotalMb * 1024 * 1024;

        $request->validate([
            'archivos' => 'required|array|min:1',
            'archivos.*' => 'file|max:' . ($limiteArchivoMb * 1024),
        ], [
            'archivos.*.max' => "Cada archivo no puede superar los {$limiteArchivoMb}MB.",
        ]);

        $espacioUsado = $emergenciaFuego->archivos()->sum('tamano') ?? 0;
        $tamanoNuevos = 0;
        foreach ($request->file('archivos') as $archivo) {
            $tamanoNuevos += $archivo->getSize();
        }

        if (($espacioUsado + $tamanoNuevos) > $limiteTotalBytes) {
            $disponible = round(($limiteTotalBytes - $espacioUsado) / 1024 / 1024, 2);
            return back()->with('error', "No hay espacio suficiente. Disponible: {$disponible}MB.");
        }

        $subidos = 0;
        foreach ($request->file('archivos') as $archivo) {
            $carpeta = 'emergencias_fuego/' . $emergenciaFuego->id;
            if (!Storage::disk('public')->exists($carpeta)) {
                Storage::disk('public')->makeDirectory($carpeta);
            }

            $nombreOriginal = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = time() . '_' . uniqid() . '.' . $extension;

            $ruta = $archivo->storeAs($carpeta, $nombreArchivo, 'public');

            EmergenciaFuegoArchivo::create([
                'emergencia_fuego_id' => $emergenciaFuego->id,
                'nombre_original' => $nombreOriginal,
                'nombre_archivo' => $nombreArchivo,
                'ruta' => $ruta,
                'tipo' => $archivo->getClientMimeType(),
                'mime_type' => $archivo->getClientMimeType(),
                'tamano' => $archivo->getSize(),
                'usuario_subio_id' => auth()->id(),
            ]);

            $subidos++;
        }

        return redirect()
            ->route('emergencias-fuego.show', $emergenciaFuego)
            ->with('success', "{$subidos} archivo(s) subido(s) correctamente.");
    }

    public function eliminarArchivo(EmergenciaFuegoArchivo $archivo)
    {
        $emergenciaId = $archivo->emergencia_fuego_id;

        if (Storage::disk('public')->exists($archivo->ruta)) {
            Storage::disk('public')->delete($archivo->ruta);
        }
        $archivo->delete();

        return redirect()
            ->route('emergencias-fuego.show', $emergenciaId)
            ->with('success', 'Archivo eliminado correctamente.');
    }

    public function descargarArchivo(EmergenciaFuegoArchivo $archivo)
    {
        $ruta = storage_path('app/public/' . $archivo->ruta);
        if (!file_exists($ruta)) {
            abort(404, 'El archivo no existe.');
        }
        return response()->download($ruta, $archivo->nombre_original);
    }

    // ============================================================
    //  PDF
    // ============================================================
    public function generarPdf(EmergenciaFuego $emergenciaFuego)
    {
        require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');

        $emergenciaFuego->load([
            'vehiculos', 'usuarioRegistra', 'personal', 'pacientes', 'insumos'
        ]);

        $tiempos = $this->calcularTiempos($emergenciaFuego);

        $html = view('emergencias_fuego.pdf.parte_bomberos',
            compact('emergenciaFuego', 'tiempos'))->render();

        $pdf = new \TCPDF('L', 'mm', 'LETTER', true, 'UTF-8', false);

        $pdf->SetCreator('Sistema de Bomberos');
        $pdf->SetAuthor($emergenciaFuego->usuarioRegistra->name ?? 'Sistema');
        $pdf->SetTitle('Parte de Bomberos - ' . $emergenciaFuego->codigo);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(8, 8, 8);
        $pdf->SetAutoPageBreak(true, 12);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        $nombreArchivo = 'Parte_Bomberos_' . $emergenciaFuego->codigo . '.pdf';
        return $pdf->Output($nombreArchivo, 'I');
    }

    private function calcularTiempos(EmergenciaFuego $e)
    {
        $tiempos = [
            'tiempo_respuesta' => null,
            'tiempo_control' => null,
            'tiempo_extincion' => null,
            'tiempo_total' => null,
        ];

        if ($e->fecha_salida && $e->fecha_llegada_sitio) {
            $tiempos['tiempo_respuesta'] = $e->fecha_salida->diffInMinutes($e->fecha_llegada_sitio);
        }
        if ($e->fecha_llegada_sitio && $e->fecha_control) {
            $tiempos['tiempo_control'] = $e->fecha_llegada_sitio->diffInMinutes($e->fecha_control);
        }
        if ($e->fecha_control && $e->fecha_extincion) {
            $tiempos['tiempo_extincion'] = $e->fecha_control->diffInMinutes($e->fecha_extincion);
        }
        if ($e->fecha_salida && $e->fecha_llegada_base) {
            $tiempos['tiempo_total'] = $e->fecha_salida->diffInMinutes($e->fecha_llegada_base);
        }

        return $tiempos;
    }

    // ============================================================
    //  ESTADÍSTICAS
    // ============================================================
    public function estadisticas(Request $request)
    {
        $fechaDesde = $request->filled('fecha_desde')
            ? Carbon::parse($request->fecha_desde)->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $fechaHasta = $request->filled('fecha_hasta')
            ? Carbon::parse($request->fecha_hasta)->endOfDay()
            : Carbon::now()->endOfDay();

        $baseQuery = EmergenciaFuego::whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);

        $resumen = [
            'total' => (clone $baseQuery)->count(),
            'en_curso' => (clone $baseQuery)->where('estado', 'En curso')->count(),
            'extinguidos' => (clone $baseQuery)->where('estado', 'Extinguido')->count(),
            'total_agua' => round((clone $baseQuery)->sum('agua_utilizada_litros'), 2),
            'total_perdidas' => round((clone $baseQuery)->sum('perdidas_estimadas'), 2),
            'total_heridos' => (clone $baseQuery)->sum('victimas_heridos'),
            'total_fallecidos' => (clone $baseQuery)->sum('victimas_fallecidos'),
        ];

        $porTipo = (clone $baseQuery)
            ->select('tipo_fuego', DB::raw('count(*) as total'))
            ->groupBy('tipo_fuego')
            ->orderByDesc('total')
            ->get();

        $porNivel = (clone $baseQuery)
            ->select('nivel_riesgo', DB::raw('count(*) as total'))
            ->groupBy('nivel_riesgo')
            ->get();

        $porEstado = (clone $baseQuery)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        $tendencia = (clone $baseQuery)
            ->select(DB::raw('DATE(fecha_salida) as fecha'), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $tendenciaCompleta = collect();
        $cursor = $fechaDesde->copy();
        while ($cursor <= $fechaHasta) {
            $fechaStr = $cursor->format('Y-m-d');
            $encontrado = $tendencia->firstWhere('fecha', $fechaStr);
            $tendenciaCompleta->push([
                'fecha' => $cursor->format('d/m'),
                'total' => $encontrado ? $encontrado->total : 0,
            ]);
            $cursor->addDay();
        }

        $topVehiculos = (clone $baseQuery)
            ->join('emergencia_fuego_vehiculos', 'emergencias_fuego.id', '=', 'emergencia_fuego_vehiculos.emergencia_fuego_id')
            ->join('vehiculos', 'vehiculos.id', '=', 'emergencia_fuego_vehiculos.vehiculo_id')
            ->select('vehiculos.placa', 'vehiculos.marca', DB::raw('count(*) as total'))
            ->groupBy('vehiculos.id', 'vehiculos.placa', 'vehiculos.marca')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topPersonal = DB::table('emergencia_fuego_personal')
            ->join('emergencias_fuego', 'emergencias_fuego.id', '=', 'emergencia_fuego_personal.emergencia_fuego_id')
            ->join('users', 'users.id', '=', 'emergencia_fuego_personal.user_id')
            ->whereBetween('emergencias_fuego.fecha_salida', [$fechaDesde, $fechaHasta])
            ->select('users.name', DB::raw('count(*) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topCausas = (clone $baseQuery)
            ->whereNotNull('causa_probable')
            ->select('causa_probable', DB::raw('count(*) as total'))
            ->groupBy('causa_probable')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('emergencias_fuego.estadisticas', compact(
            'resumen', 'porTipo', 'porNivel', 'porEstado', 'tendenciaCompleta',
            'topVehiculos', 'topPersonal', 'topCausas',
            'fechaDesde', 'fechaHasta'
        ));
    }
}