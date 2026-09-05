

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detalle de Emergencia</h6>
        <div>
            <a href="<?php echo e(route('emergencias.edit', $emergencia)); ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="<?php echo e(route('emergencias.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card-body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                    <i class="fas fa-info-circle"></i> Información Emergencia
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">
                    <i class="fas fa-users"></i> Personal en Emergencia
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="vehiculos-tab" data-toggle="tab" href="#vehiculos" role="tab" aria-controls="vehiculos" aria-selected="false">
                    <i class="fas fa-truck"></i> Vehículos
                </a>
            </li>
        </ul>

        <div class="tab-content mt-4" id="myTabContent">

            <!-- Pestaña 1: Información Emergencia -->
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td><?php echo e($emergencia->id); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td><?php echo e($emergencia->fecha->format('d/m/Y')); ?></td>
                    </tr>
                    <tr>
                        <th>Información Inicial</th>
                        <td><?php echo e($emergencia->informacion_inicial); ?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Incidente</th>
                        <td><?php echo e($emergencia->tipoIncidente->nombre_incidente ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Subcategoría</th>
                        <td><?php echo e($emergencia->subcategoria ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Estación</th>
                        <td><?php echo e($emergencia->estacion->nombre ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Hora Salida a Emergencia</th>
                        <td><?php echo e($emergencia->hora_salida_emergencia); ?></td>
                    </tr>
                    <tr>
                        <th>Hora Llegada a Emergencia</th>
                        <td><?php echo e($emergencia->hora_llegada_emergencia); ?></td>
                    </tr>
                    <tr>
                        <th>Hora en Base</th>
                        <td><?php echo e($emergencia->hora_en_base); ?></td>
                    </tr>
                    <tr>
                        <th>Detalle de la Emergencia</th>
                        <td><?php echo e($emergencia->detalle_emergencia); ?></td>
                    </tr>
                    <tr>
                        <th>Ciudadano Afectado</th>
                        <td><?php echo e($emergencia->ciudadano_afectado ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Daños Estimados</th>
                        <td><?php echo e($emergencia->danos_estimados ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Creado por</th>
                        <td><?php echo e($emergencia->usr_creador ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Creación</th>
                        <td><?php echo e($emergencia->created_at->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <?php if($emergencia->usr_editor): ?>
                    <tr>
                        <th>Última Edición por</th>
                        <td><?php echo e($emergencia->usr_editor); ?></td>
                    </tr>
                    <tr>
                        <th>Última Actualización</th>
                        <td><?php echo e($emergencia->updated_at->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Pestaña 2: Personal en Emergencia -->
            <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                <?php if($emergencia->usuarios->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $emergencia->usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($usuario->name); ?></td>
                                        <td><?php echo e($usuario->cargo ?? 'Bombero'); ?></td>
                                        <td><?php echo e($usuario->email); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay personal registrado en esta emergencia.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pestaña 3: Vehículos -->
            <div class="tab-pane fade" id="vehiculos" role="tabpanel" aria-labelledby="vehiculos-tab">
                <?php if($emergencia->vehiculos->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vehículo</th>
                                    <th>Conductor</th>
                                    <th>KM Salida</th>
                                    <th>KM Retorno</th>
                                    <th>KM Recorridos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $emergencia->vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($vehiculo->placa); ?> - <?php echo e($vehiculo->marca); ?> <?php echo e($vehiculo->modelo); ?></td>
                                        <td><?php echo e($vehiculo->pivot->conductor_id ? App\User::find($vehiculo->pivot->conductor_id)->name ?? 'N/A' : 'N/A'); ?></td>
                                        <td><?php echo e($vehiculo->pivot->km_salida ?? 'N/A'); ?></td>
                                        <td><?php echo e($vehiculo->pivot->km_retorno ?? 'N/A'); ?></td>
                                        <td>
                                            <?php if($vehiculo->pivot->km_salida && $vehiculo->pivot->km_retorno): ?>
                                                <?php echo e($vehiculo->pivot->km_retorno - $vehiculo->pivot->km_salida); ?> KM
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay vehículos registrados en esta emergencia.
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/emergencias/show.blade.php ENDPATH**/ ?>