

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Novedad</h6>
        <div>
            <a href="<?php echo e(route('estacion-novedades.export.emergencias', $novedad)); ?>" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Exportar Emergencias
             </a>
            <!-- Botón Enviar Correo -->
            <a href="<?php echo e(route('estacion-novedades.enviar-correo', $novedad)); ?>" class="btn btn-info btn-sm" title="Enviar por Correo">
                <i class="fas fa-envelope"></i> Enviar Correo
            </a>
            <a href="<?php echo e(route('estacion-novedades.pdf', $novedad)); ?>" class="btn btn-danger btn-sm" target="_blank">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('revisar novedades')): ?>
                <?php if($novedad->estado == 'elaboracion'): ?>
                    <form action="<?php echo e(route('estacion-novedades.enviar-revision', $novedad)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane"></i> Enviar a Revisión
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('aprobar novedades')): ?>
                <?php if($novedad->estado == 'revision'): ?>
                    <form action="<?php echo e(route('estacion-novedades.aprobar', $novedad)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de aprobar esta novedad?')">
                            <i class="fas fa-check"></i> Aprobar
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

           

            
            <a href="<?php echo e(route('estacion-novedades.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5>NOV-<?php echo e(str_pad($novedad->id, 6, '0', STR_PAD_LEFT)); ?></h5>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Fecha</th>
                        <td><?php echo e($novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha))); ?></td>
                    </tr>
                    <tr>
                        <th>Estación</th>
                        <td><?php echo e($novedad->estacion->nombre ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            <?php
                                $estados = [
                                    'elaboracion' => 'warning',
                                    'revision' => 'info',
                                    'aprobado' => 'success'
                                ];
                            ?>
                            <span class="badge badge-<?php echo e($estados[$novedad->estado] ?? 'secondary'); ?>">
                                <?php echo e(ucfirst($novedad->estado)); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Elaborado por</th>
                        <td><?php echo e($novedad->usuarioElabora->name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha Elaboración</th>
                        <td><?php echo e($novedad->fecha_elaboracion instanceof \Carbon\Carbon ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_elaboracion))); ?></td>
                    </tr>
                    <?php if($novedad->usuarioRevisa): ?>
                        <tr>
                            <th>Revisado por</th>
                            <td><?php echo e($novedad->usuarioRevisa->name); ?></td>
                        </tr>
                        <tr>
                            <th>Fecha Revisión</th>
                            <td><?php echo e($novedad->fecha_revision instanceof \Carbon\Carbon ? $novedad->fecha_revision->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_revision))); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if($novedad->usuarioAprueba): ?>
                        <tr>
                            <th>Aprobado por</th>
                            <td><?php echo e($novedad->usuarioAprueba->name); ?></td>
                        </tr>
                        <tr>
                            <th>Fecha Aprobación</th>
                            <td><?php echo e($novedad->fecha_aprobacion instanceof \Carbon\Carbon ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_aprobacion))); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-comment"></i> Observaciones Generales
                    </div>
                    <div class="card-body">
                        <?php echo e($novedad->observaciones ?? 'Sin observaciones'); ?>

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
                                        <?php if($novedad->estado == 'elaboracion'): ?>
                                            <span class="badge badge-warning">Actual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($novedad->usuarioElabora->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($novedad->fecha_elaboracion ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : 'N/A'); ?></td>
                                </tr>

                                <!-- Revisión -->
                                <tr>
                                    <td>
                                        <span class="badge badge-info">Revisión</span>
                                        <?php if($novedad->estado == 'revision'): ?>
                                            <span class="badge badge-warning">Actual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($novedad->usuarioRevisa->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($novedad->fecha_revision ? $novedad->fecha_revision->format('d/m/Y H:i') : 'N/A'); ?></td>
                                </tr>

                                <!-- Aprobación -->
                                <tr>
                                    <td>
                                        <span class="badge badge-success">Aprobado</span>
                                        <?php if($novedad->estado == 'aprobado'): ?>
                                            <span class="badge badge-warning">Actual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($novedad->usuarioAprueba->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($novedad->fecha_aprobacion ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : 'N/A'); ?></td>
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
                            <?php $__empty_1 = true; $__currentLoopData = $novedad->emergencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $emergencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e(ucfirst($emergencia->tipo_emergencia)); ?></td>
                                    <td><?php echo e($emergencia->lugar); ?></td>
                                    <td><?php echo e($emergencia->hora_ingreso); ?></td>
                                    <td><?php echo e($emergencia->hora_salida ?? '-'); ?></td>
                                    <td><?php echo e($emergencia->numero_afectados); ?></td>
                                    <td><?php echo e($emergencia->numero_vehiculos); ?></td>
                                    <td><?php echo e($emergencia->numero_bomberos); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay emergencias registradas</td>
                                </tr>
                            <?php endif; ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $novedad->vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($vehiculo->vehiculo->placa ?? 'N/A'); ?></td>
                                    <td><?php echo e(ucfirst($vehiculo->estado)); ?></td>
                                    <td><?php echo e($vehiculo->tipo_novedad); ?></td>
                                    <td><?php echo e($vehiculo->fecha_reporte instanceof \Carbon\Carbon ? $vehiculo->fecha_reporte->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_reporte))); ?></td>
                                    <td><?php echo e($vehiculo->fecha_solucion ? ($vehiculo->fecha_solucion instanceof \Carbon\Carbon ? $vehiculo->fecha_solucion->format('d/m/Y') : date('d/m/Y', strtotime($vehiculo->fecha_solucion))) : '-'); ?></td>
                                    <td><?php echo e($vehiculo->kilometraje ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay novedades de vehículos</td>
                                </tr>
                            <?php endif; ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $novedad->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($persona->user->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($persona->cargo); ?></td>
                                    <td><?php echo e(ucfirst($persona->turno)); ?></td>
                                    <td><?php echo e($persona->hora_entrada ?? '-'); ?></td>
                                    <td><?php echo e($persona->hora_salida ?? '-'); ?></td>
                                    <td>
                                        <?php
                                            $estadosPersonal = [
                                                'presente' => 'success',
                                                'ausente' => 'danger',
                                                'permiso' => 'warning',
                                                'licencia' => 'info',
                                                'comision' => 'primary'
                                            ];
                                        ?>
                                        <span class="badge badge-<?php echo e($estadosPersonal[$persona->estado] ?? 'secondary'); ?>">
                                            <?php echo e(ucfirst($persona->estado)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay personal registrado</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Integrantes de la Guardia -->
            <?php if($novedad->integrantes_guardia && count($novedad->integrantes_guardia) > 0): ?>
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
                                <?php $__currentLoopData = $novedad->integrantes_guardia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $integrante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($integrante['nombre'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($integrante['cedula'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($integrante['cargo'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($integrante['observaciones'] ?? 'N/A'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/estacion_novedades/show.blade.php ENDPATH**/ ?>