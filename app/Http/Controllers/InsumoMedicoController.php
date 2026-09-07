<?php

namespace App\Http\Controllers;

use App\InsumoMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class InsumoMedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|Super-Admin');
    }

    public function index()
    {
        $insumos = InsumoMedico::with(['usuarioCrea'])
            ->latest()
            ->paginate(15);
        return view('insumos_medicos.index', compact('insumos'));
    }

    public function create()
    {
        return view('insumos_medicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'caso_uso' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'categoria' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:50',
            'fecha_vencimiento' => 'nullable|date|after:today',
            'ubicacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        // Generar código automático
        $codigo = 'INS-' . date('Y') . '-' . strtoupper(Str::random(6));

        $insumo = InsumoMedico::create([
            'codigo' => $codigo,
            'descripcion' => $request->descripcion,
            'caso_uso' => $request->caso_uso,
            'cantidad' => $request->cantidad,
            'cantidad_minima' => $request->cantidad_minima ?? 5,
            'categoria' => $request->categoria,
            'presentacion' => $request->presentacion,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'ubicacion' => $request->ubicacion,
            'observaciones' => $request->observaciones,
            'estado' => $request->cantidad > 0 ? 'disponible' : 'agotado',
            'usuario_crea_id' => Auth::id(),
        ]);

        Session::flash('success', 'Insumo médico creado exitosamente. Código: ' . $codigo);
        return redirect()->route('insumos-medicos.index');
    }

    public function show($id)
    {
        $insumo = InsumoMedico::with(['usuarioCrea', 'usuarioEdita'])->findOrFail($id);
        return view('insumos_medicos.show', compact('insumo'));
    }

    public function edit($id)
    {
        $insumo = InsumoMedico::findOrFail($id);
        return view('insumos_medicos.edit', compact('insumo'));
    }

    public function update(Request $request, $id)
    {
        $insumo = InsumoMedico::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'caso_uso' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'categoria' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:50',
            'fecha_vencimiento' => 'nullable|date',
            'ubicacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        // Determinar estado según cantidad
        $estado = $request->cantidad > 0 ? 'disponible' : 'agotado';

        $insumo->update([
            'descripcion' => $request->descripcion,
            'caso_uso' => $request->caso_uso,
            'cantidad' => $request->cantidad,
            'cantidad_minima' => $request->cantidad_minima ?? 5,
            'categoria' => $request->categoria,
            'presentacion' => $request->presentacion,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'ubicacion' => $request->ubicacion,
            'observaciones' => $request->observaciones,
            'estado' => $estado,
            'usuario_edita_id' => Auth::id(),
        ]);

        Session::flash('success', 'Insumo médico actualizado exitosamente.');
        return redirect()->route('insumos-medicos.index');
    }

    public function destroy($id)
    {
        $insumo = InsumoMedico::findOrFail($id);
        $insumo->delete();

        Session::flash('success', 'Insumo médico eliminado exitosamente.');
        return redirect()->route('insumos-medicos.index');
    }

    // Método para ajustar stock (entrada/salida)
    public function ajustarStock(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
        ]);

        $insumo = InsumoMedico::findOrFail($id);

        if ($request->tipo == 'entrada') {
            $insumo->cantidad += $request->cantidad;
        } else {
            if ($insumo->cantidad < $request->cantidad) {
                return redirect()->route('insumos-medicos.index')
                    ->with('error', 'No hay suficiente stock para realizar la salida.');
            }
            $insumo->cantidad -= $request->cantidad;
        }

        // Actualizar estado
        $insumo->estado = $insumo->cantidad > 0 ? 'disponible' : 'agotado';
        $insumo->usuario_edita_id = Auth::id();
        $insumo->save();

        $mensaje = $request->tipo == 'entrada' ? 'Entrada de stock registrada' : 'Salida de stock registrada';
        return redirect()->route('insumos-medicos.index')
            ->with('success', $mensaje . ' exitosamente. Nuevo stock: ' . $insumo->cantidad);
    }
}