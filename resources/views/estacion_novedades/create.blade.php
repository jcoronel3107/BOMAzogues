@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Novedad de Estación</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('estacion-novedades.store') }}" method="POST" id="formNovedad">
            @csrf

            {{-- ===== DATOS GENERALES ===== --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
                        @error('fecha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estación <span class="text-danger">*</span></label>
                        <select name="estacion_id" class="form-control @error('estacion_id') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach($estaciones as $estacion)
                                <option value="{{ $estacion->id }}" {{ old('estacion_id') == $estacion->id ? 'selected' : '' }}>
                                    {{ $estacion->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('estacion_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones Generales</label>
                        <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== EMERGENCIAS MANUALES ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Emergencias Atendidas (Manual)</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarEmergencia()">
                        <i class="fas fa-plus"></i> Agregar Emergencia
                    </button>
                    <div id="emergencias-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== NOVEDADES DE VEHÍCULOS ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Novedades de Vehículos</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                        <i class="fas fa-plus"></i> Agregar Novedad de Vehículo
                    </button>
                    <div id="vehiculos-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== NOVEDADES DEL PERSONAL ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Novedades del Personal</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Agregar Novedad del Personal
                    </button>
                    <div id="personal-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== EMERGENCIAS DEL DÍA (BÚSQUEDA) ===== --}}
            <h5 class="text-primary">Emergencias del Día</h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="date" id="buscar_fecha" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estación</label>
                                        <select id="buscar_estacion" class="form-control">
                                            @foreach($estaciones as $estacion)
                                                <option value="{{ $estacion->id }}" {{ old('estacion_id') == $estacion->id ? 'selected' : '' }}>
                                                    {{ $estacion->nombre }}
                                                </option>
                                            @endforeach
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

            {{-- ===== CONTENEDORES DE EMERGENCIAS SELECCIONADAS ===== --}}
            <div id="emergencias-asociadas-container" class="mb-2"></div>
            <div id="prehospitalarias-asociadas-container" class="mb-2"></div>
            <div id="fuego-asociadas-container" class="mb-2"></div>

            {{-- ===== RESULTADOS DE LA BÚSQUEDA ===== --}}
            <div id="emergencias-listado" style="display: none;">

                {{-- SECCIÓN 1: EMERGENCIAS (MÓDULO GENERAL) --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-ambulance"></i> Emergencias (Módulo General)
                                <span id="total-emergencias" class="badge badge-light float-right">0</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="emergencias-table-container"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN 2: EMERGENCIAS PREHOSPITALARIAS --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header bg-danger text-white">
                                <i class="fas fa-ambulance"></i> Emergencias Prehospitalarias
                                <span id="total-prehospitalarias" class="badge badge-light float-right">0</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="prehospitalarias-table-container"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN 3: EMERGENCIAS DE FUEGO --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header bg-warning text-dark">
                                <i class="fas fa-fire"></i> Emergencias de Fuego
                                <span id="total-fuego" class="badge badge-dark float-right">0</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="fuego-table-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== INTEGRANTES DE GUARDIA ===== --}}
            <h5 class="text-primary">Integrantes de la Guardia Bomberil</h5>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarIntegranteGuardia()">
                        <i class="fas fa-plus"></i> Agregar Integrante
                    </button>
                    <div id="integrantes-guardia-container"></div>
                </div>
            </div>

            {{-- ===== BOTONES ===== --}}
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Novedad
                </button>
                <a href="{{ route('estacion-novedades.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// ============================================================
//  VARIABLES GLOBALES
// ============================================================
let emergenciaCount = 0;
let vehiculoCount = 0;
let personalCount = 0;
let integranteGuardiaCount = 0;

// ============================================================
//  AGREGAR EMERGENCIA MANUAL
// ============================================================
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

// ============================================================
//  AGREGAR VEHÍCULO
// ============================================================
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
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->codigodis }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</option>
                        @endforeach
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
                    <input type="date" name="vehiculos[${vehiculoCount}][fecha_reporte]" class="form-control" value="{{ date('Y-m-d') }}">
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

// ============================================================
//  AGREGAR PERSONAL
// ============================================================
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
                        @foreach($personal as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->name }}</option>
                        @endforeach
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

// ============================================================
//  AGREGAR INTEGRANTE DE GUARDIA
// ============================================================
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

// ============================================================
//  BUSCAR EMERGENCIAS DEL DÍA
// ============================================================
function buscarEmergencias() {
    const fecha = document.getElementById('buscar_fecha').value;
    const estacionId = document.getElementById('buscar_estacion').value;

    if (!fecha || !estacionId) {
        alert('Por favor, seleccione fecha y estación.');
        return;
    }

    document.getElementById('emergencias-table-container').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Cargando...</p></div>';
    document.getElementById('prehospitalarias-table-container').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Cargando...</p></div>';
    document.getElementById('fuego-table-container').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Cargando...</p></div>';
    document.getElementById('emergencias-listado').style.display = 'block';

    fetch(`/novedades/buscar-emergencias?fecha=${fecha}&estacion_id=${estacionId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('total-emergencias').textContent = data.totales.emergencias;
        renderTablaEmergencias(data.emergencias);

        document.getElementById('total-prehospitalarias').textContent = data.totales.prehospitalarias;
        renderTablaPrehospitalarias(data.prehospitalarias);

        document.getElementById('total-fuego').textContent = data.totales.fuego;
        renderTablaFuego(data.fuego);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('emergencias-table-container').innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        document.getElementById('prehospitalarias-table-container').innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        document.getElementById('fuego-table-container').innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
    });
}

// ============================================================
//  RENDER TABLA EMERGENCIAS
// ============================================================
function renderTablaEmergencias(emergencias) {
    const container = document.getElementById('emergencias-table-container');

    if (emergencias.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No se encontraron emergencias.</div>';
        return;
    }

    let html = `
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodas(this, 'emergencia')"></th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Hora Salida</th>
                    <th>Hora Llegada</th>
                    <th>Personal</th>
                    <th>Vehículos</th>
                </tr>
            </thead>
            <tbody>
    `;

    emergencias.forEach(e => {
        html += `
            <tr>
                <td>
                    <input type="checkbox" 
                           class="seleccionar-emergencia" 
                           value="${e.id}" 
                           data-tipo="emergencia"
                           onchange="toggleAsociada(this, 'emergencias_asociadas[]', 'emergencias-asociadas-container')">
                </td>
                <td>${e.codigo}</td>
                <td>${e.tipo}</td>
                <td>${e.hora_salida || '—'}</td>
                <td>${e.hora_llegada || '—'}</td>
                <td>${e.personal}</td>
                <td>${e.vehiculos}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
}

// ============================================================
//  RENDER TABLA PREHOSPITALARIAS
// ============================================================
function renderTablaPrehospitalarias(prehospitalarias) {
    const container = document.getElementById('prehospitalarias-table-container');

    if (prehospitalarias.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No se encontraron emergencias prehospitalarias.</div>';
        return;
    }

    let html = `
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodas(this, 'prehospitalaria')"></th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Prioridad</th>
                    <th>Hora Salida</th>
                    <th>Hora Llegada</th>
                    <th>Pacientes</th>
                    <th>Personal</th>
                </tr>
            </thead>
            <tbody>
    `;

    prehospitalarias.forEach(e => {
        html += `
            <tr>
                <td>
                    <input type="checkbox" 
                           class="seleccionar-emergencia" 
                           value="${e.id}" 
                           data-tipo="prehospitalaria"
                           onchange="toggleAsociada(this, 'prehospitalarias_asociadas[]', 'prehospitalarias-asociadas-container')">
                </td>
                <td>${e.codigo}</td>
                <td>${e.tipo}</td>
                <td><span class="badge badge-secondary">${e.prioridad || '—'}</span></td>
                <td>${e.hora_salida || '—'}</td>
                <td>${e.hora_llegada || '—'}</td>
                <td>${e.pacientes}</td>
                <td>${e.personal}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
}

// ============================================================
//  RENDER TABLA FUEGO
// ============================================================
function renderTablaFuego(fuego) {
    const container = document.getElementById('fuego-table-container');

    if (fuego.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No se encontraron emergencias de fuego.</div>';
        return;
    }

    let html = `
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodas(this, 'fuego')"></th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Riesgo</th>
                    <th>Hora Salida</th>
                    <th>Hora Llegada</th>
                    <th>Pacientes</th>
                    <th>Personal</th>
                </tr>
            </thead>
            <tbody>
    `;

    fuego.forEach(e => {
        html += `
            <tr>
                <td>
                    <input type="checkbox" 
                           class="seleccionar-emergencia" 
                           value="${e.id}" 
                           data-tipo="fuego"
                           onchange="toggleAsociada(this, 'fuego_asociadas[]', 'fuego-asociadas-container')">
                </td>
                <td>${e.codigo}</td>
                <td>${e.tipo}</td>
                <td><span class="badge badge-warning">${e.nivel_riesgo || '—'}</span></td>
                <td>${e.hora_salida || '—'}</td>
                <td>${e.hora_llegada || '—'}</td>
                <td>${e.pacientes}</td>
                <td>${e.personal}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
}

// ============================================================
//  SELECCIONAR TODAS
// ============================================================
function seleccionarTodas(checkbox, tipo) {
    const checkboxes = document.querySelectorAll(`.seleccionar-emergencia[data-tipo="${tipo}"]`);
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
        // Disparar el evento change para que se agregue/elimine el input hidden
        cb.dispatchEvent(new Event('change'));
    });
}

// ============================================================
//  TOGGLE ASOCIADA (agrega o elimina el input hidden)
// ============================================================
function toggleAsociada(checkbox, inputName, containerId) {
    const id = checkbox.value;
    let container = document.getElementById(containerId);

    // Si el contenedor no existe, crearlo
    if (!container) {
        const div = document.createElement('div');
        div.id = containerId;
        div.className = 'mb-2';
        document.getElementById('formNovedad').appendChild(div);
        container = div;
    }

    if (checkbox.checked) {
        // Agregar el input hidden si no existe
        if (!container.querySelector(`input[value="${id}"]`)) {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = inputName;
            hidden.value = id;
            container.appendChild(hidden);
        }
    } else {
        // Eliminar el input hidden si existe
        const existing = container.querySelector(`input[value="${id}"]`);
        if (existing) {
            existing.remove();
        }
    }
}
</script>
@endsection