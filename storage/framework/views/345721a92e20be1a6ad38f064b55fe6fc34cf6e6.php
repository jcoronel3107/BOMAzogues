

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Movilizaciones de Unidades</h6>
        <a href="<?php echo e(route('movilizaciones.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nueva Movilización
        </a>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha Salida</th>
                <th>Hora Salida</th>
                <th>Fecha Retorno</th>
                <th>Motivo</th>
                <th>Destino</th>
                <th>Conductor</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $movilizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movilizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>MOV-<?php echo e(str_pad($movilizacion->id, 6, '0', STR_PAD_LEFT)); ?></td>
                <td><?php echo e($movilizacion->fecha_salida ? \Carbon\Carbon::parse($movilizacion->fecha_salida)->format('d/m/Y') : 'N/A'); ?></td>
                <td><?php echo e($movilizacion->hora_salida ?? 'N/A'); ?></td>
                <td><?php echo e($movilizacion->fecha_retorno ? \Carbon\Carbon::parse($movilizacion->fecha_retorno)->format('d/m/Y') : 'N/A'); ?></td>
                <td><?php echo e($movilizacion->motivo ?? 'N/A'); ?></td>
                <td><?php echo e($movilizacion->destino ?? 'N/A'); ?></td>
                <td><?php echo e($movilizacion->conductor_nombres ?? 'N/A'); ?></td>
                <td><?php echo e($movilizacion->vehiculo_placa ?? 'N/A'); ?> - <?php echo e($movilizacion->vehiculo_marca ?? 'N/A'); ?></td>
                <td>
                    <?php
                        $estados = [
                            'pendiente' => 'warning',
                            'aprobado' => 'success',
                            'rechazado' => 'danger',
                            'finalizado' => 'info'
                        ];
                    ?>
                    <span class="badge badge-<?php echo e($estados[$movilizacion->estado] ?? 'secondary'); ?>">
                        <?php echo e(ucfirst($movilizacion->estado)); ?>

                    </span>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(route('movilizaciones.show', $movilizacion)); ?>" class="btn btn-info btn-sm" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if($movilizacion->puedeEditar()): ?>
                            <a href="<?php echo e(route('movilizaciones.edit', $movilizacion)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('movilizaciones.destroy', $movilizacion)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta movilización?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if($movilizacion->estado == 'pendiente'): ?>
                            <form action="<?php echo e(route('movilizaciones.autorizar', $movilizacion)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success btn-sm" title="Autorizar" onclick="return confirm('¿Autorizar esta movilización?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="<?php echo e(route('movilizaciones.rechazar', $movilizacion)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="observaciones" value="Movilización rechazada">
                                <button type="submit" class="btn btn-danger btn-sm" title="Rechazar" onclick="return confirm('¿Rechazar esta movilización?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if($movilizacion->estado == 'aprobado'): ?>
                            <button type="button" class="btn btn-primary btn-sm" title="Finalizar" data-toggle="modal" data-target="#modalFinalizar<?php echo e($movilizacion->id); ?>">
                                <i class="fas fa-flag-checkered"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
        <?php echo e($movilizaciones->links()); ?>

    </div>
</div>

<!-- Modales para finalizar -->
<?php $__currentLoopData = $movilizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movilizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($movilizacion->estado == 'aprobado'): ?>
<div class="modal fade" id="modalFinalizar<?php echo e($movilizacion->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modalFinalizarLabel<?php echo e($movilizacion->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('movilizaciones.finalizar', $movilizacion)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Finalizar Movilización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Hora de Llegada <span class="text-danger">*</span></label>
                        <input type="time" name="hora_llegada" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kilometraje de Llegada <span class="text-danger">*</span></label>
                        <input type="number" name="vehiculo_km_llegada" class="form-control" placeholder="KM" required min="0">
                        <small class="text-muted">KM de salida: <?php echo e($movilizacion->vehiculo_km_salida); ?></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/movilizaciones/index.blade.php ENDPATH**/ ?>