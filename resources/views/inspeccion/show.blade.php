@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Inspección</h6>
        <div>
            <!-- Botón Enviar Correo -->
            <a href="{{ route('inspeccion.enviar-correo', $inspeccion) }}" class="btn btn-info btn-sm" title="Enviar por Correo">
                <i class="fas fa-envelope"></i> Enviar Correo
            </a>
            <a href="{{ route('inspeccion.pdf', $inspeccion) }}" class="btn btn-danger btn-sm" target="_blank">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            <a href="{{ route('inspeccion.edit', $inspeccion) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('inspeccion.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            @can('ratificar inspecciones')
                @if($inspeccion->estado == 'aprobada')
                    <form action="{{ route('inspeccion.ratificar', $inspeccion) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de ratificar esta inspección?')">
                            <i class="fas fa-stamp"></i> Ratificar
                        </button>
                    </form>
                @endif
            @endcan
        </div>
    </div>

    <div class="card-body">
        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Mensaje de error -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Código</th>
                        <td><strong>{{ $inspeccion->codigo_inspeccion }}</strong></td>
                    </tr>
                    <tr>
                        <th>Fecha de Inspección</th>
                        <td>{{ $inspeccion->fecha_inspeccion->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tipo de Inspección</th>
                        <td>{{ ucfirst($inspeccion->tipo_inspeccion) }}</td>
                    </tr>
                    <tr>
                        <th>Lugar</th>
                        <td>{{ $inspeccion->lugar }}</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>{{ $inspeccion->direccion ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Ciudad</th>
                        <td>{{ $inspeccion->ciudad ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Provincia</th>
                        <td>{{ $inspeccion->provincia ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Inspector</th>
                        <td>{{ $inspeccion->inspector->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cargo del Inspector</th>
                        <td>{{ $inspeccion->cargo_inspector ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @php
                                $estados = [
                                    'pendiente' => 'warning',
                                    'en_progreso' => 'info',
                                    'completada' => 'primary',
                                    'aprobada' => 'success',
                                    'rechazada' => 'danger',
                                    'ratificado' => 'success'
                                ];
                            @endphp
                            <span class="badge badge-{{ $estados[$inspeccion->estado] ?? 'secondary' }}">
                                {{ ucfirst($inspeccion->estado) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Nivel de Riesgo</th>
                        <td>
                            @php
                                $riesgos = [
                                    'bajo' => 'success',
                                    'medio' => 'warning',
                                    'alto' => 'danger',
                                    'critico' => 'danger'
                                ];
                            @endphp
                            @if($inspeccion->nivel_riesgo)
                                <span class="badge badge-{{ $riesgos[$inspeccion->nivel_riesgo] ?? 'secondary' }}">
                                    {{ ucfirst($inspeccion->nivel_riesgo) }}
                                </span>
                            @else
                                <span class="badge badge-secondary">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha Próxima Inspección</th>
                        <td>{{ $inspeccion->fecha_proxima_inspeccion ? $inspeccion->fecha_proxima_inspeccion->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cumple Normativas</th>
                        <td>
                            @if($inspeccion->cumple_normativas)
                                <span class="badge badge-success">Sí</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha de Creación</th>
                        <td>{{ $inspeccion->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Flujo de estados -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-primary">Flujo de la Inspección</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Estado</th>
                                <th>Responsable</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Creación -->
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">Creación</span>
                                    @if($inspeccion->estado == 'pendiente')
                                        <span class="badge badge-warning">Actual</span>
                                    @endif
                                </td>
                                <td>{{ $inspeccion->usuarioCrea->name ?? 'N/A' }}</td>
                                <td>{{ $inspeccion->created_at ? $inspeccion->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>

                            <!-- Asignación (En Progreso) -->
                            <tr>
                                <td>
                                    <span class="badge badge-info">En Progreso</span>
                                    @if($inspeccion->estado == 'en_progreso')
                                        <span class="badge badge-warning">Actual</span>
                                    @endif
                                </td>
                                <td>{{ $inspeccion->usuarioAsigna->name ?? 'N/A' }}</td>
                                <td>{{ $inspeccion->fecha_asignacion ? $inspeccion->fecha_asignacion->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>

                            <!-- Aprobación -->
                            <tr>
                                <td>
                                    <span class="badge badge-success">Aprobada</span>
                                    @if($inspeccion->estado == 'aprobada')
                                        <span class="badge badge-warning">Actual</span>
                                    @endif
                                </td>
                                <td>{{ $inspeccion->usuarioAprueba->name ?? 'N/A' }}</td>
                                <td>{{ $inspeccion->fecha_aprobacion ? $inspeccion->fecha_aprobacion->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>

                            <!-- Ratificación -->
                            <tr>
                                <td>
                                    <span class="badge badge-success">Ratificado</span>
                                    @if($inspeccion->estado == 'ratificado')
                                        <span class="badge badge-warning">Actual</span>
                                    @endif
                                </td>
                                <td>{{ $inspeccion->usuarioRatifica->name ?? 'N/A' }}</td>
                                <td>{{ $inspeccion->fecha_ratificacion ? $inspeccion->fecha_ratificacion->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-comment"></i> Observaciones
                    </div>
                    <div class="card-body">
                        {{ $inspeccion->observaciones ?? 'Sin observaciones' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <i class="fas fa-lightbulb"></i> Recomendaciones
                    </div>
                    <div class="card-body">
                        {{ $inspeccion->recomendaciones ?? 'Sin recomendaciones' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection