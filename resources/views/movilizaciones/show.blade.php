@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Movilización</h6>
        <div>
            <!-- Botón Enviar Correo -->
            <a href="{{ route('movilizaciones.enviar-correo', $movilizacion) }}" class="btn btn-info btn-sm" title="Enviar por Correo">
                <i class="fas fa-envelope"></i> Enviar Correo
            </a>
            <a href="{{ route('movilizaciones.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5>MOV-{{ str_pad($movilizacion->id, 6, '0', STR_PAD_LEFT) }}</h5>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Fecha de Salida</th>
                        <td>{{ $movilizacion->fecha_salida ? \Carbon\Carbon::parse($movilizacion->fecha_salida)->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Hora de Salida</th>
                        <td>{{ $movilizacion->hora_salida ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Retorno</th>
                        <td>{{ $movilizacion->fecha_retorno ? \Carbon\Carbon::parse($movilizacion->fecha_retorno)->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>KM de Salida</th>
                        <td>{{ $movilizacion->km_salida ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>KM de Retorno</th>
                        <td>{{ $movilizacion->km_retorno ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>KM Recorridos</th>
                        <td>
                            @if($movilizacion->km_salida && $movilizacion->km_retorno)
                                {{ $movilizacion->km_retorno - $movilizacion->km_salida }} KM
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Motivo</th>
                        <td>{{ $movilizacion->motivo ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Lugar de Origen</th>
                        <td>{{ $movilizacion->lugar_origen ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Destino</th>
                        <td>{{ $movilizacion->destino ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
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
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Conductor</th>
                        <td>{{ $movilizacion->conductor_nombres ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cédula del Conductor</th>
                        <td>{{ $movilizacion->conductor_cedula ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cargo del Conductor</th>
                        <td>{{ $movilizacion->conductor_cargo ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Vehículo</th>
                        <td>{{ $movilizacion->vehiculo_marca ?? 'N/A' }} - {{ $movilizacion->vehiculo_placa ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Usuario Asignado</th>
                        <td>{{ $movilizacion->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Creado por</th>
                        <td>{{ $movilizacion->usuarioCrea->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Autorizado por</th>
                        <td>{{ $movilizacion->usuarioAutoriza->name ?? 'Pendiente' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha Autorización</th>
                        <td>{{ $movilizacion->fecha_autorizacion ? \Carbon\Carbon::parse($movilizacion->fecha_autorizacion)->format('d/m/Y H:i') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha Creación</th>
                        <td>{{ $movilizacion->created_at ? \Carbon\Carbon::parse($movilizacion->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Integrantes -->
        @if($movilizacion->integrantes && count($movilizacion->integrantes) > 0)
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-primary">Integrantes de la Comisión</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nombres y Apellidos</th>
                                <th>Cédula</th>
                                <th>Cargo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movilizacion->integrantes as $key => $integrante)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $integrante['nombre'] ?? 'N/A' }}</td>
                                    <td>{{ $integrante['cedula'] ?? 'N/A' }}</td>
                                    <td>{{ $integrante['cargo'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No hay integrantes registrados para esta comisión.
                </div>
            </div>
        </div>
        @endif

        <!-- Observaciones -->
        @if($movilizacion->observaciones)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-comment"></i> Observaciones
                    </div>
                    <div class="card-body">
                        {{ $movilizacion->observaciones }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Botones de acción -->
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                @if($movilizacion->puedeEditar())
                    <a href="{{ route('movilizaciones.edit', $movilizacion) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                @endif
                @if($movilizacion->estado == 'pendiente')
                    <form action="{{ route('movilizaciones.autorizar', $movilizacion) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('¿Autorizar esta movilización?')">
                            <i class="fas fa-check"></i> Autorizar
                        </button>
                    </form>
                    <form action="{{ route('movilizaciones.rechazar', $movilizacion) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="observaciones" value="Movilización rechazada">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Rechazar esta movilización?')">
                            <i class="fas fa-times"></i> Rechazar
                        </button>
                    </form>
                @endif
                @if($movilizacion->estado == 'aprobado')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFinalizar">
                        <i class="fas fa-flag-checkered"></i> Finalizar
                    </button>
                @endif
                @if($movilizacion->estado == 'finalizado')
                    <div class="alert alert-success d-inline-block">
                        <i class="fas fa-check-circle"></i> Esta movilización ya ha sido finalizada.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Finalizar -->
@if($movilizacion->estado == 'aprobado')
<div class="modal fade" id="modalFinalizar" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <label>Fecha de Retorno <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_retorno" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kilometraje de Retorno <span class="text-danger">*</span></label>
                        <input type="number" name="km_retorno" class="form-control" placeholder="KM" required min="0">
                        <small class="text-muted">KM de salida: {{ $movilizacion->km_salida ?? 0 }}</small>
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
@endsection