@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Novedad de Estación</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('estacion-novedades.store') }}" method="POST" id="formNovedad">
            @csrf

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
                    <h5 class="text-primary">Personal</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Agregar Personal
                    </button>
                    <div id="personal-container">
                        <!-- Se agregarán dinámicamente -->
                    </div>
                </div>
            </div>

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
</script>
@endsection