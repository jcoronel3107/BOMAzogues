@extends('layouts.plantilla')

@section('cuerpo')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard de Emergencias</h1>
        <a href="{{ route('emergencias.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Ver Emergencias
        </a>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Emergencias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmergencias }}</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Estaciones</div>
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Parroquias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalParroquias }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Vehículos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVehiculos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Emergencias por Mes</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="chartEmergenciasMes"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Emergencias por Tipo</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie" style="height: 250px;">
                        <canvas id="chartEmergenciasTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas de Top -->
    <div class="row">
        <!-- Estaciones con más emergencias -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🏢 Estaciones con más Emergencias</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Estación</th>
                                    <th class="text-center">Emergencias</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estacionesTop as $key => $estacion)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $estacion->nombre ?? 'N/A' }}</td>
                                        <td class="text-center"><span class="badge badge-primary">{{ $estacion->total }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No hay datos</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergencias más repetidas -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🔥 Emergencias más Repetidas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tipo de Incidente</th>
                                    <th class="text-center">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emergenciasMasRepetidas as $key => $incidente)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $incidente->nombre_incidente ?? 'N/A' }}</td>
                                        <td class="text-center"><span class="badge badge-danger">{{ $incidente->total }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No hay datos</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Emergencias por parroquia -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">📍 Emergencias por Parroquia</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Parroquia</th>
                                    <th class="text-center">Emergencias</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emergenciasPorParroquia as $key => $parroquia)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $parroquia->nombre ?? 'N/A' }}</td>
                                        <td class="text-center"><span class="badge badge-info">{{ $parroquia->total }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No hay datos</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehículos que más atienden emergencias -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🚛 Vehículos que más atienden Emergencias</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vehículo</th>
                                    <th class="text-center">Emergencias</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehiculosTop as $key => $vehiculo)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</td>
                                        <td class="text-center"><span class="badge badge-success">{{ $vehiculo->total }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No hay datos</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas emergencias -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">📋 Últimas Emergencias Registradas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Incidente</th>
                                    <th>Estación</th>
                                    <th>Parroquia</th>
                                    <th>Ciudadano Afectado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimasEmergencias as $emergencia)
                                    <tr>
                                        <td>{{ $emergencia->id }}</td>
                                        <td>{{ $emergencia->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $emergencia->tipoIncidente->nombre_incidente ?? 'N/A' }}</td>
                                        <td>{{ $emergencia->estacion->nombre ?? 'N/A' }}</td>
                                        <td>{{ $emergencia->parroquia->nombre ?? 'N/A' }}</td>
                                        <td>{{ $emergencia->ciudadano_afectado ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center">No hay emergencias registradas</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de emergencias por mes
    const ctxBar = document.getElementById('chartEmergenciasMes').getContext('2d');
    
    // Datos desde PHP
    const meses = @json($emergenciasPorMes->pluck('mes'));
    const totales = @json($emergenciasPorMes->pluck('total'));
    
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Emergencias',
                data: totales,
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Gráfico de tipos de emergencia
    const ctxDona = document.getElementById('chartEmergenciasTipo').getContext('2d');
    
    const tipos = @json($emergenciasMasRepetidas->pluck('nombre_incidente'));
    const cantidades = @json($emergenciasMasRepetidas->pluck('total'));
    const colores = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#f8f9fc', '#d1d3e2', '#bac8f3'];
    
    new Chart(ctxDona, {
        type: 'doughnut',
        data: {
            labels: tipos,
            datasets: [{
                data: cantidades,
                backgroundColor: colores,
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 10 }
                    }
                }
            },
            cutout: '65%'
        }
    });
});
</script>

<style>
    .chart-area { position: relative; height: 300px; }
    .chart-pie { position: relative; height: 250px; }
    .badge { font-size: 14px; padding: 5px 10px; }
</style>
@endsection