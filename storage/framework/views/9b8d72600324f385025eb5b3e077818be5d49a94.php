

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Novedades de Estación</h6>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear novedades')): ?>
            <a href="<?php echo e(route('estacion-novedades.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Novedad
            </a>
        <?php endif; ?>
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
                        <th>Fecha</th>
                        <th>Estación</th>
                        <th>Elaborado por</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $novedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $novedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>NOV-<?php echo e(str_pad($novedad->id, 6, '0', STR_PAD_LEFT)); ?></td>
                        <td><?php echo e($novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha))); ?></td>
                        <td><?php echo e($novedad->estacion->nombre ?? 'N/A'); ?></td>
                        <td><?php echo e($novedad->usuarioElabora->name ?? 'N/A'); ?></td>
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
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('estacion-novedades.show', $novedad)); ?>" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('estacion-novedades.pdf', $novedad)); ?>" class="btn btn-danger btn-sm" title="Exportar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="<?php echo e(route('estacion-novedades.enviar-correo', $novedad)); ?>" class="btn btn-info btn-sm" title="Enviar Correo">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar novedades')): ?>
                                    <?php if($novedad->puedeEditar()): ?>
                                        <a href="<?php echo e(route('estacion-novedades.edit', $novedad)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('estacion-novedades.destroy', $novedad)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta novedad?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('revisar novedades')): ?>
                                    <?php if($novedad->estado == 'elaboracion'): ?>
                                        <form action="<?php echo e(route('estacion-novedades.enviar-revision', $novedad)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary btn-sm" title="Enviar a Revisión">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('aprobar novedades')): ?>
                                    <?php if($novedad->estado == 'revision'): ?>
                                        <form action="<?php echo e(route('estacion-novedades.aprobar', $novedad)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm" title="Aprobar" onclick="return confirm('¿Estás seguro de aprobar esta novedad?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php echo e($novedades->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/estacion_novedades/index.blade.php ENDPATH**/ ?>