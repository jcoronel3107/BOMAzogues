{{-- resources/views/emergencias_prehospitalarias/estadisticas.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- ===== ENCABEZADO ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div>
            <h2>📊 Estadísticas de Emergencias Prehospitalarias</h2>
            <p class="text-muted mb-0">
                Periodo: <strong>{{ $fechaDesde->format('d/m/Y') }}</strong> al
                <strong>{{ $fechaHasta->format('d/m/Y') }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('emergencias-prehospitalarias.index') }}" class="btn btn-secondary">
                ← Volver al listado
            </a>
        </div>
    </div>

    {{-- ===== FILTRO DE FECHAS ===== --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('emergencias-prehospitalarias.estadisticas') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Desde</label>
                    <input type="date" name="fecha_desde" class="form-control form-control-sm"
                           value="{{ $fechaDesde->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                           value="{{ $fechaHasta->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        🔍 Actualizar
                    </button>
                    <a href="{{ route('emergencias-prehospitalarias.estadisticas') }}"
                       class="btn btn-outline-secondary btn-sm">
                        Últimos 30 días
                    </a>
                </div>
                <div class="col-md-3">
                    <div class="btn-group btn-group-sm w-100" role="group">
                        <a href="{{ route('emergencias-prehospitalarias.estadisticas', ['fecha_desde' => now()->startOfMonth()->format('Y-m-d'), 'fecha_hasta' => now()->endOfMonth()->format('Y-m-d')]) }}"
                           class="btn btn-outline-info">Mes actual</a>
                        <a href="{{ route('emergencias-prehospitalarias.estadisticas', ['fecha_desde' => now()->startOfYear()->format('Y-m-d'), 'fecha_hasta' => now()->endOfYear()->format('Y-m-d')]) }}"
                           class="btn btn-outline-info">Año actual</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== TARJETAS RESUMEN ===== --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75">Total Emergencias</small>
                            <h2 class="mb-0">{{ $resumen['total'] }}</h2>
                        </div>
                        <i class="fs-1 opacity-50">📋</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75">Total Pacientes</small>
                            <h2 class="mb-0">{{ $resumen['total_pacientes'] }}</h2>
                        </div>
                        <i class="fs-1 opacity-50">👥</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75">En Curso</small>
                            <h2 class="mb-0">{{ $resumen['en_curso'] }}</h2>
                        </div>
                        <i class="fs-1 opacity-50">🚨</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-uppercase opacity-75">Finalizadas</small>
                            <h2 class="mb-0">{{ $resumen['finalizadas'] }}</h2>
                        </div>
                        <i class="fs-1 opacity-50">✅</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TENDENCIA ===== --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>📈 Tendencia de Emergencias</strong>
        </div>
        <div class="card-body">
            <canvas id="chartTendencia" height="80"></canvas>
        </div>
    </div>

    {{-- ===== GRÁFICOS CIRCULARES ===== --}}
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <strong>🚨 Por Tipo de Emergencia</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartTipo" height="220"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <strong>🎯 Por Prioridad</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartPrioridad" height="220"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <strong>📋 Por Estado</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartEstado" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PACIENTES: SEXO Y CONDICIÓN ===== --}}
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <strong>👥 Distribución por Sexo</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartSexo" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <strong>❤️ Condición de Pacientes</strong>
                </div>
                <div class="card-body">
                    <canvas id="chartCondicion" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TOP 5 ===== --}}
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <strong>🚑 Top 5 Vehículos</strong>
                </div>
                <div class="card-body">
                    @forelse($topVehiculos as $i => $v)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <span class="badge bg-secondary me-1">{{ $i + 1 }}</span>
                                <strong>{{ $v->vehiculo->placa ?? 'N/A' }}</strong>
                                <small class="text-muted d-block">{{ $v->vehiculo->marca ?? '' }}</small>
                            </div>
                            <span class="badge bg-primary">{{ $v->total }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Sin datos</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <strong>👨‍⚕️ Top 5 Personal</strong>
                </div>
                <div class="card-body">
                    @forelse($topPersonal as $i => $p)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <span class="badge bg-secondary me-1">{{ $i + 1 }}</span>
                                <strong>{{ $p->name }}</strong>
                            </div>
                            <span class="badge bg-success">{{ $p->total }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Sin datos</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <strong>💊 Top 5 Insumos</strong>
                </div>
                <div class="card-body">
                    @forelse($topInsumos as $i => $ins)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <span class="badge bg-secondary me-1">{{ $i + 1 }}</span>
                                <strong>{{ $ins->nombre }}</strong>
                            </div>
                            <span class="badge bg-warning text-dark">{{ $ins->total }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Sin datos</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PROMEDIOS DE SIGNOS VITALES ===== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-danger text-white">
            <strong>❤️ Promedios de Signos Vitales de Pacientes</strong>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-2 col-6 mb-2">
                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block">FC Promedio</small>
                        <strong class="fs-4">{{ $promediosSignos->fc_promedio ?? '—' }}</strong>
                        <small class="d-block text-muted">lpm</small>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block">FR Promedio</small>
                        <strong class="fs-4">{{ $promediosSignos->fr_promedio ?? '—' }}</strong>
                        <small class="d-block text-muted">rpm</small>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block">SatO₂ Promedio</small>
                        <strong class="fs-4">{{ $promediosSignos->sat_promedio ?? '—' }}</strong>
                        <small class="d-block text-muted">%</small>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block">Temp Promedio</small>
                        <strong class="fs-4">{{ $promediosSignos->temp_promedio ?? '—' }}</strong>
                        <small class="d-block text-muted">°C</small>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block">TA Promedio</small>
                        <strong class="fs-5">
                            {{ $promediosSignos->ps_promedio ?? '—' }}/{{ $promediosSignos->pd_promedio ?? '—' }}
                        </strong>
                        <small class="d-block text-muted">mmHg</small>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block">Glasgow Prom.</small>
                        <strong class="fs-4">{{ $promediosSignos->glasgow_promedio ?? '—' }}</strong>
                        <small class="d-block text-muted">/15</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== Paleta de colores =====
    const colores = {
        Rojo: '#dc3545',
        Naranja: '#fd7e14',
        Amarillo: '#ffc107',
        Verde: '#198754',
        Azul: '#0d6efd',
    };
    const paletaGeneral = [
        '#0d6efd', '#dc3545', '#ffc107', '#198754', '#fd7e14',
        '#6f42c1', '#20c997', '#d63384', '#0dcaf0', '#6c757d'
    ];

    // ===== 1. TENDENCIA =====
    new Chart(document.getElementById('chartTendencia'), {
        type: 'line',
        data: {
            labels: @json($tendenciaCompleta->pluck('fecha')),
            datasets: [{
                label: 'Emergencias',
                data: @json($tendenciaCompleta->pluck('total')),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#0d6efd',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // ===== 2. POR TIPO =====
    new Chart(document.getElementById('chartTipo'), {
        type: 'doughnut',
        data: {
            labels: @json($porTipo->pluck('tipo_emergencia')),
            datasets: [{
                data: @json($porTipo->pluck('total')),
                backgroundColor: paletaGeneral,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
            }
        }
    });

    // ===== 3. POR PRIORIDAD =====
    new Chart(document.getElementById('chartPrioridad'), {
        type: 'doughnut',
        data: {
            labels: @json($porPrioridad->pluck('prioridad')),
            datasets: [{
                data: @json($porPrioridad->pluck('total')),
                backgroundColor: @json($porPrioridad->pluck('prioridad')->map(fn($p) => $colores[$p] ?? '#6c757d')),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
            }
        }
    });

    // ===== 4. POR ESTADO =====
    const coloresEstado = {
        'En curso': '#0d6efd',
        'Finalizada': '#198754',
        'Cancelada': '#dc3545',
        'Derivada': '#fd7e14',
    };
    new Chart(document.getElementById('chartEstado'), {
        type: 'doughnut',
        data: {
            labels: @json($porEstado->pluck('estado')),
            datasets: [{
                data: @json($porEstado->pluck('total')),
                backgroundColor: @json($porEstado->pluck('estado')->map(fn($e) => $coloresEstado[$e] ?? '#6c757d')),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
            }
        }
    });

    // ===== 5. PACIENTES POR SEXO =====
    const sexoLabels = { M: 'Masculino', F: 'Femenino', Indefinido: 'Indefinido' };
    new Chart(document.getElementById('chartSexo'), {
        type: 'bar',
        data: {
            labels: @json($porSexo->pluck('sexo')->map(fn($s) => $sexoLabels[$s] ?? $s)),
            datasets: [{
                label: 'Pacientes',
                data: @json($porSexo->pluck('total')),
                backgroundColor: ['#0d6efd', '#d63384', '#6c757d'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } } }
        }
    });

    // ===== 6. CONDICIÓN DE PACIENTES =====
    const coloresCond = {
        'Estable': '#198754',
        'Crítico': '#dc3545',
        'Fallecido': '#212529',
        'Rechaza atención': '#ffc107',
    };
    new Chart(document.getElementById('chartCondicion'), {
        type: 'bar',
        data: {
            labels: @json($porCondicion->pluck('condicion')),
            datasets: [{
                label: 'Pacientes',
                data: @json($porCondicion->pluck('total')),
                backgroundColor: @json($porCondicion->pluck('condicion')->map(fn($c) => $coloresCond[$c] ?? '#6c757d')),
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // Barras horizontales
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } } }
        }
    });
});
</script>
@endsection