@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Novedad</h6>
        <div>
            <a href="{{ route('estacion-novedades.export.emergencias', $novedad) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Exportar Emergencias
             </a>
            <!-- Botón Enviar Correo -->
            <a href="{{ route('estacion-novedades.enviar-correo', $novedad) }}" class="btn btn-info btn-sm" title="Enviar por Correo">
                <i class="fas fa-envelope"></i> Enviar Correo
            </a>
            <a href="{{ route('estacion-novedades.pdf', $novedad) }}" class="btn btn-danger btn-sm" target="_blank">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            @can('revisar novedades')
                @if($novedad->estado == 'elaboracion')
                    <form action="{{ route('estacion-novedades.enviar-revision', $novedad) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane"></i> Enviar a Revisión
                        </button>
                    </form>
                @endif
            @endcan
            @can('aprobar novedades')
                @if($novedad->estado == 'revision')
                    <form action="{{ route('estacion-novedades.aprobar', $novedad) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de aprobar esta novedad?')">
                            <i class="fas fa-check"></i> Aprobar
                        </button>
                    </form>
                @endif
            @endcan

           

            
            <a href="{{ route('estacion-novedades.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5>NOV-{{ str_pad($novedad->id, 6, '0', STR_PAD_LEFT) }}</h5>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Fecha</th>
                        <td>{{ $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha)) }}</td>
                    </tr>
                    <tr>
                        <th>Estación</th>
                        <td>{{ $novedad->estacion->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @php
                                $estados = [
                                    'elaboracion' => 'warning',
                                    'revision' => 'info',
                                    'aprobado' => 'success'
                                ];
                            @endphp
                            <span class="badge badge-{{ $estados[$novedad->estado] ?? 'secondary' }}">
                                {{ ucfirst($novedad->estado) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Elaborado por</th>
                        <td>{{ $novedad->usuarioElabora->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha Elaboración</th>
                        <td>{{ $novedad->fecha_elaboracion instanceof \Carbon\Carbon ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_elaboracion)) }}</td>
                    </tr>
                    @if($novedad->usuarioRevisa)
                        <tr>
                            <th>Revisado por</th>
                            <td>{{ $novedad->usuarioRevisa->name }}</td>
                        </tr>
                        <tr>
                            <th>Fecha Revisión</th>
                            <td>{{ $novedad->fecha_revision instanceof \Carbon\Carbon ? $novedad->fecha_revision->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_revision)) }}</td>
                        </tr>
                    @endif
                    @if($novedad->usuarioAprueba)
                        <tr>
                            <th>Aprobado por</th>
                            <td>{{ $novedad->usuarioAprueba->name }}</td>
                        </tr>
                        <tr>
                            <th>Fecha Aprobación</th>
                            <td>{{ $novedad->fecha_aprobacion instanceof \Carbon\Carbon ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_aprobacion)) }}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-comment"></i> Observaciones Generales
                    </div>
                    <div class="card-body">
                        {{ $novedad->observaciones ?? 'Sin observaciones' }}
                    </div>
                </div>
            </div>

            <!-- Flujo de estados -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="text-primary">Flujo de la Novedad</h5>
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
                                <!-- Elaboración -->
                                <tr>
                                    <td>
                                        <span class="badge badge-secondary">Elaboración</span>
                                        @if($novedad->estado == 'elaboracion')
                                            <span class="badge badge-warning">Actual</span>
                                        @endif
                                    </td>
                                    <td>{{ $novedad->usuarioElabora->name ?? 'N/A' }}</td>
                                    <td>{{ $novedad->fecha_elaboracion ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : 'N/A' }}</td>
                                </tr>

                                <!-- Revisión -->
                                <tr>
                                    <td>
                                        <span class="badge badge-info">Revisión</span>
                                        @if($novedad->estado == 'revision')
                                            <span class="badge badge-warning">Actual</span>
                                        @endif
                                    </td>
                                    <td>{{ $novedad->usuarioRevisa->name ?? 'N/A' }}</td>
                                    <td>{{ $novedad->fecha_revision ? $novedad->fecha_revision->format('d/m/Y H:i') : 'N/A' }}</td>
                                </tr>

                                <!-- Aprobación -->
                                <tr>
                                    <td>
                                        <span class="badge badge-success">Aprobado</span>
                                        @if($novedad->estado == 'aprobado')
                                            <span class="badge badge-warning">Actual</span>
                                        @endif
                                    </td>
                                    <td>{{ $novedad->usuarioAprueba->name ?? 'N/A' }}</td>
                                    <td>{{ $novedad->fecha_aprobacion ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : 'N/A' }}</td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            /*================================


            */=================================


            
        </div>

        <!-- Emergencias -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-primary">Emergencias Atendidas</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Lugar</th>
                                <th>Hora Ingreso</th>
                                <th>Hora Salida</th>
                                <th>Afectados</th>
                                <th>Vehículos</th>
                                <th>Bomberos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($novedad->emergencias as $key => $emergencia)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ ucfirst($emergencia->tipo_emergencia) }}</td>
                                    <td>{{ $emergencia->lugar }}</td>
                                    <td>{{ $emergencia->hora_ingreso }}</td>
                                    <td>{{ $emergencia->hora_salida ?? '-' }}</td>
                                    <td>{{ $emergencia->numero_afectados }}</td>
                                    <td>{{ $emergencia->numero_vehiculos }}</td>
                                    <td>{{ $emergencia->numero_bomberos }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay emergencias registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Vehículos -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-primary">Novedades de Vehículos</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Vehículo</th>
                                <th>Estado</th>
                                <th>Tipo Novedad</th>
                                <th>Fecha Reporte</th>
                                <th>Fecha Solución</th>
                                <th>Kilometraje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($novedad->vehiculos as $key => $vehiculo)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $vehiculo->vehiculo->placa ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($vehiculo->estado) }}</td>
                                    <td>{{ $vehiculo->tipo_novedad }}</td>
                                    <td>{{ $vehiculo->fecha_reporte instanceof \Carbon\Carbon ? $vehiculo->fecha_reporte->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_reporte)) }}</td>
                                    <td>{{ $vehiculo->fecha_solucion ? ($vehiculo->fecha_solucion instanceof \Carbon\Carbon ? $vehiculo->fecha_solucion->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_solucion))) : '-' }}</td>
                                    <td>{{ $vehiculo->kilometraje ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay novedades de vehículos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Personal -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="text-primary">Novedades de Personal</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Cargo</th>
                                <th>Turno</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($novedad->personal as $key => $persona)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $persona->user->name ?? 'N/A' }}</td>
                                    <td>{{ $persona->cargo }}</td>
                                    <td>{{ ucfirst($persona->turno) }}</td>
                                    <td>{{ $persona->hora_entrada ?? '-' }}</td>
                                    <td>{{ $persona->hora_salida ?? '-' }}</td>
                                    <td>
                                        @php
                                            $estadosPersonal = [
                                                'presente' => 'success',
                                                'ausente' => 'danger',
                                                'permiso' => 'warning',
                                                'licencia' => 'info',
                                                'comision' => 'primary'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $estadosPersonal[$persona->estado] ?? 'secondary' }}">
                                            {{ ucfirst($persona->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay personal registrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Integrantes de la Guardia -->
            @if($novedad->integrantes_guardia && count($novedad->integrantes_guardia) > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="text-primary">Integrantes de la Guardia Bomberil</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Cédula</th>
                                    <th>Cargo</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($novedad->integrantes_guardia as $key => $integrante)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $integrante['nombre'] ?? 'N/A' }}</td>
                                        <td>{{ $integrante['cedula'] ?? 'N/A' }}</td>
                                        <td>{{ $integrante['cargo'] ?? 'N/A' }}</td>
                                        <td>{{ $integrante['observaciones'] ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        
    </div>
</div>
@endsection