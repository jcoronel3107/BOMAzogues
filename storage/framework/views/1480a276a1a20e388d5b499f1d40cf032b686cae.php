

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Editar Novedad - NOV-<?php echo e(str_pad($novedad->id, 6, '0', STR_PAD_LEFT)); ?></h6>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('estacion-novedades.update', $novedad)); ?>" method="POST" id="formNovedad">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('fecha', $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('Y-m-d') : $novedad->fecha)); ?>" required>
                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estación <span class="text-danger">*</span></label>
                        <select name="estacion_id" class="form-control <?php $__errorArgs = ['estacion_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Seleccione...</option>
                            <?php $__currentLoopData = $estaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estacion->id); ?>" <?php echo e(old('estacion_id', $novedad->estacion_id) == $estacion->id ? 'selected' : ''); ?>>
                                    <?php echo e($estacion->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['estacion_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones Generales</label>
                        <textarea name="observaciones" class="form-control" rows="2"><?php echo e(old('observaciones', $novedad->observaciones)); ?></textarea>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Emergencias -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Emergencias Atendidas</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarEmergencia()">
                        <i class="fas fa-plus"></i> Agregar Emergencia
                    </button>
                    <div id="emergencias-container">
                        <?php $__currentLoopData = $novedad->emergencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $emergencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3" id="emergencia-<?php echo e($key); ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo Emergencia</label>
                                            <select name="emergencias[<?php echo e($key); ?>][tipo]" class="form-control">
                                                <option value="incendio" <?php echo e($emergencia->tipo_emergencia == 'incendio' ? 'selected' : ''); ?>>Incendio</option>
                                                <option value="rescate" <?php echo e($emergencia->tipo_emergencia == 'rescate' ? 'selected' : ''); ?>>Rescate</option>
                                                <option value="inundacion" <?php echo e($emergencia->tipo_emergencia == 'inundacion' ? 'selected' : ''); ?>>Inundación</option>
                                                <option value="transito" <?php echo e($emergencia->tipo_emergencia == 'transito' ? 'selected' : ''); ?>>Tránsito</option>
                                                <option value="fuga" <?php echo e($emergencia->tipo_emergencia == 'fuga' ? 'selected' : ''); ?>>Fuga</option>
                                                <option value="salud" <?php echo e($emergencia->tipo_emergencia == 'salud' ? 'selected' : ''); ?>>Salud</option>
                                                <option value="otro" <?php echo e($emergencia->tipo_emergencia == 'otro' ? 'selected' : ''); ?>>Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Lugar</label>
                                            <input type="text" name="emergencias[<?php echo e($key); ?>][lugar]" class="form-control" value="<?php echo e($emergencia->lugar); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hora Ingreso</label>
                                            <input type="time" name="emergencias[<?php echo e($key); ?>][hora_ingreso]" class="form-control" value="<?php echo e($emergencia->hora_ingreso); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hora Salida</label>
                                            <input type="time" name="emergencias[<?php echo e($key); ?>][hora_salida]" class="form-control" value="<?php echo e($emergencia->hora_salida); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarEmergencia(<?php echo e($key); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea name="emergencias[<?php echo e($key); ?>][descripcion]" class="form-control" rows="2"><?php echo e($emergencia->descripcion); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Vehículos -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Novedades de Vehículos</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                        <i class="fas fa-plus"></i> Agregar Novedad de Vehículo
                    </button>
                    <div id="vehiculos-container">
                        <?php $__currentLoopData = $novedad->vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3" id="vehiculo-<?php echo e($key); ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehículo</label>
                                            <select name="vehiculos[<?php echo e($key); ?>][vehiculo_id]" class="form-control">
                                                <option value="">Seleccione...</option>
                                                <?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($v->id); ?>" <?php echo e($vehiculo->vehiculo_id == $v->id ? 'selected' : ''); ?>><?php echo e($v->placa); ?> - <?php echo e($v->marca); ?> <?php echo e($v->modelo); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="vehiculos[<?php echo e($key); ?>][estado]" class="form-control">
                                                <option value="operativo" <?php echo e($vehiculo->estado == 'operativo' ? 'selected' : ''); ?>>Operativo</option>
                                                <option value="mantenimiento" <?php echo e($vehiculo->estado == 'mantenimiento' ? 'selected' : ''); ?>>Mantenimiento</option>
                                                <option value="averiado" <?php echo e($vehiculo->estado == 'averiado' ? 'selected' : ''); ?>>Averiado</option>
                                                <option value="fuera_servicio" <?php echo e($vehiculo->estado == 'fuera_servicio' ? 'selected' : ''); ?>>Fuera de Servicio</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo Novedad</label>
                                            <input type="text" name="vehiculos[<?php echo e($key); ?>][tipo_novedad]" class="form-control" value="<?php echo e($vehiculo->tipo_novedad); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarVehiculo(<?php echo e($key); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha Reporte</label>
                                            <input type="date" name="vehiculos[<?php echo e($key); ?>][fecha_reporte]" class="form-control" value="<?php echo e($vehiculo->fecha_reporte instanceof \Carbon\Carbon ? $vehiculo->fecha_reporte->format('Y-m-d') : date('Y-m-d', strtotime($vehiculo->fecha_reporte))); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha Solución</label>
                                            <input type="date" name="vehiculos[<?php echo e($key); ?>][fecha_solucion]" class="form-control" value="<?php echo e($vehiculo->fecha_solucion ? ($vehiculo->fecha_solucion instanceof \Carbon\Carbon ? $vehiculo->fecha_solucion->format('Y-m-d') : date('Y-m-d', strtotime($vehiculo->fecha_solucion))) : ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kilometraje</label>
                                            <input type="number" name="vehiculos[<?php echo e($key); ?>][kilometraje]" class="form-control" value="<?php echo e($vehiculo->kilometraje); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea name="vehiculos[<?php echo e($key); ?>][descripcion]" class="form-control" rows="2"><?php echo e($vehiculo->descripcion); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Personal -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Personal</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Agregar Personal
                    </button>
                    <div id="personal-container">
                        <?php $__currentLoopData = $novedad->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3" id="personal-<?php echo e($key); ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Funcionario</label>
                                            <select name="personal[<?php echo e($key); ?>][user_id]" class="form-control">
                                                <option value="">Seleccione...</option>
                                                <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($p->id); ?>" <?php echo e($persona->user_id == $p->id ? 'selected' : ''); ?>><?php echo e($p->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            <input type="text" name="personal[<?php echo e($key); ?>][cargo]" class="form-control" value="<?php echo e($persona->cargo); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Turno</label>
                                            <select name="personal[<?php echo e($key); ?>][turno]" class="form-control">
                                                <option value="mañana" <?php echo e($persona->turno == 'mañana' ? 'selected' : ''); ?>>Mañana</option>
                                                <option value="tarde" <?php echo e($persona->turno == 'tarde' ? 'selected' : ''); ?>>Tarde</option>
                                                <option value="noche" <?php echo e($persona->turno == 'noche' ? 'selected' : ''); ?>>Noche</option>
                                                <option value="descanso" <?php echo e($persona->turno == 'descanso' ? 'selected' : ''); ?>>Descanso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="personal[<?php echo e($key); ?>][estado]" class="form-control">
                                                <option value="presente" <?php echo e($persona->estado == 'presente' ? 'selected' : ''); ?>>Presente</option>
                                                <option value="ausente" <?php echo e($persona->estado == 'ausente' ? 'selected' : ''); ?>>Ausente</option>
                                                <option value="permiso" <?php echo e($persona->estado == 'permiso' ? 'selected' : ''); ?>>Permiso</option>
                                                <option value="licencia" <?php echo e($persona->estado == 'licencia' ? 'selected' : ''); ?>>Licencia</option>
                                                <option value="comision" <?php echo e($persona->estado == 'comision' ? 'selected' : ''); ?>>Comisión</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarPersonal(<?php echo e($key); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea name="personal[<?php echo e($key); ?>][observaciones]" class="form-control" rows="1"><?php echo e($persona->observaciones); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Integrantes de la Guardia Bomberil -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Integrantes de la Guardia Bomberil</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarIntegranteGuardia()">
                        <i class="fas fa-plus"></i> Agregar Integrante
                    </button>
                    <div id="integrantes-guardia-container">
                        <?php if($novedad->integrantes_guardia): ?>
                            <?php $__currentLoopData = $novedad->integrantes_guardia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $integrante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="card mb-2 p-3" id="integrante-guardia-<?php echo e($key); ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nombres y Apellidos</label>
                                                <input type="text" name="integrantes_guardia[<?php echo e($key); ?>][nombre]" class="form-control" value="<?php echo e($integrante['nombre'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Cédula</label>
                                                <input type="text" name="integrantes_guardia[<?php echo e($key); ?>][cedula]" class="form-control" value="<?php echo e($integrante['cedula'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Cargo</label>
                                                <select name="integrantes_guardia[<?php echo e($key); ?>][cargo]" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    <option value="Bombero" <?php echo e(($integrante['cargo'] ?? '') == 'Bombero' ? 'selected' : ''); ?>>Bombero</option>
                                                    <option value="Teniente" <?php echo e(($integrante['cargo'] ?? '') == 'Teniente' ? 'selected' : ''); ?>>Teniente</option>
                                                    <option value="Capitán" <?php echo e(($integrante['cargo'] ?? '') == 'Capitán' ? 'selected' : ''); ?>>Capitán</option>
                                                    <option value="Mayor" <?php echo e(($integrante['cargo'] ?? '') == 'Mayor' ? 'selected' : ''); ?>>Mayor</option>
                                                    <option value="Comandante" <?php echo e(($integrante['cargo'] ?? '') == 'Comandante' ? 'selected' : ''); ?>>Comandante</option>
                                                    <option value="Paramédico" <?php echo e(($integrante['cargo'] ?? '') == 'Paramédico' ? 'selected' : ''); ?>>Paramédico</option>
                                                    <option value="Conductor" <?php echo e(($integrante['cargo'] ?? '') == 'Conductor' ? 'selected' : ''); ?>>Conductor</option>
                                                    <option value="Operador Radio" <?php echo e(($integrante['cargo'] ?? '') == 'Operador Radio' ? 'selected' : ''); ?>>Operador Radio</option>
                                                    <option value="Administrativo" <?php echo e(($integrante['cargo'] ?? '') == 'Administrativo' ? 'selected' : ''); ?>>Administrativo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarIntegranteGuardia(<?php echo e($key); ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observaciones del Integrante</label>
                                                <input type="text" name="integrantes_guardia[<?php echo e($key); ?>][observaciones]" class="form-control" value="<?php echo e($integrante['observaciones'] ?? ''); ?>" placeholder="Observaciones">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Novedad
                </button>
                <a href="<?php echo e(route('estacion-novedades.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let emergenciaCount = <?php echo e(count($novedad->emergencias)); ?>;
let vehiculoCount = <?php echo e(count($novedad->vehiculos)); ?>;
let personalCount = <?php echo e(count($novedad->personal)); ?>;
let integranteGuardiaCount = <?php echo e(isset($novedad->integrantes_guardia) ? count($novedad->integrantes_guardia) : 0); ?>;

// Funciones para Emergencias
function agregarEmergencia() {
    emergenciaCount++;
    const container = document.getElementById('emergencias-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 p-3';
    div.id = 'emergencia-' + emergenciaCount;
    div.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tipo Emergencia</label>
                    <select name="emergencias[${emergenciaCount}][tipo]" class="form-control">
                        <option value="incendio">Incendio</option>
                        <option value="rescate">Rescate</option>
                        <option value="inundacion">Inundación</option>
                        <option value="transito">Tránsito</option>
                        <option value="fuga">Fuga</option>
                        <option value="salud">Salud</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Lugar</label>
                    <input type="text" name="emergencias[${emergenciaCount}][lugar]" class="form-control" placeholder="Lugar">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Hora Ingreso</label>
                    <input type="time" name="emergencias[${emergenciaCount}][hora_ingreso]" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Hora Salida</label>
                    <input type="time" name="emergencias[${emergenciaCount}][hora_salida]" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarEmergencia(${emergenciaCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="emergencias[${emergenciaCount}][descripcion]" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function eliminarEmergencia(id) {
    const element = document.getElementById('emergencia-' + id);
    if (element) element.remove();
}

// Funciones para Vehículos
function agregarVehiculo() {
    vehiculoCount++;
    const container = document.getElementById('vehiculos-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 p-3';
    div.id = 'vehiculo-' + vehiculoCount;
    div.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Vehículo</label>
                    <select name="vehiculos[${vehiculoCount}][vehiculo_id]" class="form-control">
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vehiculo->id); ?>"><?php echo e($vehiculo->placa); ?> - <?php echo e($vehiculo->marca); ?> <?php echo e($vehiculo->modelo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Estado</label>
                    <select name="vehiculos[${vehiculoCount}][estado]" class="form-control">
                        <option value="operativo">Operativo</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="averiado">Averiado</option>
                        <option value="fuera_servicio">Fuera de Servicio</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tipo Novedad</label>
                    <input type="text" name="vehiculos[${vehiculoCount}][tipo_novedad]" class="form-control" placeholder="Ej: Mantenimiento, Avería">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarVehiculo(${vehiculoCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha Reporte</label>
                    <input type="date" name="vehiculos[${vehiculoCount}][fecha_reporte]" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha Solución</label>
                    <input type="date" name="vehiculos[${vehiculoCount}][fecha_solucion]" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Kilometraje</label>
                    <input type="number" name="vehiculos[${vehiculoCount}][kilometraje]" class="form-control" placeholder="Km">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="vehiculos[${vehiculoCount}][descripcion]" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function eliminarVehiculo(id) {
    const element = document.getElementById('vehiculo-' + id);
    if (element) element.remove();
}

// Funciones para Personal
function agregarPersonal() {
    personalCount++;
    const container = document.getElementById('personal-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 p-3';
    div.id = 'personal-' + personalCount;
    div.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Funcionario</label>
                    <select name="personal[${personalCount}][user_id]" class="form-control">
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($persona->id); ?>"><?php echo e($persona->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Cargo</label>
                    <input type="text" name="personal[${personalCount}][cargo]" class="form-control" placeholder="Cargo">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Turno</label>
                    <select name="personal[${personalCount}][turno]" class="form-control">
                        <option value="mañana">Mañana</option>
                        <option value="tarde">Tarde</option>
                        <option value="noche">Noche</option>
                        <option value="descanso">Descanso</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Estado</label>
                    <select name="personal[${personalCount}][estado]" class="form-control">
                        <option value="presente">Presente</option>
                        <option value="ausente">Ausente</option>
                        <option value="permiso">Permiso</option>
                        <option value="licencia">Licencia</option>
                        <option value="comision">Comisión</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarPersonal(${personalCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="personal[${personalCount}][observaciones]" class="form-control" rows="1"></textarea>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function eliminarPersonal(id) {
    const element = document.getElementById('personal-' + id);
    if (element) element.remove();
}

// Funciones para Integrantes de la Guardia
function agregarIntegranteGuardia() {
    integranteGuardiaCount++;
    const container = document.getElementById('integrantes-guardia-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 p-3';
    div.id = 'integrante-guardia-' + integranteGuardiaCount;
    div.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nombres y Apellidos</label>
                    <input type="text" name="integrantes_guardia[${integranteGuardiaCount}][nombre]" class="form-control" placeholder="Nombre completo">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Cédula</label>
                    <input type="text" name="integrantes_guardia[${integranteGuardiaCount}][cedula]" class="form-control" placeholder="Cédula">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Cargo</label>
                    <select name="integrantes_guardia[${integranteGuardiaCount}][cargo]" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="Bombero">Bombero</option>
                        <option value="Teniente">Teniente</option>
                        <option value="Capitán">Capitán</option>
                        <option value="Mayor">Mayor</option>
                        <option value="Comandante">Comandante</option>
                        <option value="Paramédico">Paramédico</option>
                        <option value="Conductor">Conductor</option>
                        <option value="Operador Radio">Operador Radio</option>
                        <option value="Administrativo">Administrativo</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarIntegranteGuardia(${integranteGuardiaCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Observaciones del Integrante</label>
                    <input type="text" name="integrantes_guardia[${integranteGuardiaCount}][observaciones]" class="form-control" placeholder="Observaciones">
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function eliminarIntegranteGuardia(id) {
    const element = document.getElementById('integrante-guardia-' + id);
    if (element) element.remove();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/estacion_novedades/edit.blade.php ENDPATH**/ ?>