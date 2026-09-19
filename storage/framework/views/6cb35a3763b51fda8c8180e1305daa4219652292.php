

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Editar Emergencia de Fuego — <?php echo e($emergenciaFuego->codigo); ?>

        </h6>
        <a href="<?php echo e(route('emergencias-fuego.show', $emergenciaFuego)); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al detalle
        </a>
    </div>
    <div class="card-body">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('emergencias-fuego.update', $emergenciaFuego)); ?>" method="POST" id="formEmergencia">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <h5 class="text-primary mb-3">1. Datos Generales</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha/Hora Salida <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_salida" class="form-control" required
                               value="<?php echo e(old('fecha_salida', $emergenciaFuego->fecha_salida?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada al sitio</label>
                        <input type="datetime-local" name="fecha_llegada_sitio" class="form-control"
                               value="<?php echo e(old('fecha_llegada_sitio', $emergenciaFuego->fecha_llegada_sitio?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Control del fuego</label>
                        <input type="datetime-local" name="fecha_control" class="form-control"
                               value="<?php echo e(old('fecha_control', $emergenciaFuego->fecha_control?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Extinción total</label>
                        <input type="datetime-local" name="fecha_extincion" class="form-control"
                               value="<?php echo e(old('fecha_extincion', $emergenciaFuego->fecha_extincion?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada a base</label>
                        <input type="datetime-local" name="fecha_llegada_base" class="form-control"
                               value="<?php echo e(old('fecha_llegada_base', $emergenciaFuego->fecha_llegada_base?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Dirección <span class="text-danger">*</span></label>
                        <input type="text" name="direccion" class="form-control" required
                               value="<?php echo e(old('direccion', $emergenciaFuego->direccion)); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencia" class="form-control"
                               value="<?php echo e(old('referencia', $emergenciaFuego->referencia)); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Parroquia</label>
                        <select name="parroquia_id" class="form-control">
                            <option value="">Seleccione...</option>
                            <?php $__currentLoopData = $parroquias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $par): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($par->id); ?>" <?php echo e(old('parroquia_id', $emergenciaFuego->parroquia_id) == $par->id ? 'selected' : ''); ?>>
                                    <?php echo e($par->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sector</label>
                        <input type="text" name="sector" class="form-control"
                               value="<?php echo e(old('sector', $emergenciaFuego->sector)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Motivo del llamado <span class="text-danger">*</span></label>
                        <input type="text" name="motivo_llamado" class="form-control" required
                               value="<?php echo e(old('motivo_llamado', $emergenciaFuego->motivo_llamado)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo de fuego <span class="text-danger">*</span></label>
                        <select name="tipo_fuego" class="form-control" required>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t); ?>" <?php echo e(old('tipo_fuego', $emergenciaFuego->tipo_fuego) == $t ? 'selected' : ''); ?>><?php echo e($t); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nivel de riesgo <span class="text-danger">*</span></label>
                        <select name="nivel_riesgo" class="form-control" required>
                            <?php $__currentLoopData = $niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($n); ?>" <?php echo e(old('nivel_riesgo', $emergenciaFuego->nivel_riesgo) == $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-control" required>
                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($e); ?>" <?php echo e(old('estado', $emergenciaFuego->estado) == $e ? 'selected' : ''); ?>><?php echo e($e); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Causa probable</label>
                        <input type="text" name="causa_probable" class="form-control"
                               value="<?php echo e(old('causa_probable', $emergenciaFuego->causa_probable)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Área afectada (m²)</label>
                        <input type="number" step="0.01" name="area_afectada_m2" class="form-control"
                               value="<?php echo e(old('area_afectada_m2', $emergenciaFuego->area_afectada_m2)); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pérdidas estimadas</label>
                        <input type="number" step="0.01" name="perdidas_estimadas" class="form-control"
                               value="<?php echo e(old('perdidas_estimadas', $emergenciaFuego->perdidas_estimadas)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Agua utilizada (litros)</label>
                        <input type="number" step="0.01" name="agua_utilizada_litros" class="form-control"
                               value="<?php echo e(old('agua_utilizada_litros', $emergenciaFuego->agua_utilizada_litros)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Espuma utilizada (litros)</label>
                        <input type="number" step="0.01" name="espuma_utilizada_litros" class="form-control"
                               value="<?php echo e(old('espuma_utilizada_litros', $emergenciaFuego->espuma_utilizada_litros)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Químico utilizado (litros)</label>
                        <input type="number" step="0.01" name="quimico_utilizado_litros" class="form-control"
                               value="<?php echo e(old('quimico_utilizado_litros', $emergenciaFuego->quimico_utilizado_litros)); ?>">
                    </div>
                </div>
            </div>

            
            <h6 class="text-secondary mt-3 mb-2">
                <i class="fas fa-tools"></i> Herramientas Utilizadas
            </h6>
            <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarHerramienta()">
                <i class="fas fa-plus"></i> Añadir Herramienta
            </button>

            <div id="herramientas-container">
                <?php $__currentLoopData = $emergenciaFuego->herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $herr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row herramienta-row mb-2" id="herramienta-existente-<?php echo e($i); ?>">
                        <div class="col-md-5">
                            <select name="herramientas[<?php echo e($i); ?>][herramienta_id]" class="form-control">
                                <option value="">Seleccione herramienta...</option>
                                <?php $__currentLoopData = $herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($h->id); ?>" <?php echo e($herr->id == $h->id ? 'selected' : ''); ?>>
                                        <?php echo e($h->descripcion); ?> <?php echo e($h->codigo ? '(' . $h->codigo . ')' : ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="herramientas[<?php echo e($i); ?>][cantidad]" class="form-control" 
                                   value="<?php echo e($herr->pivot->cantidad); ?>" min="1">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="herramientas[<?php echo e($i); ?>][observaciones]" class="form-control" 
                                   value="<?php echo e($herr->pivot->observaciones); ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger" onclick="document.getElementById('herramienta-existente-<?php echo e($i); ?>').remove()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ilesos</label>
                        <input type="number" name="victimas_ilesos" class="form-control" min="0"
                               value="<?php echo e(old('victimas_ilesos', $emergenciaFuego->victimas_ilesos ?? 0)); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Heridos</label>
                        <input type="number" name="victimas_heridos" class="form-control" min="0"
                               value="<?php echo e(old('victimas_heridos', $emergenciaFuego->victimas_heridos ?? 0)); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fallecidos</label>
                        <input type="number" name="victimas_fallecidos" class="form-control" min="0"
                               value="<?php echo e(old('victimas_fallecidos', $emergenciaFuego->victimas_fallecidos ?? 0)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="apoyoExterno"
                                   name="requirio_apoyo_externo" value="1"
                                   <?php echo e(old('requirio_apoyo_externo', $emergenciaFuego->requirio_apoyo_externo) ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="apoyoExterno">Requirió apoyo externo</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Detalle del apoyo</label>
                        <input type="text" name="detalle_apoyo" class="form-control"
                               value="<?php echo e(old('detalle_apoyo', $emergenciaFuego->detalle_apoyo)); ?>">
                    </div>
                </div>
            </div>

            <hr>

            
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">2. Personal que Atiende <span class="text-danger">*</span></h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Añadir Personal
                    </button>
                    <div id="personal-container">
                        <?php $__currentLoopData = $emergenciaFuego->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row personal-row mb-2" id="personal-existente-<?php echo e($i); ?>">
                                <div class="col-md-5">
                                    <select name="personal[<?php echo e($i); ?>][user_id]" class="form-control" required>
                                        <option value="">Seleccione usuario...</option>
                                        <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($u->id); ?>" <?php echo e($p->id == $u->id ? 'selected' : ''); ?>><?php echo e($u->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="personal[<?php echo e($i); ?>][rol_en_emergencia]" class="form-control"
                                           value="<?php echo e($p->pivot->rol_en_emergencia); ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('personal-existente-<?php echo e($i); ?>').remove()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">3. Vehículos Utilizados <span class="text-danger">*</span></h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                        <i class="fas fa-plus"></i> Añadir Vehículo
                    </button>
                    <div id="vehiculos-container">
                        <?php $__currentLoopData = $emergenciaFuego->vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3" id="vehiculo-existente-<?php echo e($i); ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">Vehículo</label>
                                        <select name="vehiculos[<?php echo e($i); ?>][vehiculo_id]" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                            <?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $veh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($veh->id); ?>" <?php echo e($v->id == $veh->id ? 'selected' : ''); ?>>
                                                    <?php echo e($veh->placa); ?> - <?php echo e($veh->marca ?? ''); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small font-weight-bold">Rol</label>
                                        <input type="text" name="vehiculos[<?php echo e($i); ?>][rol_en_emergencia]" class="form-control"
                                               value="<?php echo e($v->pivot->rol_en_emergencia); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Km Salida</label>
                                        <input type="number" name="vehiculos[<?php echo e($i); ?>][km_salida]" class="form-control"
                                               value="<?php echo e($v->pivot->km_salida); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Km Llegada</label>
                                        <input type="number" name="vehiculos[<?php echo e($i); ?>][km_llegada]" class="form-control"
                                               value="<?php echo e($v->pivot->km_llegada); ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="small font-weight-bold">&nbsp;</label>
                                        <button type="button" class="btn btn-danger form-control" onclick="document.getElementById('vehiculo-existente-<?php echo e($i); ?>').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">4. Pacientes / Víctimas</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPaciente()">
                        <i class="fas fa-plus"></i> Añadir Paciente
                    </button>
                    <div id="pacientes-container">
                        <?php $__currentLoopData = $emergenciaFuego->pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3 border-warning" id="paciente-existente-<?php echo e($i); ?>">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-warning">Paciente #<?php echo e($i + 1); ?></strong>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('paciente-existente-<?php echo e($i); ?>').remove()">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">Nombre completo</label>
                                        <input type="text" name="pacientes[<?php echo e($i); ?>][nombre_completo]" class="form-control"
                                               value="<?php echo e($pac->nombre_completo); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Edad</label>
                                        <input type="number" name="pacientes[<?php echo e($i); ?>][edad]" class="form-control" value="<?php echo e($pac->edad); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Sexo</label>
                                        <select name="pacientes[<?php echo e($i); ?>][sexo]" class="form-control">
                                            <?php $__currentLoopData = ['Indefinido','M','F']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($s); ?>" <?php echo e($pac->sexo == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Cédula</label>
                                        <input type="text" name="pacientes[<?php echo e($i); ?>][cedula]" class="form-control" value="<?php echo e($pac->cedula); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Teléfono</label>
                                        <input type="text" name="pacientes[<?php echo e($i); ?>][telefono]" class="form-control" value="<?php echo e($pac->telefono); ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label class="small font-weight-bold">Condición</label>
                                        <select name="pacientes[<?php echo e($i); ?>][condicion]" class="form-control">
                                            <?php $__currentLoopData = ['Ileso','Herido','Fallecido','Desconocido']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($c); ?>" <?php echo e($pac->condicion == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">Tipo de lesión</label>
                                        <input type="text" name="pacientes[<?php echo e($i); ?>][tipo_lesion]" class="form-control" value="<?php echo e($pac->tipo_lesion); ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="small font-weight-bold">Hospital destino</label>
                                        <input type="text" name="pacientes[<?php echo e($i); ?>][hospital_destino]" class="form-control" value="<?php echo e($pac->hospital_destino); ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2"><label class="small">FC</label><input type="number" name="pacientes[<?php echo e($i); ?>][frecuencia_cardiaca]" class="form-control" value="<?php echo e($pac->frecuencia_cardiaca); ?>"></div>
                                    <div class="col-md-2"><label class="small">FR</label><input type="number" name="pacientes[<?php echo e($i); ?>][frecuencia_respiratoria]" class="form-control" value="<?php echo e($pac->frecuencia_respiratoria); ?>"></div>
                                    <div class="col-md-2"><label class="small">SatO₂</label><input type="number" name="pacientes[<?php echo e($i); ?>][saturacion_oxigeno]" class="form-control" value="<?php echo e($pac->saturacion_oxigeno); ?>"></div>
                                    <div class="col-md-2"><label class="small">Temp</label><input type="number" step="0.1" name="pacientes[<?php echo e($i); ?>][temperatura]" class="form-control" value="<?php echo e($pac->temperatura); ?>"></div>
                                    <div class="col-md-4"><label class="small">Observaciones</label><input type="text" name="pacientes[<?php echo e($i); ?>][observaciones]" class="form-control" value="<?php echo e($pac->observaciones); ?>"></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">5. Insumos Utilizados</h5>
                    <div class="alert alert-warning py-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Al guardar se restaurará el stock anterior y se descontará el nuevo.
                    </div>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarInsumo()">
                        <i class="fas fa-plus"></i> Añadir Insumo
                    </button>
                    <div id="insumos-container">
                        <?php $__currentLoopData = $emergenciaFuego->insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row insumo-row mb-2" id="insumo-existente-<?php echo e($i); ?>">
                                <div class="col-md-5">
                                    <select name="insumos[<?php echo e($i); ?>][insumo_medico_id]" class="form-control" required>
                                        <option value="">Seleccione insumo...</option>
                                        <?php $__currentLoopData = $insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($insumo->id); ?>" <?php echo e($ins->id == $insumo->id ? 'selected' : ''); ?>>
                                                <?php echo e($insumo->descripcion); ?> (Stock: <?php echo e($insumo->cantidad); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="0.01" name="insumos[<?php echo e($i); ?>][cantidad]" class="form-control"
                                           value="<?php echo e($ins->pivot->cantidad); ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="insumos[<?php echo e($i); ?>][observaciones]" class="form-control" value="<?php echo e($ins->pivot->observaciones); ?>">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('insumo-existente-<?php echo e($i); ?>').remove()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones Generales</label>
                        <textarea name="observaciones_generales" class="form-control" rows="3"><?php echo e(old('observaciones_generales', $emergenciaFuego->observaciones_generales)); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Emergencia
                </button>
                <a href="<?php echo e(route('emergencias-fuego.show', $emergenciaFuego)); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let personalCount = <?php echo e($emergenciaFuego->personal->count()); ?>;
let vehiculoCount = <?php echo e($emergenciaFuego->vehiculos->count()); ?>;
let pacienteCount = <?php echo e($emergenciaFuego->pacientes->count()); ?>;
let insumoCount = <?php echo e($emergenciaFuego->insumos->count()); ?>;
let herramientaCount = <?php echo e($emergenciaFuego->herramientas->count()); ?>;

const personalOptions = `<?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;
const vehiculosOptions = `<?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($v->id); ?>"><?php echo e($v->placa); ?> - <?php echo e($v->marca ?? ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;
const insumosOptions = `<?php $__currentLoopData = $insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($i->id); ?>"><?php echo e($i->descripcion); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;
const herramientasOptions = `<?php $__currentLoopData = $herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($h->id); ?>"><?php echo e($h->descripcion); ?> <?php echo e($h->codigo ? '(' . $h->codigo . ')' : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;

function agregarPersonal() {
    personalCount++;
    const html = `
    <div class="row personal-row mb-2" id="personal-nuevo-${personalCount}">
        <div class="col-md-5">
            <select name="personal[${personalCount}][user_id]" class="form-control" required>
                <option value="">Seleccione usuario...</option>
                ${personalOptions}
            </select>
        </div>
        <div class="col-md-5">
            <input type="text" name="personal[${personalCount}][rol_en_emergencia]" class="form-control" placeholder="Rol" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('personal-nuevo-${personalCount}').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    document.getElementById('personal-container').insertAdjacentHTML('beforeend', html);
}

function agregarVehiculo() {
    vehiculoCount++;
    const html = `
    <div class="card mb-2 p-3" id="vehiculo-nuevo-${vehiculoCount}">
        <div class="row">
            <div class="col-md-4">
                <label class="small font-weight-bold">Vehículo</label>
                <select name="vehiculos[${vehiculoCount}][vehiculo_id]" class="form-control" required>
                    <option value="">Seleccione...</option>
                    ${vehiculosOptions}
                </select>
            </div>
            <div class="col-md-3">
                <label class="small font-weight-bold">Rol</label>
                <input type="text" name="vehiculos[${vehiculoCount}][rol_en_emergencia]" class="form-control">
            </div>
            <div class="col-md-2"><label class="small font-weight-bold">Km Salida</label><input type="number" name="vehiculos[${vehiculoCount}][km_salida]" class="form-control"></div>
            <div class="col-md-2"><label class="small font-weight-bold">Km Llegada</label><input type="number" name="vehiculos[${vehiculoCount}][km_llegada]" class="form-control"></div>
            <div class="col-md-1">
                <label class="small font-weight-bold">&nbsp;</label>
                <button type="button" class="btn btn-danger form-control" onclick="document.getElementById('vehiculo-nuevo-${vehiculoCount}').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>`;
    document.getElementById('vehiculos-container').insertAdjacentHTML('beforeend', html);
}

function agregarPaciente() {
    pacienteCount++;
    const html = `
    <div class="card mb-2 p-3 border-warning" id="paciente-nuevo-${pacienteCount}">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="text-warning">Nuevo Paciente</strong>
            <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('paciente-nuevo-${pacienteCount}').remove()">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
        <div class="row">
            <div class="col-md-4"><label class="small font-weight-bold">Nombre completo</label><input type="text" name="pacientes[${pacienteCount}][nombre_completo]" class="form-control"></div>
            <div class="col-md-2"><label class="small font-weight-bold">Edad</label><input type="number" name="pacientes[${pacienteCount}][edad]" class="form-control"></div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Sexo</label>
                <select name="pacientes[${pacienteCount}][sexo]" class="form-control">
                    <option value="Indefinido">Indefinido</option><option value="M">Masculino</option><option value="F">Femenino</option>
                </select>
            </div>
            <div class="col-md-2"><label class="small font-weight-bold">Cédula</label><input type="text" name="pacientes[${pacienteCount}][cedula]" class="form-control"></div>
            <div class="col-md-2"><label class="small font-weight-bold">Teléfono</label><input type="text" name="pacientes[${pacienteCount}][telefono]" class="form-control"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <label class="small font-weight-bold">Condición</label>
                <select name="pacientes[${pacienteCount}][condicion]" class="form-control">
                    <option value="Ileso">Ileso</option><option value="Herido">Herido</option><option value="Fallecido">Fallecido</option><option value="Desconocido">Desconocido</option>
                </select>
            </div>
            <div class="col-md-4"><label class="small font-weight-bold">Tipo de lesión</label><input type="text" name="pacientes[${pacienteCount}][tipo_lesion]" class="form-control"></div>
            <div class="col-md-5"><label class="small font-weight-bold">Hospital destino</label><input type="text" name="pacientes[${pacienteCount}][hospital_destino]" class="form-control"></div>
        </div>
    </div>`;
    document.getElementById('pacientes-container').insertAdjacentHTML('beforeend', html);
}

function agregarInsumo() {
    insumoCount++;
    const html = `
    <div class="row insumo-row mb-2" id="insumo-nuevo-${insumoCount}">
        <div class="col-md-5">
            <select name="insumos[${insumoCount}][insumo_medico_id]" class="form-control" required>
                <option value="">Seleccione insumo...</option>
                ${insumosOptions}
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="insumos[${insumoCount}][cantidad]" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="insumos[${insumoCount}][observaciones]" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('insumo-nuevo-${insumoCount}').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    document.getElementById('insumos-container').insertAdjacentHTML('beforeend', html);
}

function agregarHerramienta() {
    herramientaCount++;
    const html = `
    <div class="row herramienta-row mb-2" id="herramienta-nuevo-${herramientaCount}">
        <div class="col-md-5">
            <select name="herramientas[${herramientaCount}][herramienta_id]" class="form-control">
                <option value="">Seleccione herramienta...</option>
                ${herramientasOptions}
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="herramientas[${herramientaCount}][cantidad]" class="form-control" value="1" min="1">
        </div>
        <div class="col-md-3">
            <input type="text" name="herramientas[${herramientaCount}][observaciones]" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('herramienta-nuevo-${herramientaCount}').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    document.getElementById('herramientas-container').insertAdjacentHTML('beforeend', html);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_fuego/edit.blade.php ENDPATH**/ ?>