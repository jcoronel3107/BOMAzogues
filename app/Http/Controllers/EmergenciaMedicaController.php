<?php

namespace App\Http\Controllers;

use App\EmergenciaMedica;
use App\Vehiculo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class EmergenciaMedicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $emergencias = EmergenciaMedica::with(['vehiculo', 'usuarioCrea'])
            ->latest()
            ->paginate(15);
        return view('emergencias_medicas.index', compact('emergencias'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::where('activo', 1)->orderBy('placa')->get();
        $paramedicos = User::where('cargo', 'Paramédico')->orderBy('name')->get();
        $medicos = User::where('cargo', 'Médico')->orderBy('name')->get();
        return view('emergencias_medicas.create', compact('vehiculos', 'paramedicos', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_llamada' => 'required',
            'paciente_nombres' => 'required|string|max:255',
            'paciente_cedula' => 'nullable|string|max:20',
            'paciente_edad' => 'nullable|string|max:10',
            'paciente_genero' => 'nullable|in:masculino,femenino,otro',
            'paciente_telefono' => 'nullable|string|max:20',
            'tipo_emergencia' => 'required|string|max:100',
            'lugar_incidente' => 'required|string|max:255',
            'nivel_gravedad' => 'nullable|string|max:50',
            'destino' => 'nullable|string|max:255',
            'hospital_destino' => 'nullable|string|max:255',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
            'km_salida' => 'nullable|integer|min:0',
            'paramedicos' => 'nullable|array',
            'medicos' => 'nullable|array',
            'observaciones' => 'nullable|string',
        ]);

        $codigo = 'EM-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $emergencia = EmergenciaMedica::create([
            'codigo' => $codigo,
            'fecha' => $request->fecha,
            'hora_llamada' => $request->hora_llamada,
            'hora_salida' => $request->hora_salida,
            'hora_llegada' => $request->hora_llegada,
            'hora_traslado' => $request->hora_traslado,
            'hora_retorno' => $request->hora_retorno,
            'paciente_nombres' => $request->paciente_nombres,
            'paciente_cedula' => $request->paciente_cedula,
            'paciente_edad' => $request->paciente_edad,
            'paciente_genero' => $request->paciente_genero,
            'paciente_telefono' => $request->paciente_telefono,
            'paciente_direccion' => $request->paciente_direccion,
            'paciente_contacto_emergencia' => $request->paciente_contacto_emergencia,
            'paciente_telefono_emergencia' => $request->paciente_telefono_emergencia,
            'tipo_emergencia' => $request->tipo_emergencia,
            'lugar_incidente' => $request->lugar_incidente,
            'descripcion_incidente' => $request->descripcion_incidente,
            'sintomas' => $request->sintomas,
            'diagnostico_presuntivo' => $request->diagnostico_presuntivo,
            'tratamiento_aplicado' => $request->tratamiento_aplicado,
            'medicamentos_administrados' => $request->medicamentos_administrados,
            'signos_vitales' => $request->signos_vitales,
            'nivel_gravedad' => $request->nivel_gravedad,
            'destino' => $request->destino,
            'hospital_destino' => $request->hospital_destino,
            'responsable_entrega' => $request->responsable_entrega,
            'paramedicos' => $request->paramedicos,
            'medicos' => $request->medicos,
            'vehiculo_id' => $request->vehiculo_id,
            'km_salida' => $request->km_salida,
            'estado' => 'registrada',
            'observaciones' => $request->observaciones,
            'usuario_crea_id' => Auth::id(),
        ]);

        Session::flash('success', 'Emergencia médica creada exitosamente. Código: ' . $codigo);
        return redirect()->route('emergencias-medicas.index');
    }

    public function show($id)
    {
        $emergencia = EmergenciaMedica::with(['vehiculo', 'usuarioCrea', 'usuarioEdita', 'usuarioFinaliza'])
            ->findOrFail($id);
        return view('emergencias_medicas.show', compact('emergencia'));
    }

    public function edit($id)
    {
        $emergencia = EmergenciaMedica::findOrFail($id);
        $vehiculos = Vehiculo::where('activo', 1)->orderBy('placa')->get();
        $paramedicos = User::where('cargo', 'Paramédico')->orderBy('name')->get();
        $medicos = User::where('cargo', 'Médico')->orderBy('name')->get();
        return view('emergencias_medicas.edit', compact('emergencia', 'vehiculos', 'paramedicos', 'medicos'));
    }

    public function update(Request $request, $id)
    {
        $emergencia = EmergenciaMedica::findOrFail($id);

        $request->validate([
            'fecha' => 'required|date',
            'hora_llamada' => 'required',
            'paciente_nombres' => 'required|string|max:255',
            'paciente_cedula' => 'nullable|string|max:20',
            'paciente_edad' => 'nullable|string|max:10',
            'paciente_genero' => 'nullable|in:masculino,femenino,otro',
            'paciente_telefono' => 'nullable|string|max:20',
            'tipo_emergencia' => 'required|string|max:100',
            'lugar_incidente' => 'required|string|max:255',
            'nivel_gravedad' => 'nullable|string|max:50',
            'destino' => 'nullable|string|max:255',
            'hospital_destino' => 'nullable|string|max:255',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
            'km_salida' => 'nullable|integer|min:0',
            'paramedicos' => 'nullable|array',
            'medicos' => 'nullable|array',
            'observaciones' => 'nullable|string',
        ]);

        $emergencia->update([
            'fecha' => $request->fecha,
            'hora_llamada' => $request->hora_llamada,
            'hora_salida' => $request->hora_salida,
            'hora_llegada' => $request->hora_llegada,
            'hora_traslado' => $request->hora_traslado,
            'hora_retorno' => $request->hora_retorno,
            'paciente_nombres' => $request->paciente_nombres,
            'paciente_cedula' => $request->paciente_cedula,
            'paciente_edad' => $request->paciente_edad,
            'paciente_genero' => $request->paciente_genero,
            'paciente_telefono' => $request->paciente_telefono,
            'paciente_direccion' => $request->paciente_direccion,
            'paciente_contacto_emergencia' => $request->paciente_contacto_emergencia,
            'paciente_telefono_emergencia' => $request->paciente_telefono_emergencia,
            'tipo_emergencia' => $request->tipo_emergencia,
            'lugar_incidente' => $request->lugar_incidente,
            'descripcion_incidente' => $request->descripcion_incidente,
            'sintomas' => $request->sintomas,
            'diagnostico_presuntivo' => $request->diagnostico_presuntivo,
            'tratamiento_aplicado' => $request->tratamiento_aplicado,
            'medicamentos_administrados' => $request->medicamentos_administrados,
            'signos_vitales' => $request->signos_vitales,
            'nivel_gravedad' => $request->nivel_gravedad,
            'destino' => $request->destino,
            'hospital_destino' => $request->hospital_destino,
            'responsable_entrega' => $request->responsable_entrega,
            'paramedicos' => $request->paramedicos,
            'medicos' => $request->medicos,
            'vehiculo_id' => $request->vehiculo_id,
            'km_salida' => $request->km_salida,
            'observaciones' => $request->observaciones,
            'usuario_edita_id' => Auth::id(),
        ]);

        Session::flash('success', 'Emergencia médica actualizada exitosamente.');
        return redirect()->route('emergencias-medicas.index');
    }

    public function destroy($id)
    {
        $emergencia = EmergenciaMedica::findOrFail($id);
        $emergencia->delete();

        Session::flash('success', 'Emergencia médica eliminada exitosamente.');
        return redirect()->route('emergencias-medicas.index');
    }

    public function finalizar($id)
    {
        $emergencia = EmergenciaMedica::findOrFail($id);

        if ($emergencia->estado == 'finalizada' || $emergencia->estado == 'cancelada') {
            return redirect()->route('emergencias-medicas.index')
                ->with('error', 'Esta emergencia ya está finalizada o cancelada.');
        }

        $emergencia->estado = 'finalizada';
        $emergencia->usuario_finaliza_id = Auth::id();
        $emergencia->save();

        return redirect()->route('emergencias-medicas.index')
            ->with('success', 'Emergencia médica finalizada exitosamente.');
    }

    public function cancelar($id)
    {
        $emergencia = EmergenciaMedica::findOrFail($id);

        if ($emergencia->estado == 'finalizada') {
            return redirect()->route('emergencias-medicas.index')
                ->with('error', 'No se puede cancelar una emergencia ya finalizada.');
        }

        $emergencia->estado = 'cancelada';
        $emergencia->usuario_edita_id = Auth::id();
        $emergencia->save();

        return redirect()->route('emergencias-medicas.index')
            ->with('success', 'Emergencia médica cancelada exitosamente.');
    }
}