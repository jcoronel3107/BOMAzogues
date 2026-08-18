@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Movilizaciones de Unidades</h6>
        <a href="{{ route('movilizaciones.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nueva Movilización
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha Salida</th>
                <th>Hora Salida</th>
                <th>Fecha Retorno</th>
                <th>Motivo</th>
                <th>Destino</th>
                <th>Conductor</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movilizaciones as $movilizacion)
            <tr>
                <td>MOV-{{ str_pad($movilizacion->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $movilizacion->fecha_salida ? \Carbon\Carbon::parse($movilizacion->fecha_salida)->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $movilizacion->hora_salida ?? 'N/A' }}</td>
                <td>{{ $movilizacion->fecha_retorno ? \Carbon\Carbon::parse($movilizacion->fecha_retorno)->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $movilizacion->motivo ?? 'N/A' }}</td>
                <td>{{ $movilizacion->destino ?? 'N/A' }}</td>
                <td>{{ $movilizacion->conductor_nombres ?? 'N/A' }}</td>
                <td>{{ $movilizacion->vehiculo_placa ?? 'N/A' }} - {{ $movilizacion->vehiculo_marca ?? 'N/A' }}</td>
                <td>
                    @php
                        $estados = [
                            'pendiente' => 'warning',
                            'aprobado' => 'success',
                            'rechazado' => 'danger',
                            'finalizado' => 'info'
                        ];
                    @endphp
                    <span class="badge badge-{{ $estados[$movilizacion->estado] ?? 'secondary' }}">
                        {{ ucfirst($movilizacion->estado) }}
                    </span>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('movilizaciones.show', $movilizacion) }}" class="btn btn-info btn-sm" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($movilizacion->puedeEditar())
                            <a href="{{ route('movilizaciones.edit', $movilizacion) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('movilizaciones.destroy', $movilizacion) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta movilización?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                        @if($movilizacion->estado == 'pendiente')
                            <form action="{{ route('movilizaciones.autorizar', $movilizacion) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Autorizar" onclick="return confirm('¿Autorizar esta movilización?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('movilizaciones.rechazar', $movilizacion) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="observaciones" value="Movilización rechazada">
                                <button type="submit" class="btn btn-danger btn-sm" title="Rechazar" onclick="return confirm('¿Rechazar esta movilización?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @endif
                        @if($movilizacion->estado == 'aprobado')
                            <button type="button" class="btn btn-primary btn-sm" title="Finalizar" data-toggle="modal" data-target="#modalFinalizar{{ $movilizacion->id }}">
                                <i class="fas fa-flag-checkered"></i>
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
        {{ $movilizaciones->links() }}
    </div>
</div>

<!-- Modales para finalizar -->
@foreach($movilizaciones as $movilizacion)
@if($movilizacion->estado == 'aprobado')
<div class="modal fade" id="modalFinalizar{{ $movilizacion->id }}" tabindex="-1" role="dialog" aria-labelledby="modalFinalizarLabel{{ $movilizacion->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('movilizaciones.finalizar', $movilizacion) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Finalizar Movilización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Hora de Llegada <span class="text-danger">*</span></label>
                        <input type="time" name="hora_llegada" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kilometraje de Llegada <span class="text-danger">*</span></label>
                        <input type="number" name="vehiculo_km_llegada" class="form-control" placeholder="KM" required min="0">
                        <small class="text-muted">KM de salida: {{ $movilizacion->vehiculo_km_salida }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection