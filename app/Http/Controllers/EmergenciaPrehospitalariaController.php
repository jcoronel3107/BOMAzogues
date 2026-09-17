<?php
namespace App\Http\Controllers;

use App\EmergenciaPrehospitalaria;
use App\PacienteEmergencia;
use App\InsumoMedico;
use App\Vehiculo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EmergenciaPrehospitalariaController extends Controller
{
    public function index(Request $request)
    {
        $query = EmergenciaPrehospitalaria::with([
            'vehiculo', 'usuarioRegistra', 'pacientes', 'personal'
        ]);

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
        if ($request->filled('prioridad')) $query->where('prioridad', $request->prioridad);
        if ($request->filled('tipo_emergencia')) $query->where('tipo_emergencia', $request->tipo_emergencia);
        if ($request->filled('vehiculo_id')) $query->where('vehiculo_id', $request->vehiculo_id);

        if ($request->filled('user_id')) {
            $query->whereHas('personal', function ($q) use ($request) {
                $q->where('users.id', $request->user_id);
            });
        }

        if ($request->filled('fecha_desde')) $query->whereDate('fecha_salida', '>=', $request->fecha_desde);
        if ($request->filled('fecha_hasta')) $query->whereDate('fecha_salida', '<=', $request->fecha_hasta);

        $orden = $request->get('orden', 'fecha_salida');
        $direccion = $request->get('direccion', 'desc');
        $columnasPermitidas = ['codigo', 'fecha_salida', 'prioridad', 'estado', 'created_at'];

        if (in_array($orden, $columnasPermitidas)) {
            $query->orderBy($orden, $direccion === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('fecha_salida', 'desc');
        }

        $perPage = $request->get('per_page', 10);
        $emergencias = $query->paginate($perPage)->withQueryString();

        $resumen = [
            'total' => EmergenciaPrehospitalaria::count(),
            'en_curso' => EmergenciaPrehospitalaria::where('estado', 'En curso')->count(),
            'finalizadas' => EmergenciaPrehospitalaria::where('estado', 'Finalizada')->count(),
            'hoy' => EmergenciaPrehospitalaria::whereDate('fecha_salida', today())->count(),
        ];

        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();
        $tipos = ['Accidente de tránsito', 'Emergencia médica', 'Trauma', 'Obstétrica', 'Pediatrica', 'Psiquiatrica', 'Otra'];
        $estados = ['En curso', 'Finalizada', 'Cancelada', 'Derivada'];
        $prioridades = ['Rojo', 'Naranja', 'Amarillo', 'Verde', 'Azul'];

        return view('emergencias_prehospitalarias.index', compact(
            'emergencias', 'resumen', 'vehiculos', 'personal',
            'tipos', 'estados', 'prioridades'
        ));
    }

    public function create()
{
    $vehiculos = Vehiculo::orderBy('placa')->get();
    $personal = User::orderBy('name')->get();
    $insumos = InsumoMedico::orderBy('descripcion')->get();

    return view('emergencias_prehospitalarias.create', 
        compact('vehiculos', 'personal', 'insumos'));
}

    public function store(Request $request)
    {
        $request->validate([
            'fecha_salida' => 'required|date',
            'direccion' => 'required|string|max:255',
            'motivo_llamado' => 'required|string|max:255',
            'tipo_emergencia' => 'required|string',
            'prioridad' => 'required|in:Rojo,Naranja,Amarillo,Verde,Azul',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'personal' => 'required|array|min:1',
            'personal.*.user_id' => 'required|exists:users,id',
            'personal.*.rol_en_emergencia' => 'required|string',
            'pacientes' => 'required|array|min:1',
            'pacientes.*.nombre_completo' => 'required|string|max:150',
            'pacientes.*.edad' => 'required|integer|min:0|max:120',
            'pacientes.*.sexo' => 'required|in:M,F,Indefinido',
            'insumos' => 'nullable|array',
            'insumos.*.insumo_medico_id' => 'required|exists:insumos_medicos,id',
            'insumos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $emergencia = EmergenciaPrehospitalaria::create([
                'codigo' => EmergenciaPrehospitalaria::generarCodigo(),
                'fecha_salida' => $request->fecha_salida,
                'fecha_llegada_sitio' => $request->fecha_llegada_sitio,
                'fecha_salida_sitio' => $request->fecha_salida_sitio,
                'fecha_llegada_base' => $request->fecha_llegada_base,
                'direccion' => $request->direccion,
                'referencia' => $request->referencia,
                'motivo_llamado' => $request->motivo_llamado,
                'tipo_emergencia' => $request->tipo_emergencia,
                'prioridad' => $request->prioridad,
                'vehiculo_id' => $request->vehiculo_id,
                'usuario_registra_id' => auth()->id(),
                'observaciones_generales' => $request->observaciones_generales,
                'estado' => 'En curso',
            ]);

            foreach ($request->personal as $p) {
                $emergencia->personal()->attach($p['user_id'], [
                    'rol_en_emergencia' => $p['rol_en_emergencia']
                ]);
            }

            foreach ($request->pacientes as $pac) {
                PacienteEmergencia::create([
                    'emergencia_prehospitalaria_id' => $emergencia->id,
                    'nombre_completo' => $pac['nombre_completo'],
                    'edad' => $pac['edad'],
                    'sexo' => $pac['sexo'],
                    'cedula' => $pac['cedula'] ?? null,
                    'telefono' => $pac['telefono'] ?? null,
                    'frecuencia_cardiaca' => $pac['frecuencia_cardiaca'] ?? null,
                    'frecuencia_respiratoria' => $pac['frecuencia_respiratoria'] ?? null,
                    'saturacion_oxigeno' => $pac['saturacion_oxigeno'] ?? null,
                    'temperatura' => $pac['temperatura'] ?? null,
                    'presion_sistolica' => $pac['presion_sistolica'] ?? null,
                    'presion_diastolica' => $pac['presion_diastolica'] ?? null,
                    'glasgow' => $pac['glasgow'] ?? null,
                    'motivo_atencion' => $pac['motivo_atencion'] ?? null,
                    'evaluacion' => $pac['evaluacion'] ?? null,
                    'procedimientos_realizados' => $pac['procedimientos_realizados'] ?? null,
                    'observaciones' => $pac['observaciones'] ?? null,
                    'condicion' => $pac['condicion'] ?? 'Estable',
                    'destino' => $pac['destino'] ?? null,
                    'hospital_destino' => $pac['hospital_destino'] ?? null,
                ]);
            }

            if ($request->has('insumos')) {
                foreach ($request->insumos as $ins) {
                    $emergencia->insumos()->attach($ins['insumo_medico_id'], [
                        'cantidad' => $ins['cantidad'],
                        'observaciones' => $ins['observaciones'] ?? null,
                    ]);

                    // ✅ CAMBIO: 'cantidad' en lugar de 'stock'
                    InsumoMedico::where('id', $ins['insumo_medico_id'])
                                ->decrement('cantidad', $ins['cantidad']);
                }
            }

            DB::commit();
            //dd('¡GUARDADO EXITOSO!', $emergencia->id);  // ⬅️ AGREGA ESTA LÍNEA TEMPORAL
            return redirect()->route('emergencias-prehospitalarias.show', $emergencia)
                            ->with('success', 'Emergencia prehospitalaria registrada');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $emergenciaPrehospitalaria->load([
            'vehiculo', 'usuarioRegistra', 'personal', 'pacientes', 'insumos'
        ]);
        return view('emergencias_prehospitalarias.show', compact('emergenciaPrehospitalaria'));
    }

    public function edit(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $emergenciaPrehospitalaria->load(['personal', 'pacientes', 'insumos']);
        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();
        $insumos = InsumoMedico::orderBy('descripcion')->get();

        return view('emergencias_prehospitalarias.edit', compact(
            'emergenciaPrehospitalaria', 'vehiculos', 'personal', 'insumos'
        ));
    }

    public function update(Request $request, EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $request->validate([
            'fecha_salida' => 'required|date',
            'direccion' => 'required|string|max:255',
            'motivo_llamado' => 'required|string|max:255',
            'tipo_emergencia' => 'required|string',
            'prioridad' => 'required|in:Rojo,Naranja,Amarillo,Verde,Azul',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'estado' => 'required|in:En curso,Finalizada,Cancelada,Derivada',
            'personal' => 'required|array|min:1',
            'personal.*.user_id' => 'required|exists:users,id',
            'personal.*.rol_en_emergencia' => 'required|string',
            'pacientes' => 'required|array|min:1',
            'pacientes.*.nombre_completo' => 'required|string|max:150',
            'pacientes.*.edad' => 'required|integer|min:0|max:120',
            'pacientes.*.sexo' => 'required|in:M,F,Indefinido',
            'insumos' => 'nullable|array',
            'insumos.*.insumo_medico_id' => 'required|exists:insumos_medicos,id',
            'insumos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $emergenciaPrehospitalaria->update([
                'fecha_salida' => $request->fecha_salida,
                'fecha_llegada_sitio' => $request->fecha_llegada_sitio,
                'fecha_salida_sitio' => $request->fecha_salida_sitio,
                'fecha_llegada_base' => $request->fecha_llegada_base,
                'direccion' => $request->direccion,
                'referencia' => $request->referencia,
                'motivo_llamado' => $request->motivo_llamado,
                'tipo_emergencia' => $request->tipo_emergencia,
                'prioridad' => $request->prioridad,
                'vehiculo_id' => $request->vehiculo_id,
                'observaciones_generales' => $request->observaciones_generales,
                'estado' => $request->estado,
            ]);

            // Personal
            $personalSync = [];
            foreach ($request->personal as $p) {
                $personalSync[$p['user_id']] = ['rol_en_emergencia' => $p['rol_en_emergencia']];
            }
            $emergenciaPrehospitalaria->personal()->sync($personalSync);

            // Pacientes
            $emergenciaPrehospitalaria->pacientes()->delete();

            foreach ($request->pacientes as $pac) {
                PacienteEmergencia::create([
                    'emergencia_prehospitalaria_id' => $emergenciaPrehospitalaria->id,
                    'nombre_completo' => $pac['nombre_completo'],
                    'edad' => $pac['edad'],
                    'sexo' => $pac['sexo'],
                    'cedula' => $pac['cedula'] ?? null,
                    'telefono' => $pac['telefono'] ?? null,
                    'frecuencia_cardiaca' => $pac['frecuencia_cardiaca'] ?? null,
                    'frecuencia_respiratoria' => $pac['frecuencia_respiratoria'] ?? null,
                    'saturacion_oxigeno' => $pac['saturacion_oxigeno'] ?? null,
                    'temperatura' => $pac['temperatura'] ?? null,
                    'presion_sistolica' => $pac['presion_sistolica'] ?? null,
                    'presion_diastolica' => $pac['presion_diastolica'] ?? null,
                    'glasgow' => $pac['glasgow'] ?? null,
                    'motivo_atencion' => $pac['motivo_atencion'] ?? null,
                    'evaluacion' => $pac['evaluacion'] ?? null,
                    'procedimientos_realizados' => $pac['procedimientos_realizados'] ?? null,
                    'observaciones' => $pac['observaciones'] ?? null,
                    'condicion' => $pac['condicion'] ?? 'Estable',
                    'destino' => $pac['destino'] ?? null,
                    'hospital_destino' => $pac['hospital_destino'] ?? null,
                ]);
            }

            // Insumos: restaurar y reinsertar
            foreach ($emergenciaPrehospitalaria->insumos as $insumoViejo) {
                // ✅ CAMBIO: 'cantidad' en lugar de 'stock'
                InsumoMedico::where('id', $insumoViejo->id)
                            ->increment('cantidad', $insumoViejo->pivot->cantidad);
            }

            $emergenciaPrehospitalaria->insumos()->detach();

            if ($request->has('insumos')) {
                foreach ($request->insumos as $ins) {
                    $emergenciaPrehospitalaria->insumos()->attach($ins['insumo_medico_id'], [
                        'cantidad' => $ins['cantidad'],
                        'observaciones' => $ins['observaciones'] ?? null,
                    ]);

                    // ✅ CAMBIO: 'cantidad' en lugar de 'stock'
                    InsumoMedico::where('id', $ins['insumo_medico_id'])
                                ->decrement('cantidad', $ins['cantidad']);
                }
            }

            DB::commit();
            return redirect()->route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria)
                            ->with('success', 'Emergencia prehospitalaria actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        foreach ($emergenciaPrehospitalaria->insumos as $ins) {
            // ✅ CAMBIO: 'cantidad' en lugar de 'stock'
            InsumoMedico::where('id', $ins->id)->increment('cantidad', $ins->pivot->cantidad);
        }

        $emergenciaPrehospitalaria->delete();
        return redirect()->route('emergencias-prehospitalarias.index')
                        ->with('success', 'Emergencia eliminada');
    }

    public function generarPdf(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
{
    // ⬇️ CARGAR TCPDF MANUALMENTE
    require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');

    // Cargar relaciones
    $emergenciaPrehospitalaria->load([
        'vehiculo', 'usuarioRegistra', 'personal', 'pacientes', 'insumos'
    ]);

    // Calcular tiempos
    $tiempos = $this->calcularTiempos($emergenciaPrehospitalaria);

    // Renderizar la vista a HTML
    $html = view('emergencias_prehospitalarias.pdf.parte_tcpdf',
        compact('emergenciaPrehospitalaria', 'tiempos'))->render();

    // Crear el PDF con TCPDF
    // ⚠️ TCPDF 7.x usa namespace tecnickcom\tcpdf\TCPDF
    $pdf = new \TCPDF('L', 'mm', 'LETTER', true, 'UTF-8', false);

    // Configuración del documento
    $pdf->SetCreator('Sistema de Emergencias');
    $pdf->SetAuthor($emergenciaPrehospitalaria->usuarioRegistra->name ?? 'Sistema');
    $pdf->SetTitle('Parte de Ambulancia - ' . $emergenciaPrehospitalaria->codigo);
    $pdf->SetSubject('Parte de Atención Prehospitalaria');

    // Quitar header y footer por defecto
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Márgenes
    $pdf->SetMargins(8, 8, 8);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // Agregar página
    $pdf->AddPage();

    // Escribir el HTML
    $pdf->writeHTML($html, true, false, true, false, '');

    // Nombre del archivo
    $nombreArchivo = 'Parte_Ambulancia_' . $emergenciaPrehospitalaria->codigo . '.pdf';

    // Salida: 'I' = inline (ver en navegador), 'D' = descargar
    return $pdf->Output($nombreArchivo, 'I');
}

    private function calcularTiempos(EmergenciaPrehospitalaria $e)
    {
        $tiempos = [
            'tiempo_respuesta' => null,
            'tiempo_en_sitio' => null,
            'tiempo_traslado' => null,
            'tiempo_total' => null,
        ];

        if ($e->fecha_salida && $e->fecha_llegada_sitio) {
            $tiempos['tiempo_respuesta'] = $e->fecha_salida->diffInMinutes($e->fecha_llegada_sitio);
        }
        if ($e->fecha_llegada_sitio && $e->fecha_salida_sitio) {
            $tiempos['tiempo_en_sitio'] = $e->fecha_llegada_sitio->diffInMinutes($e->fecha_salida_sitio);
        }
        if ($e->fecha_salida_sitio && $e->fecha_llegada_base) {
            $tiempos['tiempo_traslado'] = $e->fecha_salida_sitio->diffInMinutes($e->fecha_llegada_base);
        }
        if ($e->fecha_salida && $e->fecha_llegada_base) {
            $tiempos['tiempo_total'] = $e->fecha_salida->diffInMinutes($e->fecha_llegada_base);
        }

        return $tiempos;
    }

    public function estadisticas(Request $request)
    {
        $fechaDesde = $request->filled('fecha_desde')
            ? Carbon::parse($request->fecha_desde)->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $fechaHasta = $request->filled('fecha_hasta')
            ? Carbon::parse($request->fecha_hasta)->endOfDay()
            : Carbon::now()->endOfDay();

        $baseQuery = EmergenciaPrehospitalaria::whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);

        $resumen = [
            'total' => (clone $baseQuery)->count(),
            'en_curso' => (clone $baseQuery)->where('estado', 'En curso')->count(),
            'finalizadas' => (clone $baseQuery)->where('estado', 'Finalizada')->count(),
            'canceladas' => (clone $baseQuery)->where('estado', 'Cancelada')->count(),
            'total_pacientes' => PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
            })->count(),
            'promedio_pacientes' => round(
                PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                    $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
                })->count() / max((clone $baseQuery)->count(), 1),
                2
            ),
        ];

        $porTipo = (clone $baseQuery)
            ->select('tipo_emergencia', DB::raw('count(*) as total'))
            ->groupBy('tipo_emergencia')
            ->orderByDesc('total')
            ->get();

        $porPrioridad = (clone $baseQuery)
            ->select('prioridad', DB::raw('count(*) as total'))
            ->groupBy('prioridad')
            ->get()
            ->sortBy(function ($item) {
                $orden = ['Rojo' => 1, 'Naranja' => 2, 'Amarillo' => 3, 'Verde' => 4, 'Azul' => 5];
                return $orden[$item->prioridad] ?? 99;
            })
            ->values();

        $porEstado = (clone $baseQuery)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        $diasDiferencia = $fechaDesde->diffInDays($fechaHasta);

        if ($diasDiferencia <= 31) {
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
        } else {
            $tendencia = (clone $baseQuery)
                ->select(DB::raw("DATE_FORMAT(fecha_salida, '%Y-%m') as mes"), DB::raw('count(*) as total'))
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();

            $tendenciaCompleta = $tendencia->map(function ($item) {
                return [
                    'fecha' => Carbon::createFromFormat('Y-m', $item->mes)->format('M Y'),
                    'total' => $item->total,
                ];
            });
        }

        $topVehiculos = (clone $baseQuery)
            ->select('vehiculo_id', DB::raw('count(*) as total'))
            ->with('vehiculo:id,placa,marca')
            ->groupBy('vehiculo_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topPersonal = DB::table('emergencia_personal')
            ->join('emergencias_prehospitalarias', 'emergencias_prehospitalarias.id', '=', 'emergencia_personal.emergencia_prehospitalaria_id')
            ->join('users', 'users.id', '=', 'emergencia_personal.user_id')
            ->whereBetween('emergencias_prehospitalarias.fecha_salida', [$fechaDesde, $fechaHasta])
            ->select('users.name', DB::raw('count(*) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ✅ CAMBIO: 'descripcion' en lugar de 'nombre'
        $topInsumos = DB::table('emergencia_insumos')
            ->join('emergencias_prehospitalarias', 'emergencias_prehospitalarias.id', '=', 'emergencia_insumos.emergencia_prehospitalaria_id')
            ->join('insumos_medicos', 'insumos_medicos.id', '=', 'emergencia_insumos.insumo_medico_id')
            ->whereBetween('emergencias_prehospitalarias.fecha_salida', [$fechaDesde, $fechaHasta])
            ->select(
                'insumos_medicos.descripcion',
                DB::raw('SUM(emergencia_insumos.cantidad) as total')
            )
            ->groupBy('insumos_medicos.id', 'insumos_medicos.descripcion')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $porSexo = PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
            })
            ->select('sexo', DB::raw('count(*) as total'))
            ->groupBy('sexo')
            ->get();

        $porCondicion = PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
            })
            ->select('condicion', DB::raw('count(*) as total'))
            ->groupBy('condicion')
            ->get();

        $promediosSignos = PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
            })
            ->selectRaw('
                ROUND(AVG(frecuencia_cardiaca), 1) as fc_promedio,
                ROUND(AVG(frecuencia_respiratoria), 1) as fr_promedio,
                ROUND(AVG(saturacion_oxigeno), 1) as sat_promedio,
                ROUND(AVG(temperatura), 2) as temp_promedio,
                ROUND(AVG(presion_sistolica), 1) as ps_promedio,
                ROUND(AVG(presion_diastolica), 1) as pd_promedio,
                ROUND(AVG(glasgow), 1) as glasgow_promedio
            ')
            ->first();

        return view('emergencias_prehospitalarias.estadisticas', compact(
            'resumen', 'porTipo', 'porPrioridad', 'porEstado',
            'tendenciaCompleta', 'topVehiculos', 'topPersonal', 'topInsumos',
            'porSexo', 'porCondicion', 'promediosSignos',
            'fechaDesde', 'fechaHasta'
        ));
    }
}