

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Lista de Insumos Médicos</h6>
        <div>
            <a href="<?php echo e(route('insumos-medicos.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Insumo
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

        <!-- Alertas de stock bajo -->
        <?php
            $stockBajo = $insumos->filter(function($item) {
                return $item->estaBajoStock() && $item->estado != 'vencido';
            });
        ?>
        <?php if($stockBajo->count() > 0): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Atención!</strong> Hay <strong><?php echo e($stockBajo->count()); ?></strong> insumo(s) con stock bajo.
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
                        <th>Descripción</th>
                        <th>Caso de Uso</th>
                        <th>Cantidad</th>
                        <th>Mínimo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($insumo->codigo); ?></strong></td>
                        <td><?php echo e($insumo->descripcion); ?></td>
                        <td><?php echo e($insumo->caso_uso); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($insumo->estaBajoStock() ? 'warning' : ($insumo->estaAgotado() ? 'danger' : 'success')); ?>">
                                <?php echo e($insumo->cantidad); ?>

                            </span>
                        </td>
                        <td><?php echo e($insumo->cantidad_minima); ?></td>
                        <td>
                            <?php
                                $estados = [
                                    'disponible' => 'success',
                                    'agotado' => 'danger',
                                    'vencido' => 'warning'
                                ];
                            ?>
                            <span class="badge badge-<?php echo e($estados[$insumo->estado] ?? 'secondary'); ?>">
                                <?php echo e(ucfirst($insumo->estado ?? 'Sin estado')); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('insumos-medicos.show', $insumo)); ?>" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('insumos-medicos.edit', $insumo)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-success btn-sm" title="Ajustar Stock" data-toggle="modal" data-target="#modalStock<?php echo e($insumo->id); ?>">
                                    <i class="fas fa-boxes"></i>
                                </button>
                                <form action="<?php echo e(route('insumos-medicos.destroy', $insumo)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este insumo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Ajustar Stock -->
                    <div class="modal fade" id="modalStock<?php echo e($insumo->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="<?php echo e(route('insumos-medicos.ajustar-stock', $insumo)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajustar Stock - <?php echo e($insumo->codigo); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Stock Actual: <strong><?php echo e($insumo->cantidad); ?></strong></label>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo de Movimiento <span class="text-danger">*</span></label>
                                            <select name="tipo" class="form-control" required>
                                                <option value="entrada">Entrada (Aumentar Stock)</option>
                                                <option value="salida">Salida (Disminuir Stock)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Cantidad <span class="text-danger">*</span></label>
                                            <input type="number" name="cantidad" class="form-control" min="1" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Motivo</label>
                                            <input type="text" name="motivo" class="form-control" placeholder="Ej: Compra, Uso en emergencia, etc.">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay insumos médicos registrados</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($insumos->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/insumos_medicos/index.blade.php ENDPATH**/ ?>