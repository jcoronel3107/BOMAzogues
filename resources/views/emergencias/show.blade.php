@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Emergencia</h6>
        <div>
            <a href="{{ route('emergencias.edit', $emergencia) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('emergencias.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                    <i class="fas fa-info-circle"></i> Información Emergencia
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">
                    <i class="fas fa-users"></i> Personal en Emergencia
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="vehiculos-tab" data-toggle="tab" href="#vehiculos" role="tab" aria-controls="vehiculos" aria-selected="false">
                    <i class="fas fa-truck"></i> Vehículos
                </a>
            </li>
        </ul>

        <div class="tab-content mt-4" id="myTabContent">

            <!-- Pestaña 1: Información Emergencia -->
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $emergencia->id }}</td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td>{{ $emergencia->fecha->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Información Inicial</th>
                        <td>{{ $emergencia->informacion_inicial }}</td>
                    </tr>
                    <tr>
                        <th>Tipo de Incidente</th>
                        <td>{{ $emergencia->tipoIncidente->nombre_incidente ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Subcategoría</th>
                        <td>{{ $emergencia->subcategoria ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Estación</th>
                        <td>{{ $emergencia->estacion->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Hora Salida a Emergencia</th>
                        <td>{{ $emergencia->hora_salida_emergencia }}</td>
                    </tr>
                    <tr>
                        <th>Hora Llegada a Emergencia</th>
                        <td>{{ $emergencia->hora_llegada_emergencia }}</td>
                    </tr>
                    <tr>
                        <th>Hora en Base</th>
                        <td>{{ $emergencia->hora_en_base }}</td>
                    </tr>
                    <tr>
                        <th>Detalle de la Emergencia</th>
                        <td>{{ $emergencia->detalle_emergencia }}</td>
                    </tr>
                    <tr>
                        <th>Ciudadano Afectado</th>
                        <td>{{ $emergencia->ciudadano_afectado ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Daños Estimados</th>
                        <td>{{ $emergencia->danos_estimados ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Creado por</th>
                        <td>{{ $emergencia->usr_creador ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Creación</th>
                        <td>{{ $emergencia->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($emergencia->usr_editor)
                    <tr>
                        <th>Última Edición por</th>
                        <td>{{ $emergencia->usr_editor }}</td>
                    </tr>
                    <tr>
                        <th>Última Actualización</th>
                        <td>{{ $emergencia->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <!-- Pestaña 2: Personal en Emergencia -->
            <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                @if($emergencia->usuarios->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emergencia->usuarios as $key => $usuario)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->cargo ?? 'Bombero' }}</td>
                                        <td>{{ $usuario->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay personal registrado en esta emergencia.
                    </div>
                @endif
            </div>

            <!-- Pestaña 3: Vehículos -->
            <div class="tab-pane fade" id="vehiculos" role="tabpanel" aria-labelledby="vehiculos-tab">
                @if($emergencia->vehiculos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vehículo</th>
                                    <th>Conductor</th>
                                    <th>KM Salida</th>
                                    <th>KM Retorno</th>
                                    <th>KM Recorridos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emergencia->vehiculos as $key => $vehiculo)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</td>
                                        <td>{{ $vehiculo->pivot->conductor_id ? App\User::find($vehiculo->pivot->conductor_id)->name ?? 'N/A' : 'N/A' }}</td>
                                        <td>{{ $vehiculo->pivot->km_salida ?? 'N/A' }}</td>
                                        <td>{{ $vehiculo->pivot->km_retorno ?? 'N/A' }}</td>
                                        <td>
                                            @if($vehiculo->pivot->km_salida && $vehiculo->pivot->km_retorno)
                                                {{ $vehiculo->pivot->km_retorno - $vehiculo->pivot->km_salida }} KM
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay vehículos registrados en esta emergencia.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection