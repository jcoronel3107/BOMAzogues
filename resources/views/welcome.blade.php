@extends('layouts.plantilla')

@section('cuerpo')
<div class="container-fluid">
    <!-- Encabezado de bienvenida -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 text-primary">¡Bienvenido, {{ $user->name }}!</h1>
                    <p class="lead text-muted">Sistema de Gestión de Emergencias - FireControl</p>
                    <div class="mt-4">
                        <span class="badge badge-success badge-pill px-3 py-2">
                            <i class="fas fa-calendar-day"></i> Hoy: {{ date('d/m/Y') }}
                        </span>
                        <span class="badge badge-info badge-pill px-3 py-2 ml-2">
                            <i class="fas fa-clock"></i> {{ date('H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen rápido -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Emergencias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmergencias ?? 0 }}</div>
                            <div class="small text-success">+{{ $emergenciasHoy }} hoy</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ambulance fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Novedades</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalNovedades }}</div>
                            <div class="small text-success">+{{ $novedadesHoy }} hoy</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Estaciones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEstaciones }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsuarios }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ===== Emergencias Prehospitalarias ===== --}}
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Emergencias Prehospitalarias</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmergenciasPrehospitalarias }}</div>
                    <div class="small text-success">+{{ $emergenciasPrehospitalariasHoy ?? 0 }} hoy</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-ambulance fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- ===== Emergencias de Fuego ===== --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Emergencias de Fuego</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmergenciasFuego}}</div>
                        <div class="small text-success">+{{ $emergenciasFuegoHoy ?? 0 }} hoy</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fire fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Últimas emergencias y novedades -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-ambulance"></i> Últimas Emergencias</h6>
                    <a href="{{ route('emergencias.index') }}" class="btn btn-primary btn-sm">Ver todas</a>
                </div>
                <div class="card-body">
                    @if($ultimasEmergencias->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Incidente</th>
                                        <th>Estación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimasEmergencias as $emergencia)
                                        <tr>
                                            <td>{{ $emergencia->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $emergencia->tipoIncidente->nombre_incidente ?? 'N/A' }}</td>
                                            <td>{{ $emergencia->estacion->nombre ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">No hay emergencias registradas</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-list"></i> Últimas Novedades</h6>
                    <a href="{{ route('estacion-novedades.index') }}" class="btn btn-primary btn-sm">Ver todas</a>
                </div>
                <div class="card-body">
                    @if($ultimasNovedades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Estación</th>
                                        <th>Elaborado por</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimasNovedades as $novedad)
                                        <tr>
                                            <td>{{ $novedad->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $novedad->estacion->nombre ?? 'N/A' }}</td>
                                            <td>{{ $novedad->usuarioElabora->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">No hay novedades registradas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-rocket"></i> Accesos Rápidos</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('emergencias.create') }}" class="btn btn-outline-primary btn-block py-3">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Nueva Emergencia
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('estacion-novedades.create') }}" class="btn btn-outline-success btn-block py-3">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Nueva Novedad
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('inspeccion.create') }}" class="btn btn-outline-info btn-block py-3">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Nueva Inspección
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('movilizaciones.create') }}" class="btn btn-outline-warning btn-block py-3">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Nueva Movilización
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection