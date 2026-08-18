@extends('layouts.plantilla')

@section('cuerpo')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard de Novedades</h1>
        <a href="{{ route('estacion-novedades.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver a Novedades
        </a>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Novedades</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalNovedades }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Aprobadas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $novedadesPorEstado['aprobado'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Revisión</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $novedadesPorEstado['revision'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $novedadesPorEstado['elaboracion'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <!-- Gráfico de barras: Novedades por mes -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Novedades por Mes</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartNovedadesMensual"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de dona: Novedades por estado -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribución por Estado</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="chartEstado"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($novedadesPorEstado as $estado => $total)
                            @php
                                $colores = [
                                    'elaboracion' => 'danger',
                                    'revision' => 'warning',
                                    'aprobado' => 'success'
                                ];
                                $labels = [
                                    'elaboracion' => 'Pendiente',
                                    'revision' => 'En Revisión',
                                    'aprobado' => 'Aprobado'
                                ];
                            @endphp
                            <span class="mr-2">
                                <i class="fas fa-circle text-{{ $colores[$estado] ?? 'secondary' }}"></i> {{ $labels[$estado] ?? $estado }} ({{ $total }})
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas adicionales -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Emergencias Atendidas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmergencias }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fire fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Personal Registrado</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPersonal }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Vehículos con Novedades</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVehiculos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tipos de Emergencia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiposEmergencias->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de últimos registros -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Últimas Novedades</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Fecha</th>
                                    <th>Estación</th>
                                    <th>Elaborado por</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimasNovedades as $novedad)
                                    <tr>
                                        <td>NOV-{{ str_pad($novedad->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $novedad->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $novedad->estacion->nombre ?? 'N/A' }}</td>
                                        <td>{{ $novedad->usuarioElabora->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $estados = ['elaboracion' => 'danger', 'revision' => 'warning', 'aprobado' => 'success'];
                                                $labels = ['elaboracion' => 'Pendiente', 'revision' => 'En Revisión', 'aprobado' => 'Aprobado'];
                                            @endphp
                                            <span class="badge badge-{{ $estados[$novedad->estado] ?? 'secondary' }}">
                                                {{ $labels[$novedad->estado] ?? $novedad->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('estacion-novedades.show', $novedad) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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
    // Gráfico de novedades por mes
    const ctxBar = document.getElementById('chartNovedadesMensual').getContext('2d');
    
    // Datos del gráfico desde PHP
    const meses = @json($novedadesPorMes->pluck('mes'));
    const totales = @json($novedadesPorMes->pluck('total'));
    
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Novedades',
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
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico de dona - Estados
    const ctxDona = document.getElementById('chartEstado').getContext('2d');
    
    const estados = @json(array_keys($novedadesPorEstado));
    const totalesEstado = @json(array_values($novedadesPorEstado));
    const coloresEstado = {
        'elaboracion': '#e74a3b',
        'revision': '#f6c23e',
        'aprobado': '#1cc88a'
    };
    
    const colores = estados.map(e => coloresEstado[e] || '#858796');
    const labels = {
        'elaboracion': 'Pendiente',
        'revision': 'En Revisión',
        'aprobado': 'Aprobado'
    };
    
    new Chart(ctxDona, {
        type: 'doughnut',
        data: {
            labels: estados.map(e => labels[e] || e),
            datasets: [{
                data: totalesEstado,
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
                    display: false
                }
            },
            cutout: '70%'
        }
    });
});
</script>

<style>
    .chart-area {
        position: relative;
        height: 300px;
    }
    .chart-pie {
        position: relative;
        height: 250px;
    }
</style>
@endsection