

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Resultados del Reporte</h6>
        <div>
            <button onclick="window.print()" class="btn btn-secondary btn-sm">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <a href="<?php echo e(route('reportes.emergencias.pdf', ['fecha_desde' => $fechaDesde, 'fecha_hasta' => $fechaHasta])); ?>" class="btn btn-danger btn-sm" target="_blank">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            <a href="<?php echo e(route('reportes.emergencias')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Resumen -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Emergencias</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalEmergencias); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ambulance fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Estaciones</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalEstaciones); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Parroquias</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalParroquias); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Periodo</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <?php echo e(date('d/m/Y', strtotime($fechaDesde))); ?><br>
                                    al <?php echo e(date('d/m/Y', strtotime($fechaHasta))); ?>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
    <!-- Gráfico de Barras - Tipo de Incidente -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Emergencias por Tipo de Incidente</h6>
            </div>
            <div class="card-body">
                <div style="height: 350px;">
                    <canvas id="chartBarrasTipo"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Barras - Por Día -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Emergencias por Día</h6>
            </div>
            <div class="card-body">
                <div style="height: 350px;">
                    <canvas id="chartBarrasDia"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Tabla de detalles -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detalle de Emergencias</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable">
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
                                    <?php $__empty_1 = true; $__currentLoopData = $emergencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emergencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($emergencia->id); ?></td>
                                            <td><?php echo e($emergencia->fecha->format('d/m/Y')); ?></td>
                                            <td><?php echo e($emergencia->tipoIncidente->nombre_incidente ?? 'N/A'); ?></td>
                                            <td><?php echo e($emergencia->estacion->nombre ?? 'N/A'); ?></td>
                                            <td><?php echo e($emergencia->parroquia->nombre ?? 'N/A'); ?></td>
                                            <td><?php echo e($emergencia->ciudadano_afectado ?? 'N/A'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No hay emergencias en el periodo seleccionado</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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
    // Datos para el gráfico de barras - Tipo de Incidente
    const labels = <?php echo json_encode($datosGrafico->pluck('nombre_incidente'), 15, 512) ?>;
    const data = <?php echo json_encode($datosGrafico->pluck('total'), 15, 512) ?>;
    const colores = <?php echo json_encode($colores, 15, 512) ?>;

    // Gráfico de Barras - Tipo de Incidente
    const ctxBarrasTipo = document.getElementById('chartBarrasTipo').getContext('2d');
    new Chart(ctxBarrasTipo, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Número de Emergencias',
                data: data,
                backgroundColor: colores.slice(0, labels.length),
                borderColor: '#ffffff',
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
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 20,
                        font: { size: 10 }
                    }
                }
            }
        }
    });

    // Datos para el gráfico de barras - Por Día
    const fechas = <?php echo json_encode($datosBarras->pluck('fecha'), 15, 512) ?>;
    const totales = <?php echo json_encode($datosBarras->pluck('total'), 15, 512) ?>;

    // Gráfico de Barras - Por Día
    const ctxBarrasDia = document.getElementById('chartBarrasDia').getContext('2d');
    new Chart(ctxBarrasDia, {
        type: 'bar',
        data: {
            labels: fechas,
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
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 20,
                        font: { size: 9 }
                    }
                }
            }
        }
    });
});
</script>

<style>
    @media  print {
        .btn, .btn-group { display: none !important; }
        .card-header .btn { display: none !important; }
        .no-print { display: none !important; }
    }
    .card { break-inside: avoid; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/reportes/emergencias-resultados.blade.php ENDPATH**/ ?>