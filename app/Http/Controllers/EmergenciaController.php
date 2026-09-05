<?php

namespace App\Http\Controllers;

use App\Emergencia;
use App\Incidente;
use App\Station;
use App\User;
use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmergenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $emergencias = Emergencia::with(['tipoIncidente', 'estacion', 'usuarios', 'vehiculos'])
            ->latest()
            ->paginate(15);
        return view('emergencias.index', compact('emergencias'));
    }

    public function create()
    {
        $incidentes = Incidente::orderBy('nombre_incidente')->get();
        $estaciones = Station::all();
        $usuarios = User::orderBy('name')->get();
        $vehiculos = Vehiculo::where('activo', 1)->orderBy('placa')->get();
        
        return view('emergencias.create', compact('incidentes', 'estaciones', 'usuarios', 'vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'informacion_inicial' => 'required|string',
            'tipo_incidente_id' => 'required|exists:incidentes,id',
            'subcategoria' => 'nullable|string|max:255',
            'estacion_id' => 'required|exists:stations,id',
            'hora_salida_emergencia' => 'required',
            'hora_llegada_emergencia' => 'required',
            'hora_en_base' => 'required',
            'detalle_emergencia' => 'required|string',
            'ciudadano_afectado' => 'nullable|string|max:255',
            'danos_estimados' => 'nullable|string|max:255',
            'usuarios' => 'nullable|array',
            'vehiculos' => 'nullable|array',
            'vehiculos.*.vehiculo_id' => 'exists:vehiculos,id',
            'vehiculos.*.conductor_id' => 'exists:users,id',
        ]);

        $emergencia = Emergencia::create([
            'fecha' => $request->fecha,
            'informacion_inicial' => $request->informacion_inicial,
            'tipo_incidente_id' => $request->tipo_incidente_id,
            'subcategoria' => $request->subcategoria,
            'estacion_id' => $request->estacion_id,
            'hora_salida_emergencia' => $request->hora_salida_emergencia,
            'hora_llegada_emergencia' => $request->hora_llegada_emergencia,
            'hora_en_base' => $request->hora_en_base,
            'detalle_emergencia' => $request->detalle_emergencia,
            'ciudadano_afectado' => $request->ciudadano_afectado,
            'danos_estimados' => $request->danos_estimados,
            'usr_creador' => Auth::user()->name,
        ]);

        // Guardar usuarios (personal en emergencia)
        if ($request->has('usuarios')) {
            $emergencia->usuarios()->attach($request->usuarios);
        }

        // Guardar vehículos
        if ($request->has('vehiculos')) {
            foreach ($request->vehiculos as $vehiculoData) {
                if (!empty($vehiculoData['vehiculo_id'])) {
                    $emergencia->vehiculos()->attach($vehiculoData['vehiculo_id'], [
                        'conductor_id' => $vehiculoData['conductor_id'] ?? null,
                        'km_salida' => $vehiculoData['km_salida'] ?? null,
                        'km_retorno' => $vehiculoData['km_retorno'] ?? null,
                    ]);
                }
            }
        }

        Session::flash('success', 'Emergencia creada exitosamente.');
        return redirect()->route('emergencias.index');
    }

    public function show($id)
    {
        $emergencia = Emergencia::with(['tipoIncidente', 'estacion', 'usuarios', 'vehiculos'])
            ->findOrFail($id);
        return view('emergencias.show', compact('emergencia'));
    }

    public function edit($id)
    {
        $emergencia = Emergencia::with(['usuarios', 'vehiculos'])->findOrFail($id);
        $incidentes = Incidente::orderBy('nombre_incidente')->get();
        $estaciones = Station::all();
        $usuarios = User::orderBy('name')->get();
        $vehiculos = Vehiculo::where('activo', 1)->orderBy('placa')->get();
        
        return view('emergencias.edit', compact('emergencia', 'incidentes', 'estaciones', 'usuarios', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        $emergencia = Emergencia::findOrFail($id);

        $request->validate([
            'fecha' => 'required|date',
            'informacion_inicial' => 'required|string',
            'tipo_incidente_id' => 'required|exists:incidentes,id',
            'subcategoria' => 'nullable|string|max:255',
            'estacion_id' => 'required|exists:stations,id',
            'hora_salida_emergencia' => 'required',
            'hora_llegada_emergencia' => 'required',
            'hora_en_base' => 'required',
            'detalle_emergencia' => 'required|string',
            'ciudadano_afectado' => 'nullable|string|max:255',
            'danos_estimados' => 'nullable|string|max:255',
        ]);

        $emergencia->update([
            'fecha' => $request->fecha,
            'informacion_inicial' => $request->informacion_inicial,
            'tipo_incidente_id' => $request->tipo_incidente_id,
            'subcategoria' => $request->subcategoria,
            'estacion_id' => $request->estacion_id,
            'hora_salida_emergencia' => $request->hora_salida_emergencia,
            'hora_llegada_emergencia' => $request->hora_llegada_emergencia,
            'hora_en_base' => $request->hora_en_base,
            'detalle_emergencia' => $request->detalle_emergencia,
            'ciudadano_afectado' => $request->ciudadano_afectado,
            'danos_estimados' => $request->danos_estimados,
            'usr_editor' => Auth::user()->name,
        ]);

        // Actualizar usuarios
        $emergencia->usuarios()->sync($request->usuarios ?? []);

        // Actualizar vehículos
        $emergencia->vehiculos()->detach();
        if ($request->has('vehiculos')) {
            foreach ($request->vehiculos as $vehiculoData) {
                if (!empty($vehiculoData['vehiculo_id'])) {
                    $emergencia->vehiculos()->attach($vehiculoData['vehiculo_id'], [
                        'conductor_id' => $vehiculoData['conductor_id'] ?? null,
                        'km_salida' => $vehiculoData['km_salida'] ?? null,
                        'km_retorno' => $vehiculoData['km_retorno'] ?? null,
                    ]);
                }
            }
        }

        Session::flash('success', 'Emergencia actualizada exitosamente.');
        return redirect()->route('emergencias.index');
    }

    public function destroy($id)
    {
        $emergencia = Emergencia::findOrFail($id);
        $emergencia->delete();

        Session::flash('success', 'Emergencia eliminada exitosamente.');
        return redirect()->route('emergencias.index');
    }
}