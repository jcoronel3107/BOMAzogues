<?php

namespace App\Http\Controllers;

use App\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HerramientaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|Super-Admin');
    }

    public function index()
    {
        $herramientas = Herramienta::with(['usuarioCrea'])
            ->latest()
            ->paginate(15);
        return view('herramientas.index', compact('herramientas'));
    }

    public function create()
    {
        return view('herramientas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'categoria' => 'nullable|string|max:100',
            'fecha_compra' => 'nullable|date',
            'valor_compra' => 'nullable|numeric|min:0',
            'fecha_mantenimiento' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:disponible,en_uso,mantenimiento,averiada,baja',
        ]);

        // Generar código automático
        $codigo = 'HERR-' . date('Y') . '-' . strtoupper(Str::random(6));

        $herramienta = Herramienta::create([
            'codigo' => $codigo,
            'descripcion' => $request->descripcion,
            'ubicacion' => $request->ubicacion,
            'cantidad' => $request->cantidad,
            'cantidad_minima' => $request->cantidad_minima ?? 1,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'categoria' => $request->categoria,
            'fecha_compra' => $request->fecha_compra,
            'valor_compra' => $request->valor_compra,
            'fecha_mantenimiento' => $request->fecha_mantenimiento,
            'observaciones' => $request->observaciones,
            'estado' => $request->estado,
            'usuario_crea_id' => Auth::id(),
        ]);

        Session::flash('success', 'Herramienta creada exitosamente. Código: ' . $codigo);
        return redirect()->route('herramientas.index');
    }

    public function show($id)
    {
        $herramienta = Herramienta::with(['usuarioCrea', 'usuarioEdita'])->findOrFail($id);
        return view('herramientas.show', compact('herramienta'));
    }

    public function edit($id)
    {
        $herramienta = Herramienta::findOrFail($id);
        return view('herramientas.edit', compact('herramienta'));
    }

    public function update(Request $request, $id)
    {
        $herramienta = Herramienta::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'categoria' => 'nullable|string|max:100',
            'fecha_compra' => 'nullable|date',
            'valor_compra' => 'nullable|numeric|min:0',
            'fecha_mantenimiento' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:disponible,en_uso,mantenimiento,averiada,baja',
        ]);

        $herramienta->update([
            'descripcion' => $request->descripcion,
            'ubicacion' => $request->ubicacion,
            'cantidad' => $request->cantidad,
            'cantidad_minima' => $request->cantidad_minima ?? 1,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'categoria' => $request->categoria,
            'fecha_compra' => $request->fecha_compra,
            'valor_compra' => $request->valor_compra,
            'fecha_mantenimiento' => $request->fecha_mantenimiento,
            'observaciones' => $request->observaciones,
            'estado' => $request->estado,
            'usuario_edita_id' => Auth::id(),
        ]);

        Session::flash('success', 'Herramienta actualizada exitosamente.');
        return redirect()->route('herramientas.index');
    }

    public function destroy($id)
    {
        $herramienta = Herramienta::findOrFail($id);
        $herramienta->delete();

        Session::flash('success', 'Herramienta eliminada exitosamente.');
        return redirect()->route('herramientas.index');
    }

    // Método para cambiar estado
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:disponible,en_uso,mantenimiento,averiada,baja',
        ]);

        $herramienta = Herramienta::findOrFail($id);
        $herramienta->estado = $request->estado;
        $herramienta->usuario_edita_id = Auth::id();
        $herramienta->save();

        return redirect()->route('herramientas.index')
            ->with('success', 'Estado de la herramienta actualizado a: ' . ucfirst($request->estado));
    }
}