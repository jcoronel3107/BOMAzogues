

<?php $__env->startSection('cuerpo'); ?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-ambulance text-primary"></i>
        Emergencia Prehospitalaria — <?php echo e($emergenciaPrehospitalaria->codigo); ?>

    </h1>
    <div>
        <a href="<?php echo e(route('emergencias-prehospitalarias.pdf', $emergenciaPrehospitalaria)); ?>"
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

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

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
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-paperclip"></i> Archivos Adjuntos
            <span class="badge badge-info"><?php echo e($emergenciaPrehospitalaria->archivos->count()); ?></span>
        </h6>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSubirArchivos"
                <?php echo e($emergenciaPrehospitalaria->porcentaje_uso >= 100 ? 'disabled' : ''); ?>>
            <i class="fas fa-upload"></i> Subir Archivos
        </button>
    </div>

    
    <div class="card-body py-2 border-bottom bg-light">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="font-weight-bold">
                <i class="fas fa-hdd"></i> Espacio usado:
                <strong><?php echo e($emergenciaPrehospitalaria->espacio_usado_mb); ?> MB</strong>
                de <strong><?php echo e($emergenciaPrehospitalaria->limite_mb); ?> MB</strong>
            </small>
            <small class="text-<?php echo e($emergenciaPrehospitalaria->color_barra); ?>">
                <strong><?php echo e($emergenciaPrehospitalaria->porcentaje_uso); ?>%</strong>
            </small>
        </div>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-<?php echo e($emergenciaPrehospitalaria->color_barra); ?>"
                 role="progressbar"
                 style="width: <?php echo e($emergenciaPrehospitalaria->porcentaje_uso); ?>%"
                 aria-valuenow="<?php echo e($emergenciaPrehospitalaria->porcentaje_uso); ?>"
                 aria-valuemin="0"
                 aria-valuemax="100">
            </div>
        </div>
        <?php if($emergenciaPrehospitalaria->porcentaje_uso >= 90): ?>
            <small class="text-<?php echo e($emergenciaPrehospitalaria->color_barra); ?> d-block mt-1">
                <i class="fas fa-exclamation-triangle"></i>
                <?php if($emergenciaPrehospitalaria->porcentaje_uso >= 100): ?>
                    Límite alcanzado. Elimina archivos para subir más.
                <?php else: ?>
                    Queda poco espacio disponible (<?php echo e($emergenciaPrehospitalaria->espacio_disponible_mb); ?> MB).
                <?php endif; ?>
            </small>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <?php if($emergenciaPrehospitalaria->archivos->isEmpty()): ?>
            <p class="text-muted mb-0 text-center">
                <i class="fas fa-folder-open fa-2x d-block mb-2 text-gray-300"></i>
                No hay archivos adjuntos.
            </p>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $emergenciaPrehospitalaria->archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card h-100 shadow-sm">
                            
                            <?php if($archivo->es_imagen): ?>
                                <img src="<?php echo e(asset('storage/' . $archivo->ruta)); ?>"
                                     class="card-img-top"
                                     style="height: 120px; object-fit: cover; cursor: pointer;"
                                     data-toggle="modal"
                                     data-target="#modalPreviewImagen"
                                     data-img="<?php echo e(asset('storage/' . $archivo->ruta)); ?>"
                                     data-titulo="<?php echo e($archivo->nombre_original); ?>">
                            <?php else: ?>
                                <div class="text-center py-4 bg-light">
                                    <i class="fas <?php echo e($archivo->icono); ?> fa-3x text-secondary"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body p-2">
                                <small class="d-block text-truncate" title="<?php echo e($archivo->nombre_original); ?>">
                                    <strong><?php echo e($archivo->nombre_original); ?></strong>
                                </small>
                                <small class="text-muted d-block">
                                    <?php echo e($archivo->tamano_legible); ?>

                                    · <?php echo e($archivo->created_at->format('d/m/Y H:i')); ?>

                                </small>
                                <?php if($archivo->usuario): ?>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-user"></i> <?php echo e($archivo->usuario->name); ?>

                                    </small>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer p-1 d-flex justify-content-between">
                                <a href="<?php echo e(route('emergencias-prehospitalarias.archivos.descargar', $archivo)); ?>"
                                   class="btn btn-info btn-sm" title="Descargar">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="<?php echo e(route('emergencias-prehospitalarias.archivos.eliminar', $archivo)); ?>"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este archivo?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">6. Información de Registro</h6>
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
    <a href="<?php echo e(route('emergencias-prehospitalarias.pdf', $emergenciaPrehospitalaria)); ?>"
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


<div class="modal fade" id="modalSubirArchivos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('emergencias-prehospitalarias.archivos.subir', $emergenciaPrehospitalaria)); ?>"
                  method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-upload"></i> Subir Archivos
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info py-2">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Espacio disponible:
                            <strong><?php echo e($emergenciaPrehospitalaria->espacio_disponible_mb); ?> MB</strong>
                            de <?php echo e($emergenciaPrehospitalaria->limite_mb); ?> MB
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">
                            Seleccione archivos <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="archivos[]" class="form-control-file"
                               multiple required accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.mp4,.mp3,.zip,.rar">
                        <small class="text-muted d-block mt-2">
                            Máximo <?php echo e(config('filesystems.emergencias_archivos.max_archivo_mb', 10)); ?>MB por archivo.
                            Permitidos: imágenes, PDF, Word, Excel, video, audio, ZIP.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Subir
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalPreviewImagen" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloPreview">Vista previa</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img id="imagenPreview" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalPreview = document.getElementById('modalPreviewImagen');
    if (modalPreview) {
        modalPreview.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            document.getElementById('imagenPreview').src = trigger.getAttribute('data-img');
            document.getElementById('tituloPreview').textContent = trigger.getAttribute('data-titulo');
        });
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_prehospitalarias/show.blade.php ENDPATH**/ ?>