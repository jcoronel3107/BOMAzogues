@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Herramienta</h6>
        <div>
            <a href="{{ route('herramientas.edit', $herramienta) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('herramientas.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">Código</th>
                <td><strong>{{ $herramienta->codigo }}</strong></td>
            </tr>
            <tr>
                <th>Descripción</th>
                <td>{{ $herramienta->descripcion }}</td>
            </tr>
            <tr>
                <th>Ubicación</th>
                <td>{{ $herramienta->ubicacion ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Cantidad</th>
                <td>
                    <span class="badge badge-{{ $herramienta->estaBajoStock() ? 'warning' : ($herramienta->cantidad <= 0 ? 'danger' : 'success') }}">
                        {{ $herramienta->cantidad }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Cantidad Mínima</th>
                <td>{{ $herramienta->cantidad_minima }}</td>
            </tr>
            <tr>
                <th>Categoría</th>
                <td>{{ $herramienta->categoria ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Marca</th>
                <td>{{ $herramienta->marca ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Modelo</th>
                <td>{{ $herramienta->modelo ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Número de Serie</th>
                <td>{{ $herramienta->numero_serie ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha de Compra</th>
                <td>{{ $herramienta->fecha_compra ? $herramienta->fecha_compra->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Valor de Compra</th>
                <td>{{ $herramienta->valor_compra ? '$ ' . number_format($herramienta->valor_compra, 2) : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha de Mantenimiento</th>
                <td>{{ $herramienta->fecha_mantenimiento ? $herramienta->fecha_mantenimiento->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    @php
                        $estados = [
                            'disponible' => 'success',
                            'en_uso' => 'info',
                            'mantenimiento' => 'warning',
                            'averiada' => 'danger',
                            'baja' => 'secondary'
                        ];
                    @endphp
                    <span class="badge badge-{{ $estados[$herramienta->estado] ?? 'secondary' }}">
                        {{ ucfirst($herramienta->estado) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>{{ $herramienta->observaciones ?? 'Sin observaciones' }}</td>
            </tr>
            <tr>
                <th>Creado por</th>
                <td>{{ $herramienta->usuarioCrea->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha de Creación</th>
                <td>{{ $herramienta->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @if($herramienta->usuarioEdita)
            <tr>
                <th>Última edición por</th>
                <td>{{ $herramienta->usuarioEdita->name }}</td>
            </tr>
            <tr>
                <th>Última actualización</th>
                <td>{{ $herramienta->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endsection