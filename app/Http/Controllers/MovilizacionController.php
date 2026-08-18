<?php

namespace App\Http\Controllers;

use App\Movilizacion;
use App\User;
use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovilizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $movilizaciones = Movilizacion::with(['vehiculo', 'user', 'usuarioCrea', 'usuarioAutoriza'])
            ->latest()
            ->paginate(15);
        
        return view('movilizaciones.index', compact('movilizaciones'));
    }

    public function create()
    {
        $usuarios = User::all();
        $vehiculos = Vehiculo::all();
        return view('movilizaciones.create', compact('usuarios', 'vehiculos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'fecha_salida' => 'required|date',
        'hora_salida' => 'required',
        'motivo' => 'required|string|max:255',
        'lugar_origen' => 'required|string|max:255',
        'destino' => 'required|string|max:255',
        'conductor_nombres' => 'required|string|max:255',
        'conductor_cedula' => 'required|string|max:20',
        'conductor_cargo' => 'nullable|string|max:100',
        'vehiculo_marca' => 'required|string|max:100',
        'vehiculo_placa' => 'required|string|max:20',
        'km_salida' => 'required|integer|min:0',
        'vehiculo_id' => 'required|exists:vehiculos,id',
        'user_id' => 'required|exists:users,id',
        'integrantes' => 'nullable|array',
        'observaciones' => 'nullable|string',
    ]);

    $movilizacion = Movilizacion::create([
        'fecha_salida' => $request->fecha_salida,
        'hora_salida' => $request->hora_salida,
        'motivo' => $request->motivo,
        'lugar_origen' => $request->lugar_origen,
        'destino' => $request->destino,
        'conductor_nombres' => $request->conductor_nombres,
        'conductor_cedula' => $request->conductor_cedula,
        'conductor_cargo' => $request->conductor_cargo,
        'vehiculo_marca' => $request->vehiculo_marca,
        'vehiculo_placa' => $request->vehiculo_placa,
        'km_salida' => $request->km_salida,
        'vehiculo_id' => $request->vehiculo_id,
        'user_id' => $request->user_id,
        'integrantes' => $request->integrantes,
        'usr_creador' => Auth::id(),
        'estado' => 'pendiente',
        'observaciones' => $request->observaciones,
    ]);

    return redirect()->route('movilizaciones.index')
        ->with('success', 'Movilización creada exitosamente.');
}

    public function show($id)
    {
        $movilizacion = Movilizacion::with(['vehiculo', 'user', 'usuarioCrea', 'usuarioAutoriza'])->findOrFail($id);
        return view('movilizaciones.show', compact('movilizacion'));
    }

    public function edit($id)
    {
        $movilizacion = Movilizacion::findOrFail($id);

        if (!$movilizacion->puedeEditar()) {
            return redirect()->route('movilizaciones.index')
                ->with('error', 'Esta movilización no puede ser editada.');
        }

        $usuarios = User::all();
        $vehiculos = Vehiculo::all();
        return view('movilizaciones.edit', compact('movilizacion', 'usuarios', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        $movilizacion = Movilizacion::findOrFail($id);

        if (!$movilizacion->puedeEditar()) {
            return redirect()->route('movilizaciones.index')
                ->with('error', 'Esta movilización no puede ser editada.');
        }

        $request->validate([
            'fecha_salida' => 'required|date',
            'hora_salida' => 'required',
            'motivo' => 'required|string|max:255',
            'lugar_origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'conductor_nombres' => 'required|string|max:255',
            'conductor_cedula' => 'required|string|max:20',
            'conductor_cargo' => 'nullable|string|max:100',
            'vehiculo_marca' => 'required|string|max:100',
            'vehiculo_placa' => 'required|string|max:20',
            'km_salida' => 'required|integer|min:0',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'user_id' => 'required|exists:users,id',
            'integrantes' => 'nullable|array',
            'integrantes.*.nombre' => 'required|string|max:255',
            'integrantes.*.cedula' => 'required|string|max:20',
            'integrantes.*.cargo' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        $movilizacion->update([
            'fecha_salida' => $request->fecha_salida,
            'hora_salida' => $request->hora_salida,
            'motivo' => $request->motivo,
            'lugar_origen' => $request->lugar_origen,
            'destino' => $request->destino,
            'conductor_nombres' => $request->conductor_nombres,
            'conductor_cedula' => $request->conductor_cedula,
            'conductor_cargo' => $request->conductor_cargo,
            'vehiculo_marca' => $request->vehiculo_marca,
            'vehiculo_placa' => $request->vehiculo_placa,
            'km_salida' => $request->km_salida,
            'vehiculo_id' => $request->vehiculo_id,
            'user_id' => $request->user_id,
            'integrantes' => $request->integrantes,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('movilizaciones.index')
            ->with('success', 'Movilización actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $movilizacion = Movilizacion::findOrFail($id);

        if (!$movilizacion->puedeEditar()) {
            return redirect()->route('movilizaciones.index')
                ->with('error', 'No se puede eliminar esta movilización.');
        }

        $movilizacion->delete();

        return redirect()->route('movilizaciones.index')
            ->with('success', 'Movilización eliminada exitosamente.');
    }

    public function autorizar($id)
    {
        $movilizacion = Movilizacion::findOrFail($id);

        if (!$movilizacion->puedeAutorizar()) {
            return redirect()->route('movilizaciones.index')
                ->with('error', 'Esta movilización no puede ser autorizada.');
        }

        $movilizacion->update([
            'estado' => 'aprobado',
            'usr_autoriza' => Auth::id(),
            'fecha_autorizacion' => now(),
        ]);

        return redirect()->route('movilizaciones.index')
            ->with('success', 'Movilización autorizada exitosamente.');
    }

    public function rechazar(Request $request, $id)
    {
        $movilizacion = Movilizacion::findOrFail($id);

        if (!$movilizacion->puedeAutorizar()) {
            return redirect()->route('movilizaciones.index')
                ->with('error', 'Esta movilización no puede ser rechazada.');
        }

        $movilizacion->update([
            'estado' => 'rechazado',
            'observaciones' => $request->observaciones ?? 'Movilización rechazada',
        ]);

        return redirect()->route('movilizaciones.index')
            ->with('success', 'Movilización rechazada.');
    }

    public function finalizar(Request $request, $id)
    {
        $movilizacion = Movilizacion::findOrFail($id);

        if ($movilizacion->estado !== 'aprobado') {
            return redirect()->route('movilizaciones.index')
                ->with('error', 'Solo se pueden finalizar movilizaciones aprobadas.');
        }

        $request->validate([
            'fecha_retorno' => 'required|date|after_or_equal:fecha_salida',
            'km_retorno' => 'required|integer|min:0|gte:km_salida',
        ]);

        $movilizacion->fecha_retorno = $request->fecha_retorno;
        $movilizacion->km_retorno = $request->km_retorno;
        $movilizacion->estado = 'finalizado';
        $movilizacion->save();

        return redirect()->route('movilizaciones.index')
            ->with('success', 'Movilización finalizada exitosamente.');
    }
}