

<?php $__env->startSection('cuerpo'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Novedad de Estación</h6>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('estacion-novedades.store')); ?>" method="POST" id="formNovedad">
            <?php echo csrf_field(); ?>

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
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('fecha', date('Y-m-d'))); ?>" required>
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
                                <option value="<?php echo e($estacion->id); ?>" <?php echo e(old('estacion_id') == $estacion->id ? 'selected' : ''); ?>>
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
                        <textarea name="observaciones" class="form-control" rows="2"><?php echo e(old('observaciones')); ?></textarea>
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
                        <!-- Se agregarán dinámicamente -->
                    </div>
                </div>
            </div>

            <hr>

            <!-- Novedades de Vehículos -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Novedades de Vehículos</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                        <i class="fas fa-plus"></i> Agregar Novedad de Vehículo
                    </button>
                    <div id="vehiculos-container">
                        <!-- Se agregarán dinámicamente -->
                    </div>
                </div>
            </div>

            <hr>

            <!-- Personal -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary"> Agregar Novedades del Personal</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Agregar Novedades del Personal
                    </button>
                    <div id="personal-container">
                        <!-- Se agregarán dinámicamente -->
                    </div>
                </div>
            </div>
            <hr>
            <h5 class="text-primary">Emergencias de la Estación</h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="date" id="buscar_fecha" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estación</label>
                                        <select id="buscar_estacion" class="form-control">
                                            <?php $__currentLoopData = $estaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($estacion->id); ?>" <?php echo e(old('estacion_id') == $estacion->id ? 'selected' : ''); ?>>
                                                    <?php echo e($estacion->nombre); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-info btn-block" onclick="buscarEmergencias()">
                                            <i class="fas fa-search"></i> Buscar Emergencias
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div id="emergencias-listado" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-list"></i> Emergencias Encontradas
                    <span id="total-emergencias" class="badge badge-light float-right">0</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="emergencias-table-container">
                        <!-- Se llenará con JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <hr>
            <h5 class="text-primary">Integrantes de la Guardia Bomberil</h5>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarIntegranteGuardia()">
                        <i class="fas fa-plus"></i> Agregar Integrante
                    </button>
                    <div id="integrantes-guardia-container">
                        <!-- Se agregarán dinámicamente -->
                    </div>
                </div>
            </div>




            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Novedad
                </button>
                <a href="<?php echo e(route('estacion-novedades.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let emergenciaCount = 0;
    let vehiculoCount = 0;
    let personalCount = 0;

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

    let integranteGuardiaCount = 0;

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
                    <label>Nombres y Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="integrantes_guardia[${integranteGuardiaCount}][nombre]" class="form-control" placeholder="Nombre completo">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Cédula</label>
                    <input type="text" name="integrantes_guardia[${integranteGuardiaCount}][cedula]" class="form-control" placeholder="Cédula">
                </div>
            </div>
            <div class="col-md-3">
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
<script>
function buscarEmergencias() {
    const fecha = document.getElementById('buscar_fecha').value;
    const estacionId = document.getElementById('buscar_estacion').value;
    
    if (!fecha || !estacionId) {
        alert('Por favor, seleccione fecha y estación.');
        return;
    }
    
    // Mostrar loading
    const container = document.getElementById('emergencias-table-container');
    container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Cargando emergencias...</p></div>';
    document.getElementById('emergencias-listado').style.display = 'block';
    
    // Realizar la petición AJAX
    //fetch(`<?php echo e(route('estacion-novedades.buscar-emergencias')); ?>?fecha=${fecha}&estacion_id=${estacionId}`)
    //fetch(`/estacion-novedades/buscar-emergencias-json?fecha=${fecha}&estacion_id=${estacionId}`)
    fetch(`/test-buscar?fecha=${fecha}&estacion_id=${estacionId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-emergencias').textContent = data.total;
            
            if (data.total === 0) {
                container.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> No se encontraron emergencias en esta fecha y estación.</div>';
                return;
            }
            
            let html = `
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="seleccionar-todas" onchange="seleccionarTodas(this)"></th>
                            <th>ID</th>
                            <th>Incidente</th>
                            <th>Hora Salida</th>
                            <th>Hora Llegada</th>
                            <th>Personal</th>
                            <th>Vehículos</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            data.emergencias.forEach(emergencia => {
                const personalCount = emergencia.usuarios ? emergencia.usuarios.length : 0;
                const vehiculosCount = emergencia.vehiculos ? emergencia.vehiculos.length : 0;
                
                html += `
                    <tr>
                        <td><input type="checkbox" class="seleccionar-emergencia" value="${emergencia.id}" data-incidente="${emergencia.tipo_incidente.nombre_incidente || ''}" data-hora-salida="${emergencia.hora_salida_emergencia}" data-hora-llegada="${emergencia.hora_llegada_emergencia}" data-personal="${personalCount}" data-vehiculos="${vehiculosCount}" data-detalle="${emergencia.detalle_emergencia || ''}"></td>
                        <td>${emergencia.id}</td>
                        <td>${emergencia.tipo_incidente ? emergencia.tipo_incidente.nombre_incidente : 'N/A'}</td>
                        <td>${emergencia.hora_salida_emergencia}</td>
                        <td>${emergencia.hora_llegada_emergencia}</td>
                        <td>${personalCount}</td>
                        <td>${vehiculosCount}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" onclick="verDetalleEmergencia(${emergencia.id})" title="Ver detalle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                    </tbody>
                </table>
                <div class="mt-2">
                    <button type="button" class="btn btn-success btn-sm" onclick="agregarEmergenciasSeleccionadas()">
                        <i class="fas fa-plus"></i> Agregar Emergencias Seleccionadas
                    </button>
                </div>
            `;
            
            container.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Error al cargar las emergencias.</div>';
        });
}

function seleccionarTodas(checkbox) {
    document.querySelectorAll('.seleccionar-emergencia').forEach(cb => {
        cb.checked = checkbox.checked;
    });
}

function agregarEmergenciasSeleccionadas() {
    const seleccionadas = document.querySelectorAll('.seleccionar-emergencia:checked');
    
    if (seleccionadas.length === 0) {
        alert('Por favor, seleccione al menos una emergencia.');
        return;
    }
    
    const container = document.getElementById('emergencias-container');
    let count = document.querySelectorAll('#emergencias-container .card').length;
    
    seleccionadas.forEach(cb => {
        const id = cb.value;
        const incidente = cb.dataset.incidente || 'Sin incidente';
        const horaSalida = cb.dataset.horaSalida || 'N/A';
        const horaLlegada = cb.dataset.horaLlegada || 'N/A';
        const personal = cb.dataset.personal || 0;
        const vehiculos = cb.dataset.vehiculos || 0;
        const detalle = cb.dataset.detalle || '';
        
        count++;
        const div = document.createElement('div');
        div.className = 'card mb-2 p-3';
        div.id = 'emergencia-seleccionada-' + count;
        div.innerHTML = `
            <div class="row">
                <div class="col-md-8">
                    <input type="hidden" name="emergencias[${count}][id]" value="${id}">
                    <input type="hidden" name="emergencias[${count}][tipo]" value="${incidente}">
                    <input type="hidden" name="emergencias[${count}][hora_ingreso]" value="${horaSalida}">
                    <input type="hidden" name="emergencias[${count}][hora_salida]" value="${horaLlegada}">
                    <strong>${incidente}</strong>
                    <br>
                    <small>Hora Salida: ${horaSalida} | Hora Llegada: ${horaLlegada} | Personal: ${personal} | Vehículos: ${vehiculos}</small>
                    <br>
                    <small class="text-muted">${detalle.substring(0, 100)}${detalle.length > 100 ? '...' : ''}</small>
                </div>
                <div class="col-md-4 text-right">
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarEmergenciaSeleccionada(${count})">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        `;
        container.appendChild(div);
        
        // Desmarcar checkbox
        cb.checked = false;
    });
    
    // Desmarcar el checkbox de "seleccionar todas"
    const selectAll = document.getElementById('seleccionar-todas');
    if (selectAll) selectAll.checked = false;
    
    // Mostrar mensaje
    alert(`✅ ${seleccionadas.length} emergencia(s) agregada(s) correctamente.`);
}

function eliminarEmergenciaSeleccionada(id) {
    const element = document.getElementById('emergencia-seleccionada-' + id);
    if (element) {
        element.remove();
    }
}

function verDetalleEmergencia(id) {
    // Aquí puedes abrir un modal o redirigir a la vista de detalle
    window.open(`/emergencias/${id}`, '_blank');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/estacion_novedades/create.blade.php ENDPATH**/ ?>