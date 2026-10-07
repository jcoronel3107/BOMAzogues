@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Editar Novedad - NOV-{{ str_pad($novedad->id, 6, '0', STR_PAD_LEFT) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('estacion-novedades.update', $novedad) }}" method="POST" id="formNovedad">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('Y-m-d') : $novedad->fecha) }}" required>
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
                                <option value="{{ $estacion->id }}" {{ old('estacion_id', $novedad->estacion_id) == $estacion->id ? 'selected' : '' }}>
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
                        <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones', $novedad->observaciones) }}</textarea>
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
                        @foreach($novedad->emergencias as $key => $emergencia)
                            <div class="card mb-2 p-3" id="emergencia-{{ $key }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo Emergencia</label>
                                            <select name="emergencias[{{ $key }}][tipo]" class="form-control">
                                                <option value="incendio" {{ $emergencia->tipo_emergencia == 'incendio' ? 'selected' : '' }}>Incendio</option>
                                                <option value="rescate" {{ $emergencia->tipo_emergencia == 'rescate' ? 'selected' : '' }}>Rescate</option>
                                                <option value="inundacion" {{ $emergencia->tipo_emergencia == 'inundacion' ? 'selected' : '' }}>Inundación</option>
                                                <option value="transito" {{ $emergencia->tipo_emergencia == 'transito' ? 'selected' : '' }}>Tránsito</option>
                                                <option value="fuga" {{ $emergencia->tipo_emergencia == 'fuga' ? 'selected' : '' }}>Fuga</option>
                                                <option value="salud" {{ $emergencia->tipo_emergencia == 'salud' ? 'selected' : '' }}>Salud</option>
                                                <option value="otro" {{ $emergencia->tipo_emergencia == 'otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Lugar</label>
                                            <input type="text" name="emergencias[{{ $key }}][lugar]" class="form-control" value="{{ $emergencia->lugar }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hora Ingreso</label>
                                            <input type="time" name="emergencias[{{ $key }}][hora_ingreso]" class="form-control" value="{{ $emergencia->hora_ingreso }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hora Salida</label>
                                            <input type="time" name="emergencias[{{ $key }}][hora_salida]" class="form-control" value="{{ $emergencia->hora_salida }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarEmergencia({{ $key }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea name="emergencias[{{ $key }}][descripcion]" class="form-control" rows="2">{{ $emergencia->descripcion }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                        @foreach($novedad->vehiculos as $key => $vehiculo)
                            <div class="card mb-2 p-3" id="vehiculo-{{ $key }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehículo</label>
                                            <select name="vehiculos[{{ $key }}][vehiculo_id]" class="form-control">
                                                <option value="">Seleccione...</option>
                                                @foreach($vehiculos as $v)
                                                    <option value="{{ $v->id }}" {{ $vehiculo->vehiculo_id == $v->id ? 'selected' : '' }}>{{ $v->placa }} - {{ $v->marca }} {{ $v->modelo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="vehiculos[{{ $key }}][estado]" class="form-control">
                                                <option value="operativo" {{ $vehiculo->estado == 'operativo' ? 'selected' : '' }}>Operativo</option>
                                                <option value="mantenimiento" {{ $vehiculo->estado == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                                <option value="averiado" {{ $vehiculo->estado == 'averiado' ? 'selected' : '' }}>Averiado</option>
                                                <option value="fuera_servicio" {{ $vehiculo->estado == 'fuera_servicio' ? 'selected' : '' }}>Fuera de Servicio</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo Novedad</label>
                                            <input type="text" name="vehiculos[{{ $key }}][tipo_novedad]" class="form-control" value="{{ $vehiculo->tipo_novedad }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarVehiculo({{ $key }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha Reporte</label>
                                            <input type="date" name="vehiculos[{{ $key }}][fecha_reporte]" class="form-control" value="{{ $vehiculo->fecha_reporte instanceof \Carbon\Carbon ? $vehiculo->fecha_reporte->format('Y-m-d') : date('Y-m-d', strtotime($vehiculo->fecha_reporte)) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha Solución</label>
                                            <input type="date" name="vehiculos[{{ $key }}][fecha_solucion]" class="form-control" value="{{ $vehiculo->fecha_solucion ? ($vehiculo->fecha_solucion instanceof \Carbon\Carbon ? $vehiculo->fecha_solucion->format('Y-m-d') : date('Y-m-d', strtotime($vehiculo->fecha_solucion))) : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kilometraje</label>
                                            <input type="number" name="vehiculos[{{ $key }}][kilometraje]" class="form-control" value="{{ $vehiculo->kilometraje }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea name="vehiculos[{{ $key }}][descripcion]" class="form-control" rows="2">{{ $vehiculo->descripcion }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                        @foreach($novedad->personal as $key => $persona)
                            <div class="card mb-2 p-3" id="personal-{{ $key }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Funcionario</label>
                                            <select name="personal[{{ $key }}][user_id]" class="form-control">
                                                <option value="">Seleccione...</option>
                                                @foreach($personal as $p)
                                                    <option value="{{ $p->id }}" {{ $persona->user_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            <input type="text" name="personal[{{ $key }}][cargo]" class="form-control" value="{{ $persona->cargo }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Turno</label>
                                            <select name="personal[{{ $key }}][turno]" class="form-control">
                                                <option value="mañana" {{ $persona->turno == 'mañana' ? 'selected' : '' }}>Mañana</option>
                                                <option value="tarde" {{ $persona->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                                <option value="noche" {{ $persona->turno == 'noche' ? 'selected' : '' }}>Noche</option>
                                                <option value="descanso" {{ $persona->turno == 'descanso' ? 'selected' : '' }}>Descanso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="personal[{{ $key }}][estado]" class="form-control">
                                                <option value="presente" {{ $persona->estado == 'presente' ? 'selected' : '' }}>Presente</option>
                                                <option value="ausente" {{ $persona->estado == 'ausente' ? 'selected' : '' }}>Ausente</option>
                                                <option value="permiso" {{ $persona->estado == 'permiso' ? 'selected' : '' }}>Permiso</option>
                                                <option value="licencia" {{ $persona->estado == 'licencia' ? 'selected' : '' }}>Licencia</option>
                                                <option value="comision" {{ $persona->estado == 'comision' ? 'selected' : '' }}>Comisión</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarPersonal({{ $key }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea name="personal[{{ $key }}][observaciones]" class="form-control" rows="1">{{ $persona->observaciones }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>
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
                                            <input type="date" id="buscar_fecha" class="form-control" value="{{ $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('Y-m-d') : date('Y-m-d', strtotime($novedad->fecha)) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estación</label>
                                            <select id="buscar_estacion" class="form-control">
                                                @foreach($estaciones as $estacion)
                                                    <option value="{{ $estacion->id }}" {{ $novedad->estacion_id == $estacion->id ? 'selected' : '' }}>
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

                {{-- ===== EMERGENCIAS SELECCIONADAS ACTUALMENTE ===== --}}
                <div id="emergencias-asociadas-container" class="mb-2">
                    @foreach($novedad->emergenciasAsociadas as $emergencia)
                        <input type="hidden" name="emergencias_asociadas[]" value="{{ $emergencia->id }}">
                    @endforeach
                </div>

                <div id="prehospitalarias-asociadas-container" class="mb-2">
                    @foreach($novedad->prehospitalariasAsociadas as $emergencia)
                        <input type="hidden" name="prehospitalarias_asociadas[]" value="{{ $emergencia->id }}">
                    @endforeach
                </div>

                <div id="fuego-asociadas-container" class="mb-2">
                    @foreach($novedad->fuegoAsociadas as $emergencia)
                        <input type="hidden" name="fuego_asociadas[]" value="{{ $emergencia->id }}">
                    @endforeach
                </div>

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



            <!-- Integrantes de la Guardia Bomberil -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">Integrantes de la Guardia Bomberil</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarIntegranteGuardia()">
                        <i class="fas fa-plus"></i> Agregar Integrante
                    </button>
                    <div id="integrantes-guardia-container">
                        @if($novedad->integrantes_guardia)
                            @foreach($novedad->integrantes_guardia as $key => $integrante)
                                <div class="card mb-2 p-3" id="integrante-guardia-{{ $key }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nombres y Apellidos</label>
                                                <input type="text" name="integrantes_guardia[{{ $key }}][nombre]" class="form-control" value="{{ $integrante['nombre'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Cédula</label>
                                                <input type="text" name="integrantes_guardia[{{ $key }}][cedula]" class="form-control" value="{{ $integrante['cedula'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Cargo</label>
                                                <select name="integrantes_guardia[{{ $key }}][cargo]" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    <option value="Bombero" {{ ($integrante['cargo'] ?? '') == 'Bombero' ? 'selected' : '' }}>Bombero</option>
                                                    <option value="Teniente" {{ ($integrante['cargo'] ?? '') == 'Teniente' ? 'selected' : '' }}>Teniente</option>
                                                    <option value="Capitán" {{ ($integrante['cargo'] ?? '') == 'Capitán' ? 'selected' : '' }}>Capitán</option>
                                                    <option value="Mayor" {{ ($integrante['cargo'] ?? '') == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                                                    <option value="Comandante" {{ ($integrante['cargo'] ?? '') == 'Comandante' ? 'selected' : '' }}>Comandante</option>
                                                    <option value="Paramédico" {{ ($integrante['cargo'] ?? '') == 'Paramédico' ? 'selected' : '' }}>Paramédico</option>
                                                    <option value="Conductor" {{ ($integrante['cargo'] ?? '') == 'Conductor' ? 'selected' : '' }}>Conductor</option>
                                                    <option value="Operador Radio" {{ ($integrante['cargo'] ?? '') == 'Operador Radio' ? 'selected' : '' }}>Operador Radio</option>
                                                    <option value="Administrativo" {{ ($integrante['cargo'] ?? '') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarIntegranteGuardia({{ $key }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Observaciones del Integrante</label>
                                                <input type="text" name="integrantes_guardia[{{ $key }}][observaciones]" class="form-control" value="{{ $integrante['observaciones'] ?? '' }}" placeholder="Observaciones">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <hr>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Novedad
                </button>
                <a href="{{ route('estacion-novedades.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let emergenciaCount = {{ count($novedad->emergencias) }};
let vehiculoCount = {{ count($novedad->vehiculos) }};
let personalCount = {{ count($novedad->personal) }};
let integranteGuardiaCount = {{ isset($novedad->integrantes_guardia) ? count($novedad->integrantes_guardia) : 0 }};

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
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</option>
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

// ============================================================
//  BUSCAR EMERGENCIAS DEL DÍA (para el edit)
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
    .then(response => response.json())
    .then(data => {
        document.getElementById('total-emergencias').textContent = data.totales.emergencias;
        renderTablaEmergenciasEdit(data.emergencias);

        document.getElementById('total-prehospitalarias').textContent = data.totales.prehospitalarias;
        renderTablaPrehospitalariasEdit(data.prehospitalarias);

        document.getElementById('total-fuego').textContent = data.totales.fuego;
        renderTablaFuegoEdit(data.fuego);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// ============================================================
//  RENDER TABLAS EN EDIT (con checkboxes pre-marcados)
// ============================================================
   function renderTablaEmergenciasEdit(emergencias) {
    const container = document.getElementById('emergencias-table-container');
    if (emergencias.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No se encontraron emergencias.</div>';
        return;
    }

    const asociadas = getIdsAsociados('emergencias_asociadas[]');

    let html = `
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodasEdit(this, 'emergencia')"></th>
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
        const checked = asociadas.includes(e.id.toString()) ? 'checked' : '';
        html += `
            <tr>
                <td>
                    <input type="checkbox" 
                           class="seleccionar-emergencia" 
                           value="${e.id}" 
                           data-tipo="emergencia" 
                           ${checked}
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
        <button type="button" class="btn btn-primary btn-sm" onclick="agregarSeleccionadasEdit('emergencia')">
            <i class="fas fa-plus"></i> Agregar Emergencias Seleccionadas
        </button>
    `;

    container.innerHTML = html;
}

function renderTablaPrehospitalariasEdit(prehospitalarias) 
{
    const container = document.getElementById('prehospitalarias-table-container');
    if (prehospitalarias.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No se encontraron emergencias prehospitalarias.</div>';
        return;
    }

    const asociadas = getIdsAsociados('prehospitalarias_asociadas[]');

    let html = `
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodasEdit(this, 'prehospitalaria')"></th>
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
        const checked = asociadas.includes(e.id.toString()) ? 'checked' : '';
        html += `
            <tr>
                <td>
                    <input type="checkbox" 
                           class="seleccionar-emergencia" 
                           value="${e.id}" 
                           data-tipo="prehospitalaria" 
                           ${checked}
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
        <button type="button" class="btn btn-danger btn-sm" onclick="agregarSeleccionadasEdit('prehospitalaria')">
            <i class="fas fa-plus"></i> Agregar Prehospitalarias Seleccionadas
        </button>
    `;

    container.innerHTML = html;
}

function renderTablaFuegoEdit(fuego) 
{
    const container = document.getElementById('fuego-table-container');
    if (fuego.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No se encontraron emergencias de fuego.</div>';
        return;
    }

    const asociadas = getIdsAsociados('fuego_asociadas[]');

    let html = `
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" onclick="seleccionarTodasEdit(this, 'fuego')"></th>
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
        const checked = asociadas.includes(e.id.toString()) ? 'checked' : '';
        html += `
            <tr>
                <td>
                    <input type="checkbox" 
                           class="seleccionar-emergencia" 
                           value="${e.id}" 
                           data-tipo="fuego" 
                           ${checked}
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
        <button type="button" class="btn btn-warning btn-sm" onclick="agregarSeleccionadasEdit('fuego')">
            <i class="fas fa-plus"></i> Agregar Emergencias de Fuego Seleccionadas
        </button>
    `;

    container.innerHTML = html;
}

    // ============================================================
    //  HELPERS
    // ============================================================
    function getIdsAsociados(inputName) {
        const inputs = document.querySelectorAll(`input[name="${inputName}"]`);
        return Array.from(inputs).map(inp => inp.value);
    }

    function seleccionarTodasEdit(checkbox, tipo) {
        const checkboxes = document.querySelectorAll(`.seleccionar-emergencia[data-tipo="${tipo}"]`);
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    function agregarSeleccionadasEdit(tipo) {
        const seleccionadas = document.querySelectorAll(`.seleccionar-emergencia[data-tipo="${tipo}"]:checked`);

        if (seleccionadas.length === 0) {
            alert('Por favor, seleccione al menos una emergencia.');
            return;
        }

        let containerId = '';
        let inputName = '';

        switch (tipo) {
            case 'emergencia':
                containerId = 'emergencias-asociadas-container';
                inputName = 'emergencias_asociadas[]';
                break;
            case 'prehospitalaria':
                containerId = 'prehospitalarias-asociadas-container';
                inputName = 'prehospitalarias_asociadas[]';
                break;
            case 'fuego':
                containerId = 'fuego-asociadas-container';
                inputName = 'fuego_asociadas[]';
                break;
        }

        const container = document.getElementById(containerId);

        seleccionadas.forEach(cb => {
            const id = cb.value;
            if (container.querySelector(`input[value="${id}"]`)) return;

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = inputName;
            hidden.value = id;
            container.appendChild(hidden);

            cb.checked = false;
        });

        alert(`✅ ${seleccionadas.length} emergencia(s) agregada(s).`);
    }

    // ============================================================
//  TOGGLE ASOCIADA (agrega o elimina el input hidden)
// ============================================================
function toggleAsociada(checkbox, inputName, containerId) 
{
    const id = checkbox.value;
    const container = document.getElementById(containerId);

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