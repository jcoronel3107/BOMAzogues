@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Insumo Médico</h6>
        <div>
            <a href="{{ route('insumos-medicos.edit', $insumo) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('insumos-medicos.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">Código</th>
                <td><strong>{{ $insumo->codigo }}</strong></td>
            </tr>
            <tr>
                <th>Descripción</th>
                <td>{{ $insumo->descripcion }}</td>
            </tr>
            <tr>
                <th>Caso de Uso</th>
                <td>{{ $insumo->caso_uso }}</td>
            </tr>
            <tr>
                <th>Cantidad</th>
                <td>
                    <span class="badge badge-{{ $insumo->estaBajoStock() ? 'warning' : ($insumo->estaAgotado() ? 'danger' : 'success') }}">
                        {{ $insumo->cantidad }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Cantidad Mínima</th>
                <td>{{ $insumo->cantidad_minima }}</td>
            </tr>
            <tr>
                <th>Presentación</th>
                <td>{{ $insumo->presentacion ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Categoría</th>
                <td>{{ $insumo->categoria ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Ubicación</th>
                <td>{{ $insumo->ubicacion ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha de Vencimiento</th>
                <td>{{ $insumo->fecha_vencimiento ? $insumo->fecha_vencimiento->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    @php
                        $estados = [
                            'disponible' => 'success',
                            'agotado' => 'danger',
                            'vencido' => 'warning'
                        ];
                    @endphp
                    <span class="badge badge-{{ $estados[$insumo->estado] ?? 'secondary' }}">
                        {{ ucfirst($insumo->estado ?? 'Sin estado') }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>{{ $insumo->observaciones ?? 'Sin observaciones' }}</td>
            </tr>
            <tr>
                <th>Creado por</th>
                <td>{{ $insumo->usuarioCrea->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha de Creación</th>
                <td>{{ $insumo->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @if($insumo->usuarioEdita)
            <tr>
                <th>Última edición por</th>
                <td>{{ $insumo->usuarioEdita->name }}</td>
            </tr>
            <tr>
                <th>Última actualización</th>
                <td>{{ $insumo->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endsection