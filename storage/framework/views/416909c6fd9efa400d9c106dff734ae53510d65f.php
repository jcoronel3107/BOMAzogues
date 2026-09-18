


<?php $__env->startSection('cuerpo'); ?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-chart-bar text-primary"></i> Estadísticas de Emergencias Prehospitalarias
    </h1>
    <a href="<?php echo e(route('emergencias-prehospitalarias.index')); ?>" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm"></i> Volver al listado
    </a>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-calendar"></i> Periodo:
            <?php echo e($fechaDesde->format('d/m/Y')); ?> al <?php echo e($fechaHasta->format('d/m/Y')); ?>

        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('emergencias-prehospitalarias.estadisticas')); ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small font-weight-bold">Desde</label>
                        <input type="date" name="fecha_desde" class="form-control form-control-sm"
                               value="<?php echo e($fechaDesde->format('Y-m-d')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small font-weight-bold">Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                               value="<?php echo e($fechaHasta->format('Y-m-d')); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i> Actualizar
                            </button>
                            <a href="<?php echo e(route('emergencias-prehospitalarias.estadisticas')); ?>"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-redo"></i> Últimos 30 días
                            </a>
                            <a href="<?php echo e(route('emergencias-prehospitalarias.estadisticas', ['fecha_desde' => now()->startOfMonth()->format('Y-m-d'), 'fecha_hasta' => now()->endOfMonth()->format('Y-m-d')])); ?>"
                               class="btn btn-outline-info btn-sm">
                                Mes actual
                            </a>
                            <a href="<?php echo e(route('emergencias-prehospitalarias.estadisticas', ['fecha_desde' => now()->startOfYear()->format('Y-m-d'), 'fecha_hasta' => now()->endOfYear()->format('Y-m-d')])); ?>"
                               class="btn btn-outline-info btn-sm">
                                Año actual
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Emergencias
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['total']); ?></div>
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Pacientes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['total_pacientes']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            En Curso
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['en_curso']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Finalizadas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['finalizadas']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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


<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-ambulance"></i> Por Tipo de Emergencia
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartTipo" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-exclamation-triangle"></i> Por Prioridad
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartPrioridad" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle"></i> Por Estado
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartEstado" height="220"></canvas>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-venus-mars"></i> Distribución por Sexo
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartSexo" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-heartbeat"></i> Condición de Pacientes
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartCondicion" height="200"></canvas>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-ambulance"></i> Top 5 Vehículos
                </h6>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $topVehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <span class="badge badge-secondary"><?php echo e($i + 1); ?></span>
                            <strong><?php echo e($v->vehiculo->placa ?? 'N/A'); ?></strong>
                            <small class="text-muted d-block"><?php echo e($v->vehiculo->marca ?? ''); ?></small>
                        </div>
                        <span class="badge badge-primary"><?php echo e($v->total); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted mb-0">Sin datos</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-md"></i> Top 5 Personal
                </h6>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $topPersonal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <span class="badge badge-secondary"><?php echo e($i + 1); ?></span>
                            <strong><?php echo e($p->name); ?></strong>
                        </div>
                        <span class="badge badge-success"><?php echo e($p->total); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted mb-0">Sin datos</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-pills"></i> Top 5 Insumos
                </h6>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $topInsumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <span class="badge badge-secondary"><?php echo e($i + 1); ?></span>
                            <strong><?php echo e($ins->descripcion); ?></strong>
                        </div>
                        <span class="badge badge-warning text-dark"><?php echo e($ins->total); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted mb-0">Sin datos</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-heartbeat"></i> Promedios de Signos Vitales de Pacientes
        </h6>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-2 col-6 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">FC Promedio</small>
                    <strong class="h4"><?php echo e($promediosSignos->fc_promedio ?? '—'); ?></strong>
                    <small class="d-block text-muted">lpm</small>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">FR Promedio</small>
                    <strong class="h4"><?php echo e($promediosSignos->fr_promedio ?? '—'); ?></strong>
                    <small class="d-block text-muted">rpm</small>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">SatO₂ Promedio</small>
                    <strong class="h4"><?php echo e($promediosSignos->sat_promedio ?? '—'); ?></strong>
                    <small class="d-block text-muted">%</small>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Temp Promedio</small>
                    <strong class="h4"><?php echo e($promediosSignos->temp_promedio ?? '—'); ?></strong>
                    <small class="d-block text-muted">°C</small>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">TA Promedio</small>
                    <strong class="h5"><?php echo e($promediosSignos->ps_promedio ?? '—'); ?>/<?php echo e($promediosSignos->pd_promedio ?? '—'); ?></strong>
                    <small class="d-block text-muted">mmHg</small>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Glasgow Prom.</small>
                    <strong class="h4"><?php echo e($promediosSignos->glasgow_promedio ?? '—'); ?></strong>
                    <small class="d-block text-muted">/15</small>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

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

    // 1. TENDENCIA
    new Chart(document.getElementById('chartTendencia'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($tendenciaCompleta->pluck('fecha'), 15, 512) ?>,
            datasets: [{
                label: 'Emergencias',
                data: <?php echo json_encode($tendenciaCompleta->pluck('total'), 15, 512) ?>,
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
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } } }
        }
    });

    // 2. POR TIPO
    new Chart(document.getElementById('chartTipo'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($porTipo->pluck('tipo_emergencia'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($porTipo->pluck('total'), 15, 512) ?>,
                backgroundColor: paletaGeneral,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
        }
    });

    // 3. POR PRIORIDAD
    new Chart(document.getElementById('chartPrioridad'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($porPrioridad->pluck('prioridad'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($porPrioridad->pluck('total'), 15, 512) ?>,
                backgroundColor: <?php echo json_encode($porPrioridad->pluck('prioridad')->map(fn($p) => $colores[$p] ?? '#6c757d'), 15, 512) ?>,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
        }
    });

    // 4. POR ESTADO
    const coloresEstado = {
        'En curso': '#0d6efd',
        'Finalizada': '#198754',
        'Cancelada': '#dc3545',
        'Derivada': '#fd7e14',
    };
    new Chart(document.getElementById('chartEstado'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($porEstado->pluck('estado'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($porEstado->pluck('total'), 15, 512) ?>,
                backgroundColor: <?php echo json_encode($porEstado->pluck('estado')->map(fn($e) => $coloresEstado[$e] ?? '#6c757d'), 15, 512) ?>,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
        }
    });

    // 5. SEXO
    const sexoLabels = { M: 'Masculino', F: 'Femenino', Indefinido: 'Indefinido' };
    new Chart(document.getElementById('chartSexo'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($porSexo->pluck('sexo')->map(fn($s) => $sexoLabels[$s] ?? $s), 15, 512) ?>,
            datasets: [{
                label: 'Pacientes',
                data: <?php echo json_encode($porSexo->pluck('total'), 15, 512) ?>,
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

    // 6. CONDICIÓN
    const coloresCond = {
        'Estable': '#198754',
        'Crítico': '#dc3545',
        'Fallecido': '#212529',
        'Rechaza atención': '#ffc107',
    };
    new Chart(document.getElementById('chartCondicion'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($porCondicion->pluck('condicion'), 15, 512) ?>,
            datasets: [{
                label: 'Pacientes',
                data: <?php echo json_encode($porCondicion->pluck('total'), 15, 512) ?>,
                backgroundColor: <?php echo json_encode($porCondicion->pluck('condicion')->map(fn($c) => $coloresCond[$c] ?? '#6c757d'), 15, 512) ?>,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } } }
        }
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_prehospitalarias/estadisticas.blade.php ENDPATH**/ ?>