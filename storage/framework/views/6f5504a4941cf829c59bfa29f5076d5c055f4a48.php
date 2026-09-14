

<?php $__env->startSection('cuerpo'); ?>







<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-ambulance text-primary"></i>
        Emergencia Prehospitalaria — <?php echo e($emergenciaPrehospitalaria->codigo); ?>

    </h1>
    <div>
        <a href="#"
        
           class="btn btn-danger btn-sm shadow-sm" target="_blank">
            <i class="fas fa-file-pdf"></i> Generar PDF
        </a>
        <a href="<?php echo e(route('emergencias-prehospitalarias.edit', $emergenciaPrehospitalaria)); ?>"
           class="btn btn-warning btn-sm shadow-sm">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="<?php echo e(route('emergencias-prehospitalarias.index')); ?>"
           class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>


<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>


<div class="mb-3">
    <?php
        $estadoColor = [
            'En curso' => 'primary',
            'Finalizada' => 'success',
            'Cancelada' => 'danger',
            'Derivada' => 'warning',
        ][$emergenciaPrehospitalaria->estado] ?? 'secondary';

        $prioridadColor = [
            'Rojo' => 'danger',
            'Naranja' => 'warning',
            'Amarillo' => 'warning',
            'Verde' => 'success',
            'Azul' => 'primary',
        ][$emergenciaPrehospitalaria->prioridad] ?? 'secondary';
    ?>
    <span class="badge badge-<?php echo e($estadoColor); ?> p-2">
        <i class="fas fa-info-circle"></i> Estado: <?php echo e($emergenciaPrehospitalaria->estado); ?>

    </span>
    <span class="badge badge-<?php echo e($prioridadColor); ?> p-2">
        <i class="fas fa-exclamation-triangle"></i> Prioridad: <?php echo e($emergenciaPrehospitalaria->prioridad); ?>

    </span>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">1. Datos Generales</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <small class="text-muted">Fecha/Hora Salida</small>
                <p class="mb-1"><strong><?php echo e($emergenciaPrehospitalaria->fecha_salida->format('d/m/Y H:i')); ?></strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Llegada al Sitio</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Salida del Sitio</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->fecha_salida_sitio?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Llegada a Base</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->fecha_llegada_base?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">Dirección</small>
                <p class="mb-1"><strong><?php echo e($emergenciaPrehospitalaria->direccion); ?></strong></p>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Referencia</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->referencia ?? '—'); ?></p>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4">
                <small class="text-muted">Motivo del Llamado</small>
                <p class="mb-1"><strong><?php echo e($emergenciaPrehospitalaria->motivo_llamado); ?></strong></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Tipo de Emergencia</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->tipo_emergencia); ?></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Vehículo (Ambulancia)</small>
                <p class="mb-1">
                    <i class="fas fa-ambulance text-primary"></i>
                    <strong><?php echo e($emergenciaPrehospitalaria->vehiculo->placa ?? 'N/A'); ?></strong>
                    — <?php echo e($emergenciaPrehospitalaria->vehiculo->marca ?? ''); ?>

                </p>
            </div>
        </div>

        <?php if($emergenciaPrehospitalaria->observaciones_generales): ?>
            <hr>
            <div>
                <small class="text-muted">Observaciones Generales</small>
                <p class="mb-0"><?php echo e($emergenciaPrehospitalaria->observaciones_generales); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            2. Personal que Atendió
            <span class="badge badge-info"><?php echo e($emergenciaPrehospitalaria->personal->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaPrehospitalaria->personal->isEmpty()): ?>
            <p class="text-muted mb-0">No hay personal registrado.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol en la Emergencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $emergenciaPrehospitalaria->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><strong><?php echo e($persona->name); ?></strong></td>
                                <td><?php echo e($persona->email); ?></td>
                                <td><span class="badge badge-info"><?php echo e($persona->pivot->rol_en_emergencia); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            3. Pacientes Atendidos
            <span class="badge badge-warning"><?php echo e($emergenciaPrehospitalaria->pacientes->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaPrehospitalaria->pacientes->isEmpty()): ?>
            <p class="text-muted mb-0">No hay pacientes registrados.</p>
        <?php else: ?>
            <?php $__currentLoopData = $emergenciaPrehospitalaria->pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3 border-left-warning">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>Paciente #<?php echo e($i + 1); ?>: <?php echo e($paciente->nombre_completo); ?></strong>
                        <?php
                            $condColor = [
                                'Estable' => 'success',
                                'Crítico' => 'danger',
                                'Fallecido' => 'dark',
                                'Rechaza atención' => 'warning',
                            ][$paciente->condicion] ?? 'secondary';
                        ?>
                        <span class="badge badge-<?php echo e($condColor); ?>"><?php echo e($paciente->condicion); ?></span>
                    </div>
                    <div class="card-body">

                        
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <small class="text-muted">Edad</small>
                                <p class="mb-1"><strong><?php echo e($paciente->edad); ?> años</strong></p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Sexo</small>
                                <p class="mb-1">
                                    <?php if($paciente->sexo == 'M'): ?> Masculino
                                    <?php elseif($paciente->sexo == 'F'): ?> Femenino
                                    <?php else: ?> Indefinido
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Cédula</small>
                                <p class="mb-1"><?php echo e($paciente->cedula ?? '—'); ?></p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Teléfono</small>
                                <p class="mb-1"><?php echo e($paciente->telefono ?? '—'); ?></p>
                            </div>
                        </div>

                        
                        <h6 class="text-primary border-bottom pb-1 mb-3">
                            <i class="fas fa-heartbeat"></i> Signos Vitales
                        </h6>
                        <div class="row text-center mb-3">
                            <div class="col-md-2 col-6 mb-2">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted d-block">FC</small>
                                    <strong class="h5"><?php echo e($paciente->frecuencia_cardiaca ?? '—'); ?></strong>
                                    <small class="d-block text-muted">lpm</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted d-block">FR</small>
                                    <strong class="h5"><?php echo e($paciente->frecuencia_respiratoria ?? '—'); ?></strong>
                                    <small class="d-block text-muted">rpm</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted d-block">SatO₂</small>
                                    <strong class="h5"><?php echo e($paciente->saturacion_oxigeno ?? '—'); ?></strong>
                                    <small class="d-block text-muted">%</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted d-block">Temp</small>
                                    <strong class="h5"><?php echo e($paciente->temperatura ?? '—'); ?></strong>
                                    <small class="d-block text-muted">°C</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted d-block">TA</small>
                                    <strong class="h5">
                                        <?php echo e($paciente->presion_sistolica ?? '—'); ?>/<?php echo e($paciente->presion_diastolica ?? '—'); ?>

                                    </strong>
                                    <small class="d-block text-muted">mmHg</small>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted d-block">Glasgow</small>
                                    <strong class="h5"><?php echo e($paciente->glasgow ?? '—'); ?></strong>
                                    <small class="d-block text-muted">/15</small>
                                </div>
                            </div>
                        </div>

                        
                        <h6 class="text-primary border-bottom pb-1 mb-2">
                            <i class="fas fa-notes-medical"></i> Evaluación y Procedimientos
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">Motivo de Atención</small>
                                <p class="mb-1"><?php echo e($paciente->motivo_atencion ?? '—'); ?></p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">Evaluación</small>
                                <p class="mb-1"><?php echo e($paciente->evaluacion ?? '—'); ?></p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">Procedimientos Realizados</small>
                                <p class="mb-1"><?php echo e($paciente->procedimientos_realizados ?? '—'); ?></p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">Observaciones</small>
                                <p class="mb-1"><?php echo e($paciente->observaciones ?? '—'); ?></p>
                            </div>
                        </div>

                        
                        <h6 class="text-primary border-bottom pb-1 mb-2">
                            <i class="fas fa-hospital"></i> Destino
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Destino</small>
                                <p class="mb-1"><strong><?php echo e($paciente->destino ?? '—'); ?></strong></p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Hospital de Destino</small>
                                <p class="mb-1"><?php echo e($paciente->hospital_destino ?? '—'); ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            4. Insumos Utilizados
            <span class="badge badge-secondary"><?php echo e($emergenciaPrehospitalaria->insumos->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaPrehospitalaria->insumos->isEmpty()): ?>
            <p class="text-muted mb-0">No se registraron insumos.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Insumo</th>
                            <th class="text-center">Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $emergenciaPrehospitalaria->insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $insumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><strong><?php echo e($insumo->descripcion); ?></strong></td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo e($insumo->pivot->cantidad); ?></span>
                                </td>
                                <td><?php echo e($insumo->pivot->observaciones ?? '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">5. Información de Registro</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <small class="text-muted">Registrado por</small>
                <p class="mb-1"><strong><?php echo e($emergenciaPrehospitalaria->usuarioRegistra->name ?? 'N/A'); ?></strong></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Fecha de Registro</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->created_at->format('d/m/Y H:i')); ?></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Última Actualización</small>
                <p class="mb-1"><?php echo e($emergenciaPrehospitalaria->updated_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
    </div>
</div>


<div class="text-center mb-5">
    <a href="<?php echo e(route('emergencias-prehospitalarias.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
    <a href="#"
       class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf"></i> PDF Parte de Ambulancia
    </a>
    <a href="<?php echo e(route('emergencias-prehospitalarias.edit', $emergenciaPrehospitalaria)); ?>"
       class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <form action="<?php echo e(route('emergencias-prehospitalarias.destroy', $emergenciaPrehospitalaria)); ?>"
          method="POST" class="d-inline"
          onsubmit="return confirm('¿Está seguro de eliminar esta emergencia? Se restaurará el stock de insumos.')">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Eliminar
        </button>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_prehospitalarias/show.blade.php ENDPATH**/ ?>