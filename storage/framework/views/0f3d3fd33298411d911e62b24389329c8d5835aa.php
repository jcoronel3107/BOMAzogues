

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Editar Emergencia Prehospitalaria — <?php echo e($emergenciaPrehospitalaria->codigo); ?>

        </h6>
        <a href="<?php echo e(route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria)); ?>"
           class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al detalle
        </a>
    </div>
    <div class="card-body">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <strong>Por favor corrige los siguientes errores:</strong>
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

        <form action="<?php echo e(route('emergencias-prehospitalarias.update', $emergenciaPrehospitalaria)); ?>"
              method="POST" id="formEmergencia">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <h5 class="text-primary mb-3">1. Datos Generales</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha/Hora Salida <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_salida" class="form-control" required
                               value="<?php echo e(old('fecha_salida', $emergenciaPrehospitalaria->fecha_salida?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada al sitio</label>
                        <input type="datetime-local" name="fecha_llegada_sitio" class="form-control"
                               value="<?php echo e(old('fecha_llegada_sitio', $emergenciaPrehospitalaria->fecha_llegada_sitio?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Salida del sitio</label>
                        <input type="datetime-local" name="fecha_salida_sitio" class="form-control"
                               value="<?php echo e(old('fecha_salida_sitio', $emergenciaPrehospitalaria->fecha_salida_sitio?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada a base</label>
                        <input type="datetime-local" name="fecha_llegada_base" class="form-control"
                               value="<?php echo e(old('fecha_llegada_base', $emergenciaPrehospitalaria->fecha_llegada_base?->format('Y-m-d\TH:i'))); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección <span class="text-danger">*</span></label>
                        <input type="text" name="direccion" class="form-control" required
                               value="<?php echo e(old('direccion', $emergenciaPrehospitalaria->direccion)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencia" class="form-control"
                               value="<?php echo e(old('referencia', $emergenciaPrehospitalaria->referencia)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Prioridad <span class="text-danger">*</span></label>
                        <select name="prioridad" class="form-control" required>
                            <?php $__currentLoopData = ['Rojo','Naranja','Amarillo','Verde','Azul']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p); ?>"
                                    <?php echo e(old('prioridad', $emergenciaPrehospitalaria->prioridad) == $p ? 'selected' : ''); ?>>
                                    <?php echo e($p); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Motivo del llamado <span class="text-danger">*</span></label>
                        <input type="text" name="motivo_llamado" class="form-control" required
                               value="<?php echo e(old('motivo_llamado', $emergenciaPrehospitalaria->motivo_llamado)); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo de Emergencia <span class="text-danger">*</span></label>
                        <select name="tipo_emergencia" class="form-control" required>
                            <?php $__currentLoopData = ['Accidente de tránsito','Emergencia médica','Trauma','Obstétrica','Pediatrica','Psiquiatrica','Otra']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t); ?>"
                                    <?php echo e(old('tipo_emergencia', $emergenciaPrehospitalaria->tipo_emergencia) == $t ? 'selected' : ''); ?>>
                                    <?php echo e($t); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Vehículo (Ambulancia) <span class="text-danger">*</span></label>
                        <select name="vehiculo_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($v->id); ?>"
                                    <?php echo e(old('vehiculo_id', $emergenciaPrehospitalaria->vehiculo_id) == $v->id ? 'selected' : ''); ?>>
                                    <?php echo e($v->placa); ?> - <?php echo e($v->marca); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-control" required>
                            <?php $__currentLoopData = ['En curso','Finalizada','Cancelada','Derivada']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($e); ?>"
                                    <?php echo e(old('estado', $emergenciaPrehospitalaria->estado) == $e ? 'selected' : ''); ?>>
                                    <?php echo e($e); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">2. Personal que Atiende</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Añadir Personal
                    </button>
                    <div id="personal-container">
                        <?php $__currentLoopData = $emergenciaPrehospitalaria->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3" id="personal-<?php echo e($i); ?>">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Funcionario <span class="text-danger">*</span></label>
                                            <select name="personal[<?php echo e($i); ?>][user_id]" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($u->id); ?>" <?php echo e($p->id == $u->id ? 'selected' : ''); ?>>
                                                        <?php echo e($u->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Rol en la emergencia <span class="text-danger">*</span></label>
                                            <input type="text" name="personal[<?php echo e($i); ?>][rol_en_emergencia]"
                                                   class="form-control" value="<?php echo e($p->pivot->rol_en_emergencia); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control"
                                                    onclick="document.getElementById('personal-<?php echo e($i); ?>').remove()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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
                    <h5 class="text-primary">3. Pacientes Atendidos</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPaciente()">
                        <i class="fas fa-plus"></i> Añadir Paciente
                    </button>
                    <div id="pacientes-container">
                        <?php $__currentLoopData = $emergenciaPrehospitalaria->pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3 border-warning" id="paciente-<?php echo e($i); ?>">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-warning">Paciente #<?php echo e($i + 1); ?></strong>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="document.getElementById('paciente-<?php echo e($i); ?>').remove()">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre completo <span class="text-danger">*</span></label>
                                            <input type="text" name="pacientes[<?php echo e($i); ?>][nombre_completo]"
                                                   class="form-control" value="<?php echo e($pac->nombre_completo); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Edad <span class="text-danger">*</span></label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][edad]"
                                                   class="form-control" value="<?php echo e($pac->edad); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Sexo <span class="text-danger">*</span></label>
                                            <select name="pacientes[<?php echo e($i); ?>][sexo]" class="form-control" required>
                                                <option value="M" <?php echo e($pac->sexo == 'M' ? 'selected' : ''); ?>>Masculino</option>
                                                <option value="F" <?php echo e($pac->sexo == 'F' ? 'selected' : ''); ?>>Femenino</option>
                                                <option value="Indefinido" <?php echo e($pac->sexo == 'Indefinido' ? 'selected' : ''); ?>>Indefinido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cédula</label>
                                            <input type="text" name="pacientes[<?php echo e($i); ?>][cedula]"
                                                   class="form-control" value="<?php echo e($pac->cedula); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" name="pacientes[<?php echo e($i); ?>][telefono]"
                                                   class="form-control" value="<?php echo e($pac->telefono); ?>">
                                        </div>
                                    </div>
                                </div>

                                <h6 class="text-primary">Signos Vitales</h6>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>FC (lpm)</label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][frecuencia_cardiaca]"
                                                   class="form-control" value="<?php echo e($pac->frecuencia_cardiaca); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>FR (rpm)</label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][frecuencia_respiratoria]"
                                                   class="form-control" value="<?php echo e($pac->frecuencia_respiratoria); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>SatO₂ (%)</label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][saturacion_oxigeno]"
                                                   class="form-control" value="<?php echo e($pac->saturacion_oxigeno); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Temp (°C)</label>
                                            <input type="number" step="0.1" name="pacientes[<?php echo e($i); ?>][temperatura]"
                                                   class="form-control" value="<?php echo e($pac->temperatura); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TA Sistólica</label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][presion_sistolica]"
                                                   class="form-control" value="<?php echo e($pac->presion_sistolica); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TA Diastólica</label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][presion_diastolica]"
                                                   class="form-control" value="<?php echo e($pac->presion_diastolica); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Glasgow</label>
                                            <input type="number" name="pacientes[<?php echo e($i); ?>][glasgow]"
                                                   class="form-control" min="3" max="15" value="<?php echo e($pac->glasgow); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Condición</label>
                                            <select name="pacientes[<?php echo e($i); ?>][condicion]" class="form-control">
                                                <?php $__currentLoopData = ['Estable','Crítico','Fallecido','Rechaza atención']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($c); ?>" <?php echo e($pac->condicion == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Destino</label>
                                            <select name="pacientes[<?php echo e($i); ?>][destino]" class="form-control">
                                                <option value="">--</option>
                                                <?php $__currentLoopData = ['Trasladado a hospital','Alta en sitio','Fuga','Fallecido en sitio','Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($d); ?>" <?php echo e($pac->destino == $d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Hospital destino</label>
                                            <input type="text" name="pacientes[<?php echo e($i); ?>][hospital_destino]"
                                                   class="form-control" value="<?php echo e($pac->hospital_destino); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Motivo de atención</label>
                                            <textarea name="pacientes[<?php echo e($i); ?>][motivo_atencion]" class="form-control" rows="2"><?php echo e($pac->motivo_atencion); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Evaluación</label>
                                            <textarea name="pacientes[<?php echo e($i); ?>][evaluacion]" class="form-control" rows="2"><?php echo e($pac->evaluacion); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Procedimientos realizados</label>
                                            <textarea name="pacientes[<?php echo e($i); ?>][procedimientos_realizados]" class="form-control" rows="2"><?php echo e($pac->procedimientos_realizados); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea name="pacientes[<?php echo e($i); ?>][observaciones]" class="form-control" rows="2"><?php echo e($pac->observaciones); ?></textarea>
                                        </div>
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
                    <h5 class="text-primary">4. Insumos Utilizados</h5>
                    <div class="alert alert-warning py-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Al guardar se restaurará el stock anterior y se descontará el nuevo.
                    </div>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarInsumo()">
                        <i class="fas fa-plus"></i> Añadir Insumo
                    </button>
                    <div id="insumos-container">
                        <?php $__currentLoopData = $emergenciaPrehospitalaria->insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-2 p-3" id="insumo-<?php echo e($i); ?>">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Insumo <span class="text-danger">*</span></label>
                                            <select name="insumos[<?php echo e($i); ?>][insumo_medico_id]" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                <?php $__currentLoopData = $insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($insumo->id); ?>" <?php echo e($ins->id == $insumo->id ? 'selected' : ''); ?>>
                                                        <?php echo e($insumo->descripcion); ?> (Stock: <?php echo e($insumo->stock); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cantidad <span class="text-danger">*</span></label>
                                            <input type="number" name="insumos[<?php echo e($i); ?>][cantidad]"
                                                   class="form-control" min="1" value="<?php echo e($ins->pivot->cantidad); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <input type="text" name="insumos[<?php echo e($i); ?>][observaciones]"
                                                   class="form-control" value="<?php echo e($ins->pivot->observaciones); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control"
                                                    onclick="document.getElementById('insumo-<?php echo e($i); ?>').remove()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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
                    <div class="form-group">
                        <label>Observaciones Generales</label>
                        <textarea name="observaciones_generales" class="form-control" rows="3"><?php echo e(old('observaciones_generales', $emergenciaPrehospitalaria->observaciones_generales)); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Emergencia
                </button>
                <a href="<?php echo e(route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria)); ?>"
                   class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>


<script>
    let pacienteCount = <?php echo e($emergenciaPrehospitalaria->pacientes->count()); ?>;
    let personalCount = <?php echo e($emergenciaPrehospitalaria->personal->count()); ?>;
    let insumoCount = <?php echo e($emergenciaPrehospitalaria->insumos->count()); ?>;

    // ============ PACIENTES ============
    function agregarPaciente() {
        pacienteCount++;
        const container = document.getElementById('pacientes-container');
        const div = document.createElement('div');
        div.className = 'card mb-2 p-3 border-warning';
        div.id = 'paciente-' + pacienteCount;
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong class="text-warning">Nuevo Paciente</strong>
                <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('paciente-${pacienteCount}').remove()">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="pacientes[${pacienteCount}][nombre_completo]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Edad <span class="text-danger">*</span></label>
                        <input type="number" name="pacientes[${pacienteCount}][edad]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Sexo <span class="text-danger">*</span></label>
                        <select name="pacientes[${pacienteCount}][sexo]" class="form-control" required>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="Indefinido">Indefinido</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cédula</label>
                        <input type="text" name="pacientes[${pacienteCount}][cedula]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="pacientes[${pacienteCount}][telefono]" class="form-control">
                    </div>
                </div>
            </div>
            <h6 class="text-primary">Signos Vitales</h6>
            <div class="row">
                <div class="col-md-2"><div class="form-group"><label>FC</label><input type="number" name="pacientes[${pacienteCount}][frecuencia_cardiaca]" class="form-control"></div></div>
                <div class="col-md-2"><div class="form-group"><label>FR</label><input type="number" name="pacientes[${pacienteCount}][frecuencia_respiratoria]" class="form-control"></div></div>
                <div class="col-md-2"><div class="form-group"><label>SatO₂</label><input type="number" name="pacientes[${pacienteCount}][saturacion_oxigeno]" class="form-control"></div></div>
                <div class="col-md-2"><div class="form-group"><label>Temp</label><input type="number" step="0.1" name="pacientes[${pacienteCount}][temperatura]" class="form-control"></div></div>
                <div class="col-md-2"><div class="form-group"><label>TA Sist.</label><input type="number" name="pacientes[${pacienteCount}][presion_sistolica]" class="form-control"></div></div>
                <div class="col-md-2"><div class="form-group"><label>TA Diast.</label><input type="number" name="pacientes[${pacienteCount}][presion_diastolica]" class="form-control"></div></div>
            </div>
            <div class="row">
                <div class="col-md-2"><div class="form-group"><label>Glasgow</label><input type="number" name="pacientes[${pacienteCount}][glasgow]" class="form-control" min="3" max="15"></div></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Condición</label>
                        <select name="pacientes[${pacienteCount}][condicion]" class="form-control">
                            <option value="Estable">Estable</option>
                            <option value="Crítico">Crítico</option>
                            <option value="Fallecido">Fallecido</option>
                            <option value="Rechaza atención">Rechaza atención</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Destino</label>
                        <select name="pacientes[${pacienteCount}][destino]" class="form-control">
                            <option value="">--</option>
                            <option value="Trasladado a hospital">Trasladado a hospital</option>
                            <option value="Alta en sitio">Alta en sitio</option>
                            <option value="Fuga">Fuga</option>
                            <option value="Fallecido en sitio">Fallecido en sitio</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4"><div class="form-group"><label>Hospital</label><input type="text" name="pacientes[${pacienteCount}][hospital_destino]" class="form-control"></div></div>
            </div>
            <div class="row">
                <div class="col-md-6"><div class="form-group"><label>Motivo</label><textarea name="pacientes[${pacienteCount}][motivo_atencion]" class="form-control" rows="2"></textarea></div></div>
                <div class="col-md-6"><div class="form-group"><label>Evaluación</label><textarea name="pacientes[${pacienteCount}][evaluacion]" class="form-control" rows="2"></textarea></div></div>
            </div>
            <div class="row">
                <div class="col-md-6"><div class="form-group"><label>Procedimientos</label><textarea name="pacientes[${pacienteCount}][procedimientos_realizados]" class="form-control" rows="2"></textarea></div></div>
                <div class="col-md-6"><div class="form-group"><label>Observaciones</label><textarea name="pacientes[${pacienteCount}][observaciones]" class="form-control" rows="2"></textarea></div></div>
            </div>
        `;
        container.appendChild(div);
    }

    // ============ PERSONAL ============
    function agregarPersonal() {
        personalCount++;
        const container = document.getElementById('personal-container');
        const div = document.createElement('div');
        div.className = 'card mb-2 p-3';
        div.id = 'personal-' + personalCount;
        div.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Funcionario <span class="text-danger">*</span></label>
                        <select name="personal[${personalCount}][user_id]" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Rol</label>
                        <input type="text" name="personal[${personalCount}][rol_en_emergencia]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm form-control" onclick="document.getElementById('personal-${personalCount}').remove()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    }

    // ============ INSUMOS ============
    function agregarInsumo() {
        insumoCount++;
        const container = document.getElementById('insumos-container');
        const div = document.createElement('div');
        div.className = 'card mb-2 p-3';
        div.id = 'insumo-' + insumoCount;
        div.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Insumo <span class="text-danger">*</span></label>
                        <select name="insumos[${insumoCount}][insumo_medico_id]" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php $__currentLoopData = $insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insumo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($insumo->id); ?>"><?php echo e($insumo->descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="number" name="insumos[${insumoCount}][cantidad]" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <input type="text" name="insumos[${insumoCount}][observaciones]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm form-control" onclick="document.getElementById('insumo-${insumoCount}').remove()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_prehospitalarias/edit.blade.php ENDPATH**/ ?>