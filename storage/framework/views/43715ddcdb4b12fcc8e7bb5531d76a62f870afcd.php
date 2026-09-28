

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Lista de Emergencias</h6>
        <div>
            <a href="<?php echo e(route('emergencias.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Emergencia
            </a>
        </div>
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
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Incidente</th>
                        <th>Estación</th>
                        <th>Parroquia</th>
                        <th>Personal</th>
                        <th>Vehículos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
                        <td><?php echo e($emergencia->usuarios->count()); ?></td>
                        <td><?php echo e($emergencia->vehiculos->count()); ?></td>
                        <td>
                            <?php
                                $estados = [
                                    'activo' => 'success',
                                    'finalizado' => 'secondary'
                                ];
                            ?>
                            <span class="badge badge-<?php echo e($estados[$emergencia->estado] ?? 'success'); ?>">
                                <?php echo e(ucfirst($emergencia->estado ?? 'Activo')); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('emergencias.show', $emergencia)); ?>" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('emergencias.edit', $emergencia)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <?php if($emergencia->estado == 'activo' || !$emergencia->estado): ?>
                                    <form action="<?php echo e(route('emergencias.finalizar', $emergencia)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-sm" title="Finalizar" onclick="return confirm('¿Estás seguro de finalizar esta emergencia?')">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <form action="<?php echo e(route('emergencias.destroy', $emergencia)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta emergencia?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center">No hay emergencias registradas</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($emergencias->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias/index.blade.php ENDPATH**/ ?>