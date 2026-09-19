

<?php $__env->startSection('cuerpo'); ?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fire text-danger"></i>
        Emergencia de Fuego — <?php echo e($emergenciaFuego->codigo); ?>

    </h1>
    <div>
        <a href="<?php echo e(route('emergencias-fuego.pdf', $emergenciaFuego)); ?>"
           class="btn btn-danger btn-sm shadow-sm" target="_blank">
            <i class="fas fa-file-pdf"></i> Generar PDF
        </a>
        <a href="<?php echo e(route('emergencias-fuego.edit', $emergenciaFuego)); ?>"
           class="btn btn-warning btn-sm shadow-sm">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="<?php echo e(route('emergencias-fuego.index')); ?>"
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
    <span class="badge badge-<?php echo e($emergenciaFuego->estado_color); ?> p-2">
        <i class="fas fa-info-circle"></i> Estado: <?php echo e($emergenciaFuego->estado); ?>

    </span>
    <span class="badge badge-<?php echo e($emergenciaFuego->color_prioridad); ?> p-2">
        <i class="fas fa-exclamation-triangle"></i> Riesgo: <?php echo e($emergenciaFuego->nivel_riesgo); ?>

    </span>
    <span class="badge badge-secondary p-2">
        <i class="fas fa-fire"></i> Tipo: <?php echo e($emergenciaFuego->tipo_fuego); ?>

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
                <p class="mb-1"><strong><?php echo e($emergenciaFuego->fecha_salida->format('d/m/Y H:i')); ?></strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Llegada al Sitio</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Control del Fuego</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->fecha_control?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Extinción Total</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->fecha_extincion?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">Dirección</small>
                <p class="mb-1"><strong><?php echo e($emergenciaFuego->direccion); ?></strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Referencia</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->referencia ?? '—'); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Parroquia / Sector</small>
                <p class="mb-1">
                    <?php echo e($emergenciaFuego->parroquia->nombre ?? '—'); ?> / <?php echo e($emergenciaFuego->sector ?? '—'); ?>

                </p>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <small class="text-muted">Motivo del Llamado</small>
                <p class="mb-1"><strong><?php echo e($emergenciaFuego->motivo_llamado); ?></strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Tipo de Fuego</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->tipo_fuego); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Causa Probable</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->causa_probable ?? '—'); ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Llegada a Base</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->fecha_llegada_base?->format('d/m/Y H:i') ?? '—'); ?></p>
            </div>
        </div>

        <?php if($emergenciaFuego->observaciones_generales): ?>
            <hr>
            <div>
                <small class="text-muted">Observaciones Generales</small>
                <p class="mb-0"><?php echo e($emergenciaFuego->observaciones_generales); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">2. Magnitud y Recursos Utilizados</h6>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Área afectada</small>
                    <strong class="h5"><?php echo e($emergenciaFuego->area_afectada_m2 ?? '—'); ?></strong>
                    <small class="d-block text-muted">m²</small>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Pérdidas estimadas</small>
                    <strong class="h5"><?php echo e($emergenciaFuego->perdidas_estimadas ?? '—'); ?></strong>
                    <small class="d-block text-muted"><?php echo e($emergenciaFuego->moneda); ?></small>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Agua utilizada</small>
                    <strong class="h5"><?php echo e($emergenciaFuego->agua_utilizada_litros ?? '—'); ?></strong>
                    <small class="d-block text-muted">litros</small>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Espuma utilizada</small>
                    <strong class="h5"><?php echo e($emergenciaFuego->espuma_utilizada_litros ?? '—'); ?></strong>
                    <small class="d-block text-muted">litros</small>
                </div>
            </div>
        </div>

        <hr>

        <h6 class="text-primary">Víctimas</h6>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Ilesos</small>
                    <strong class="h4 text-success"><?php echo e($emergenciaFuego->victimas_ilesos); ?></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Heridos</small>
                    <strong class="h4 text-warning"><?php echo e($emergenciaFuego->victimas_heridos); ?></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Fallecidos</small>
                    <strong class="h4 text-danger"><?php echo e($emergenciaFuego->victimas_fallecidos); ?></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Apoyo externo</small>
                    <strong class="h5"><?php echo e($emergenciaFuego->requirio_apoyo_externo ? 'Sí' : 'No'); ?></strong>
                    <?php if($emergenciaFuego->detalle_apoyo): ?>
                        <small class="d-block text-muted"><?php echo e($emergenciaFuego->detalle_apoyo); ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            3. Vehículos Utilizados
            <span class="badge badge-info"><?php echo e($emergenciaFuego->vehiculos->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaFuego->vehiculos->isEmpty()): ?>
            <p class="text-muted mb-0">No hay vehículos registrados.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Placa</th>
                            <th>Marca / Modelo</th>
                            <th>Rol</th>
                            <th>Km Salida</th>
                            <th>Km Llegada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $emergenciaFuego->vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><strong><?php echo e($v->placa); ?></strong></td>
                                <td><?php echo e($v->marca ?? ''); ?> <?php echo e($v->modelo ?? ''); ?></td>
                                <td><span class="badge badge-info"><?php echo e($v->pivot->rol_en_emergencia ?? '—'); ?></span></td>
                                <td><?php echo e($v->pivot->km_salida ?? '—'); ?></td>
                                <td><?php echo e($v->pivot->km_llegada ?? '—'); ?></td>
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
            4. Personal que Atendió
            <span class="badge badge-info"><?php echo e($emergenciaFuego->personal->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaFuego->personal->isEmpty()): ?>
            <p class="text-muted mb-0">No hay personal registrado.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $emergenciaFuego->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><strong><?php echo e($p->name); ?></strong></td>
                                <td><?php echo e($p->email); ?></td>
                                <td><span class="badge badge-info"><?php echo e($p->pivot->rol_en_emergencia); ?></span></td>
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
            5. Pacientes / Víctimas
            <span class="badge badge-warning"><?php echo e($emergenciaFuego->pacientes->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaFuego->pacientes->isEmpty()): ?>
            <p class="text-muted mb-0">No hay pacientes registrados.</p>
        <?php else: ?>
            <?php $__currentLoopData = $emergenciaFuego->pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3 border-left-warning">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>Paciente #<?php echo e($i + 1); ?>: <?php echo e($pac->nombre_completo); ?></strong>
                        <span class="badge badge-<?php echo e($pac->condicion_color); ?>"><?php echo e($pac->condicion); ?></span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <small class="text-muted">Edad</small>
                                <p class="mb-1"><strong><?php echo e($pac->edad ?? '—'); ?> años</strong></p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Sexo</small>
                                <p class="mb-1"><?php echo e($pac->sexo); ?></p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Cédula</small>
                                <p class="mb-1"><?php echo e($pac->cedula ?? '—'); ?></p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Teléfono</small>
                                <p class="mb-1"><?php echo e($pac->telefono ?? '—'); ?></p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Tipo lesión</small>
                                <p class="mb-1"><?php echo e($pac->tipo_lesion ?? '—'); ?></p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Hospital</small>
                                <p class="mb-1"><?php echo e($pac->hospital_destino ?? '—'); ?></p>
                            </div>
                        </div>
                        <?php if($pac->frecuencia_cardiaca || $pac->frecuencia_respiratoria || $pac->saturacion_oxigeno || $pac->temperatura): ?>
                            <hr>
                            <div class="row">
                                <div class="col-md-2"><small class="text-muted d-block">FC</small><strong><?php echo e($pac->frecuencia_cardiaca ?? '—'); ?></strong></div>
                                <div class="col-md-2"><small class="text-muted d-block">FR</small><strong><?php echo e($pac->frecuencia_respiratoria ?? '—'); ?></strong></div>
                                <div class="col-md-2"><small class="text-muted d-block">SatO₂</small><strong><?php echo e($pac->saturacion_oxigeno ?? '—'); ?></strong></div>
                                <div class="col-md-2"><small class="text-muted d-block">Temp</small><strong><?php echo e($pac->temperatura ?? '—'); ?></strong></div>
                            </div>
                        <?php endif; ?>
                        <?php if($pac->observaciones): ?>
                            <hr>
                            <small class="text-muted">Observaciones</small>
                            <p class="mb-0"><?php echo e($pac->observaciones); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-tools"></i> Herramientas Utilizadas
            <span class="badge badge-info"><?php echo e($emergenciaFuego->herramientas->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaFuego->herramientas->isEmpty()): ?>
            <p class="text-muted mb-0">No se registraron herramientas.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Herramienta</th>
                            <th>Código</th>
                            <th>Marca</th>
                            <th class="text-center">Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $emergenciaFuego->herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $herr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><strong><?php echo e($herr->descripcion); ?></strong></td>
                                <td><?php echo e($herr->codigo ?? '—'); ?></td>
                                <td><?php echo e($herr->marca ?? '—'); ?></td>
                                <td class="text-center">
                                    <span class="badge badge-primary"><?php echo e($herr->pivot->cantidad); ?></span>
                                </td>
                                <td><?php echo e($herr->pivot->observaciones ?? '—'); ?></td>
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
            7. Insumos Utilizados
            <span class="badge badge-secondary"><?php echo e($emergenciaFuego->insumos->count()); ?></span>
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergenciaFuego->insumos->isEmpty()): ?>
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
                        <?php $__currentLoopData = $emergenciaFuego->insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i + 1); ?></td>
                                <td><strong><?php echo e($ins->descripcion); ?></strong></td>
                                <td class="text-center"><span class="badge badge-primary"><?php echo e($ins->pivot->cantidad); ?></span></td>
                                <td><?php echo e($ins->pivot->observaciones ?? '—'); ?></td>
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
            <span class="badge badge-info"><?php echo e($emergenciaFuego->archivos->count()); ?></span>
        </h6>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSubirArchivos"
                <?php echo e($emergenciaFuego->porcentaje_uso >= 100 ? 'disabled' : ''); ?>>
            <i class="fas fa-upload"></i> Subir Archivos
        </button>
    </div>

    <div class="card-body py-2 border-bottom bg-light">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="font-weight-bold">
                <i class="fas fa-hdd"></i> Espacio usado:
                <strong><?php echo e($emergenciaFuego->espacio_usado_mb); ?> MB</strong>
                de <strong><?php echo e($emergenciaFuego->limite_mb); ?> MB</strong>
            </small>
            <small class="text-<?php echo e($emergenciaFuego->color_barra); ?>">
                <strong><?php echo e($emergenciaFuego->porcentaje_uso); ?>%</strong>
            </small>
        </div>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-<?php echo e($emergenciaFuego->color_barra); ?>"
                 style="width: <?php echo e($emergenciaFuego->porcentaje_uso); ?>%"></div>
        </div>
    </div>

    <div class="card-body">
        <?php if($emergenciaFuego->archivos->isEmpty()): ?>
            <p class="text-muted mb-0 text-center">
                <i class="fas fa-folder-open fa-2x d-block mb-2 text-gray-300"></i>
                No hay archivos adjuntos.
            </p>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $emergenciaFuego->archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card h-100 shadow-sm">
                            <?php if($archivo->es_imagen): ?>
                                <img src="<?php echo e(asset('storage/' . $archivo->ruta)); ?>" class="card-img-top"
                                     style="height: 120px; object-fit: cover; cursor: pointer;"
                                     data-toggle="modal" data-target="#modalPreviewImagen"
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
                                <small class="text-muted d-block"><?php echo e($archivo->tamano_legible); ?></small>
                            </div>
                            <div class="card-footer p-1 d-flex justify-content-between">
                                <a href="<?php echo e(route('emergencias-fuego.archivos.descargar', $archivo)); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="<?php echo e(route('emergencias-fuego.archivos.eliminar', $archivo)); ?>"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este archivo?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
        <h6 class="m-0 font-weight-bold text-primary">Información de Registro</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <small class="text-muted">Registrado por</small>
                <p class="mb-1"><strong><?php echo e($emergenciaFuego->usuarioRegistra->name ?? 'N/A'); ?></strong></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Fecha de Registro</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->created_at->format('d/m/Y H:i')); ?></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Última Actualización</small>
                <p class="mb-1"><?php echo e($emergenciaFuego->updated_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
    </div>
</div>


<div class="text-center mb-5">
    <a href="<?php echo e(route('emergencias-fuego.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
    <a href="<?php echo e(route('emergencias-fuego.pdf', $emergenciaFuego)); ?>" class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf"></i> PDF Parte de Bomberos
    </a>
    <a href="<?php echo e(route('emergencias-fuego.edit', $emergenciaFuego)); ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <form action="<?php echo e(route('emergencias-fuego.destroy', $emergenciaFuego)); ?>" method="POST" class="d-inline"
          onsubmit="return confirm('¿Eliminar esta emergencia? Se restaurará el stock de insumos.')">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
    </form>
</div>


<div class="modal fade" id="modalSubirArchivos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('emergencias-fuego.archivos.subir', $emergenciaFuego)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-upload"></i> Subir Archivos</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info py-2">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Disponible: <strong><?php echo e($emergenciaFuego->espacio_disponible_mb); ?> MB</strong>
                            de <?php echo e($emergenciaFuego->limite_mb); ?> MB
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Seleccione archivos <span class="text-danger">*</span></label>
                        <input type="file" name="archivos[]" class="form-control-file" multiple required
                               accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.mp4,.mp3,.zip,.rar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Subir</button>
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
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_fuego/show.blade.php ENDPATH**/ ?>