<?php

namespace App\Http\Controllers;

use App\EmergenciaPrehospitalaria;
use App\PacienteEmergencia;
use App\InsumoMedico;
use App\Vehiculo;
use App\User;
use App\EmergenciaArchivo;
use App\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmergenciaPrehospitalariaController extends Controller
{
    /**
     * 🔒 Verifica que el usuario pueda acceder a la emergencia
     */
    private function verificarAccesoEstacion($emergencia)
    {
        // Super-Admin y admin pueden ver todo
        if (auth()->user()->hasRole('Super-Admin') || auth()->user()->hasRole('admin')) {
            return;
        }

        // Otros usuarios solo pueden ver emergencias de su estación
        if ($emergencia->estacion_id !== auth()->user()->station_id) {
            abort(403, 'No tienes permiso para acceder a esta emergencia. Solo puedes ver las de tu estación.');
        }
    }

    // ============================================================
    //  INDEX
    // ============================================================
    public function index(Request $request)
    {
        $query = EmergenciaPrehospitalaria::with([
            'vehiculo', 'usuarioRegistra', 'pacientes', 'personal', 'estacion'
        ]);

        // 🔒 FILTRAR POR ESTACIÓN
        if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
            $query->where('estacion_id', auth()->user()->station_id);
        }

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
        if ($request->filled('estacion_id')) $query->where('estacion_id', $request->estacion_id);

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

        // Resumen con filtro por estación
        $resumenQuery = EmergenciaPrehospitalaria::query();
        if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
            $resumenQuery->where('estacion_id', auth()->user()->station_id);
        }

        $resumen = [
            'total' => (clone $resumenQuery)->count(),
            'en_curso' => (clone $resumenQuery)->where('estado', 'En curso')->count(),
            'finalizadas' => (clone $resumenQuery)->where('estado', 'Finalizada')->count(),
            'hoy' => (clone $resumenQuery)->whereDate('fecha_salida', today())->count(),
        ];

        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();
        $estaciones = Station::orderBy('nombre')->get();
        $tipos = ['Accidente de tránsito', 'Emergencia médica', 'Trauma', 'Obstétrica', 'Pediatrica', 'Psiquiatrica', 'Otra'];
        $estados = ['En curso', 'Finalizada', 'Cancelada', 'Derivada'];
        $prioridades = ['Rojo', 'Naranja', 'Amarillo', 'Verde', 'Azul'];

        return view('emergencias_prehospitalarias.index', compact(
            'emergencias', 'resumen', 'vehiculos', 'personal', 'estaciones',
            'tipos', 'estados', 'prioridades'
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
        $estacionUsuario = auth()->user()->station;

        return view('emergencias_prehospitalarias.create',
            compact('vehiculos', 'personal', 'insumos', 'estacionUsuario'));
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
                'estacion_id' => auth()->user()->station_id,  // 🔒 ASIGNAR ESTACIÓN
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

                    InsumoMedico::where('id', $ins['insumo_medico_id'])
                                ->decrement('cantidad', $ins['cantidad']);
                }
            }

            DB::commit();
            return redirect()->route('emergencias-prehospitalarias.show', $emergencia)
                            ->with('success', 'Emergencia prehospitalaria registrada');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ============================================================
    //  SHOW
    // ============================================================
    public function show(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $this->verificarAccesoEstacion($emergenciaPrehospitalaria);

        $emergenciaPrehospitalaria->load([
            'vehiculo', 'usuarioRegistra', 'personal', 'pacientes', 'insumos', 'estacion', 'archivos'
        ]);
        return view('emergencias_prehospitalarias.show', compact('emergenciaPrehospitalaria'));
    }

    // ============================================================
    //  EDIT
    // ============================================================
    public function edit(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $this->verificarAccesoEstacion($emergenciaPrehospitalaria);

        $emergenciaPrehospitalaria->load(['personal', 'pacientes', 'insumos', 'archivos']);
        $vehiculos = Vehiculo::orderBy('placa')->get();
        $personal = User::orderBy('name')->get();
        $insumos = InsumoMedico::orderBy('descripcion')->get();

        return view('emergencias_prehospitalarias.edit', compact(
            'emergenciaPrehospitalaria', 'vehiculos', 'personal', 'insumos'
        ));
    }

    // ============================================================
    //  UPDATE
    // ============================================================
    public function update(Request $request, EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $this->verificarAccesoEstacion($emergenciaPrehospitalaria);

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

            $personalSync = [];
            foreach ($request->personal as $p) {
                $personalSync[$p['user_id']] = ['rol_en_emergencia' => $p['rol_en_emergencia']];
            }
            $emergenciaPrehospitalaria->personal()->sync($personalSync);

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

            foreach ($emergenciaPrehospitalaria->insumos as $insumoViejo) {
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

    // ============================================================
    //  DESTROY
    // ============================================================
    public function destroy(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $this->verificarAccesoEstacion($emergenciaPrehospitalaria);

        foreach ($emergenciaPrehospitalaria->insumos as $ins) {
            InsumoMedico::where('id', $ins->id)->increment('cantidad', $ins->pivot->cantidad);
        }

        $emergenciaPrehospitalaria->delete();
        return redirect()->route('emergencias-prehospitalarias.index')
                        ->with('success', 'Emergencia eliminada');
    }

    // ============================================================
    //  PDF
    // ============================================================
    public function generarPdf(EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $this->verificarAccesoEstacion($emergenciaPrehospitalaria);

        require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');

        $emergenciaPrehospitalaria->load([
            'vehiculo', 'usuarioRegistra', 'personal', 'pacientes', 'insumos', 'estacion'
        ]);

        $tiempos = $this->calcularTiempos($emergenciaPrehospitalaria);

        $html = view('emergencias_prehospitalarias.pdf.parte_tcpdf',
            compact('emergenciaPrehospitalaria', 'tiempos'))->render();

        $pdf = new \TCPDF('L', 'mm', 'LETTER', true, 'UTF-8', false);

        $pdf->SetCreator('Sistema de Emergencias');
        $pdf->SetAuthor($emergenciaPrehospitalaria->usuarioRegistra->name ?? 'Sistema');
        $pdf->SetTitle('Parte de Ambulancia - ' . $emergenciaPrehospitalaria->codigo);
        $pdf->SetSubject('Parte de Atención Prehospitalaria');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(8, 8, 8);
        $pdf->SetAutoPageBreak(TRUE, 15);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        $nombreArchivo = 'Parte_Ambulancia_' . $emergenciaPrehospitalaria->codigo . '.pdf';
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

        $baseQuery = EmergenciaPrehospitalaria::whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);

        // 🔒 FILTRAR POR ESTACIÓN
        if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
            $baseQuery->where('estacion_id', auth()->user()->station_id);
        }

        $resumen = [
            'total' => (clone $baseQuery)->count(),
            'en_curso' => (clone $baseQuery)->where('estado', 'En curso')->count(),
            'finalizadas' => (clone $baseQuery)->where('estado', 'Finalizada')->count(),
            'canceladas' => (clone $baseQuery)->where('estado', 'Cancelada')->count(),
            'total_pacientes' => PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
                if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
                    $q->where('estacion_id', auth()->user()->station_id);
                }
            })->count(),
            'promedio_pacientes' => round(
                PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                    $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
                    if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
                        $q->where('estacion_id', auth()->user()->station_id);
                    }
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
            ->when(!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin'), function ($q) {
                $q->where('emergencias_prehospitalarias.estacion_id', auth()->user()->station_id);
            })
            ->select('users.name', DB::raw('count(*) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topInsumos = DB::table('emergencia_insumos')
            ->join('emergencias_prehospitalarias', 'emergencias_prehospitalarias.id', '=', 'emergencia_insumos.emergencia_prehospitalaria_id')
            ->join('insumos_medicos', 'insumos_medicos.id', '=', 'emergencia_insumos.insumo_medico_id')
            ->whereBetween('emergencias_prehospitalarias.fecha_salida', [$fechaDesde, $fechaHasta])
            ->when(!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin'), function ($q) {
                $q->where('emergencias_prehospitalarias.estacion_id', auth()->user()->station_id);
            })
            ->select('insumos_medicos.descripcion', DB::raw('SUM(emergencia_insumos.cantidad) as total'))
            ->groupBy('insumos_medicos.id', 'insumos_medicos.descripcion')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $porSexo = PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
                if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
                    $q->where('estacion_id', auth()->user()->station_id);
                }
            })
            ->select('sexo', DB::raw('count(*) as total'))
            ->groupBy('sexo')
            ->get();

        $porCondicion = PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
                if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
                    $q->where('estacion_id', auth()->user()->station_id);
                }
            })
            ->select('condicion', DB::raw('count(*) as total'))
            ->groupBy('condicion')
            ->get();

        $promediosSignos = PacienteEmergencia::whereHas('emergencia', function ($q) use ($fechaDesde, $fechaHasta) {
                $q->whereBetween('fecha_salida', [$fechaDesde, $fechaHasta]);
                if (!auth()->user()->hasRole('Super-Admin') && !auth()->user()->hasRole('admin')) {
                    $q->where('estacion_id', auth()->user()->station_id);
                }
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

    // ============================================================
    //  ARCHIVOS
    // ============================================================
    public function subirArchivos(Request $request, EmergenciaPrehospitalaria $emergenciaPrehospitalaria)
    {
        $this->verificarAccesoEstacion($emergenciaPrehospitalaria);

        $limiteTotalMb = config('filesystems.emergencias_archivos.limite_mb', 50);
        $limiteArchivoMb = config('filesystems.emergencias_archivos.max_archivo_mb', 10);
        $limiteTotalBytes = $limiteTotalMb * 1024 * 1024;
        $extensionesPermitidas = config('filesystems.emergencias_archivos.extensiones_permitidas', []);

        $request->validate([
            'archivos' => 'required|array|min:1',
            'archivos.*' => 'file|max:' . ($limiteArchivoMb * 1024),
        ], [
            'archivos.*.max' => "Cada archivo no puede superar los {$limiteArchivoMb}MB.",
        ]);

        foreach ($request->file('archivos') as $archivo) {
            $extension = strtolower($archivo->getClientOriginalExtension());
            if (!in_array($extension, $extensionesPermitidas)) {
                return back()->with('error', "El archivo '{$archivo->getClientOriginalName()}' tiene una extensión no permitida.");
            }
        }

        $espacioUsado = $emergenciaPrehospitalaria->archivos()->sum('tamano') ?? 0;
        $tamanoNuevos = 0;
        foreach ($request->file('archivos') as $archivo) {
            $tamanoNuevos += $archivo->getSize();
        }

        if (($espacioUsado + $tamanoNuevos) > $limiteTotalBytes) {
            $disponible = round(($limiteTotalBytes - $espacioUsado) / 1024 / 1024, 2);
            return back()->with('error', "❌ No hay espacio suficiente. Disponible: {$disponible}MB.");
        }

        $subidos = 0;
        DB::beginTransaction();
        try {
            foreach ($request->file('archivos') as $archivo) {
                $carpeta = 'emergencias/' . $emergenciaPrehospitalaria->id;
                if (!Storage::disk('public')->exists($carpeta)) {
                    Storage::disk('public')->makeDirectory($carpeta);
                }

                $nombreOriginal = $archivo->getClientOriginalName();
                $extension = $archivo->getClientOriginalExtension();
                $nombreArchivo = time() . '_' . uniqid() . '.' . $extension;
                $ruta = $archivo->storeAs($carpeta, $nombreArchivo, 'public');

                EmergenciaArchivo::create([
                    'emergencia_prehospitalaria_id' => $emergenciaPrehospitalaria->id,
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

            DB::commit();
            return redirect()->route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria)
                            ->with('success', "{$subidos} archivo(s) subido(s) correctamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al subir: ' . $e->getMessage());
        }
    }

    public function eliminarArchivo(EmergenciaArchivo $archivo)
    {
        $emergencia = EmergenciaPrehospitalaria::find($archivo->emergencia_prehospitalaria_id);
        if ($emergencia) {
            $this->verificarAccesoEstacion($emergencia);
        }

        $emergenciaId = $archivo->emergencia_prehospitalaria_id;

        if (Storage::disk('public')->exists($archivo->ruta)) {
            Storage::disk('public')->delete($archivo->ruta);
        }

        $archivo->delete();

        return redirect()
            ->route('emergencias-prehospitalarias.show', $emergenciaId)
            ->with('success', 'Archivo eliminado correctamente.');
    }

    public function descargarArchivo(EmergenciaArchivo $archivo)
    {
        $emergencia = EmergenciaPrehospitalaria::find($archivo->emergencia_prehospitalaria_id);
        if ($emergencia) {
            $this->verificarAccesoEstacion($emergencia);
        }

        $ruta = storage_path('app/public/' . $archivo->ruta);

        if (!file_exists($ruta)) {
            abort(404, 'El archivo no existe en el servidor.');
        }

        return response()->download($ruta, $archivo->nombre_original);
    }
}