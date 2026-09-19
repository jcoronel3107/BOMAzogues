@extends('layouts.plantilla')

@section('cuerpo')

{{-- ===== ENCABEZADO ===== --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-chart-bar text-danger"></i> Estadísticas de Emergencias de Fuego
    </h1>
    <a href="{{ route('emergencias-fuego.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm"></i> Volver al listado
    </a>
</div>

{{-- ===== FILTRO DE FECHAS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-calendar"></i> Periodo:
            {{ $fechaDesde->format('d/m/Y') }} al {{ $fechaHasta->format('d/m/Y') }}
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('emergencias-fuego.estadisticas') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small font-weight-bold">Desde</label>
                        <input type="date" name="fecha_desde" class="form-control form-control-sm"
                               value="{{ $fechaDesde->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small font-weight-bold">Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                               value="{{ $fechaHasta->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i> Actualizar
                            </button>
                            <a href="{{ route('emergencias-fuego.estadisticas') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-redo"></i> Últimos 30 días
                            </a>
                            <a href="{{ route('emergencias-fuego.estadisticas', ['fecha_desde' => now()->startOfMonth()->format('Y-m-d'), 'fecha_hasta' => now()->endOfMonth()->format('Y-m-d')]) }}"
                               class="btn btn-outline-info btn-sm">Mes actual</a>
                            <a href="{{ route('emergencias-fuego.estadisticas', ['fecha_desde' => now()->startOfYear()->format('Y-m-d'), 'fecha_hasta' => now()->endOfYear()->format('Y-m-d')]) }}"
                               class="btn btn-outline-info btn-sm">Año actual</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ===== TARJETAS RESUMEN ===== --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['total'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-fire fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Curso</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['en_curso'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-hourglass-half fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Extinguidos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['extinguidos'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Agua Utilizada (L)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($resumen['total_agua'], 0) }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-tint fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== VÍCTIMAS Y PÉRDIDAS ===== --}}
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Heridos</div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $resumen['total_heridos'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Fallecidos</div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $resumen['total_fallecidos'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pérdidas Estimadas Totales</div>
                <div class="h4 mb-0 font-weight-bold text-gray-800">
                    $ {{ number_format($resumen['total_perdidas'], 2) }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== TENDENCIA ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-line"></i> Tendencia de Emergencias
        </h6>
    </div>
    <div class="card-body">
        <canvas id="chartTendencia" height="80"></canvas>
    </div>
</div>

{{-- ===== GRÁFICOS ===== --}}
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fire"></i> Por Tipo de Fuego</h6>
            </div>
            <div class="card-body"><canvas id="chartTipo" height="220"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-exclamation-triangle"></i> Por Nivel de Riesgo</h6>
            </div>
            <div class="card-body"><canvas id="chartNivel" height="220"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle"></i> Por Estado</h6>
            </div>
            <div class="card-body"><canvas id="chartEstado" height="220"></canvas></div>
        </div>
    </div>
</div>

{{-- ===== TOP 5 ===== --}}
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-truck"></i> Top 5 Vehículos</h6>
            </div>
            <div class="card-body">
                @forelse($topVehiculos as $i => $v)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <span class="badge badge-secondary">{{ $i + 1 }}</span>
                            <strong>{{ $v->placa }}</strong>
                            <small class="text-muted d-block">{{ $v->marca ?? '' }}</small>
                        </div>
                        <span class="badge badge-primary">{{ $v->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Sin datos</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-md"></i> Top 5 Personal</h6>
            </div>
            <div class="card-body">
                @forelse($topPersonal as $i => $p)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <span class="badge badge-secondary">{{ $i + 1 }}</span>
                            <strong>{{ $p->name }}</strong>
                        </div>
                        <span class="badge badge-success">{{ $p->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Sin datos</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fire-extinguisher"></i> Top 5 Causas</h6>
            </div>
            <div class="card-body">
                @forelse($topCausas as $i => $c)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <span class="badge badge-secondary">{{ $i + 1 }}</span>
                            <strong>{{ $c->causa_probable }}</strong>
                        </div>
                        <span class="badge badge-warning text-dark">{{ $c->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Sin datos</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const paletaGeneral = ['#dc3545', '#fd7e14', '#ffc107', '#198754', '#0d6efd', '#6f42c1', '#20c997', '#d63384'];
    const coloresNivel = { 'Bajo': '#198754', 'Medio': '#0dcaf0', 'Alto': '#ffc107', 'Crítico': '#dc3545' };
    const coloresEstado = { 'En curso': '#0d6efd', 'Controlado': '#0dcaf0', 'Extinguido': '#198754', 'En investigación': '#ffc107', 'Finalizado': '#6c757d' };

    // 1. TENDENCIA
    new Chart(document.getElementById('chartTendencia'), {
        type: 'line',
        data: {
            labels: @json($tendenciaCompleta->pluck('fecha')),
            datasets: [{
                label: 'Emergencias',
                data: @json($tendenciaCompleta->pluck('total')),
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.15)',
                tension: 0.3, fill: true, pointRadius: 4, pointBackgroundColor: '#dc3545'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } } }
        }
    });

    // 2. POR TIPO
    new Chart(document.getElementById('chartTipo'), {
        type: 'doughnut',
        data: {
            labels: @json($porTipo->pluck('tipo_fuego')),
            datasets: [{ data: @json($porTipo->pluck('total')), backgroundColor: paletaGeneral, borderWidth: 2, borderColor: '#fff' }]
        },
        options: { responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
        }
    });

    // 3. POR NIVEL
    new Chart(document.getElementById('chartNivel'), {
        type: 'doughnut',
        data: {
            labels: @json($porNivel->pluck('nivel_riesgo')),
            datasets: [{
                data: @json($porNivel->pluck('total')),
                backgroundColor: @json($porNivel->pluck('nivel_riesgo')->map(fn($n) => $coloresNivel[$n] ?? '#6c757d')),
                borderWidth: 2, borderColor: '#fff'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
        }
    });

    // 4. POR ESTADO
    new Chart(document.getElementById('chartEstado'), {
        type: 'doughnut',
        data: {
            labels: @json($porEstado->pluck('estado')),
            datasets: [{
                data: @json($porEstado->pluck('total')),
                backgroundColor: @json($porEstado->pluck('estado')->map(fn($e) => $coloresEstado[$e] ?? '#6c757d')),
                borderWidth: 2, borderColor: '#fff'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
        }
    });
});
</script>

@endsection