@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Emergencia</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('emergencias.store') }}" method="POST" id="formEmergencia">
            @csrf

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                        <i class="fas fa-info-circle"></i> Información Emergencia
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">
                        <i class="fas fa-users"></i> Personal en Emergencia
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="vehiculos-tab" data-toggle="tab" href="#vehiculos" role="tab" aria-controls="vehiculos" aria-selected="false">
                        <i class="fas fa-truck"></i> Vehículos
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-4" id="myTabContent">
                <!-- Pestaña 1: Información Emergencia -->
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
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
                                <label>Hora Salida a Emergencia <span class="text-danger">*</span></label>
                                <input type="time" name="hora_salida_emergencia" class="form-control @error('hora_salida_emergencia') is-invalid @enderror" value="{{ old('hora_salida_emergencia', date('H:i')) }}" required>
                                @error('hora_salida_emergencia')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hora Llegada a Emergencia <span class="text-danger">*</span></label>
                                <input type="time" name="hora_llegada_emergencia" class="form-control @error('hora_llegada_emergencia') is-invalid @enderror" value="{{ old('hora_llegada_emergencia') }}" required>
                                @error('hora_llegada_emergencia')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hora en Base <span class="text-danger">*</span></label>
                                <input type="time" name="hora_en_base" class="form-control @error('hora_en_base') is-invalid @enderror" value="{{ old('hora_en_base') }}" required>
                                @error('hora_en_base')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Incidente <span class="text-danger">*</span></label>
                                <select name="tipo_incidente_id" class="form-control @error('tipo_incidente_id') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($incidentes as $incidente)
                                        <option value="{{ $incidente->id }}" {{ old('tipo_incidente_id') == $incidente->id ? 'selected' : '' }}>
                                            {{ $incidente->nombre_incidente }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_incidente_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subcategoría</label>
                                <input type="text" name="subcategoria" class="form-control @error('subcategoria') is-invalid @enderror" value="{{ old('subcategoria') }}" placeholder="Ej: Estructural, Vehicular, etc.">
                                @error('subcategoria')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ciudadano Afectado</label>
                                <input type="text" name="ciudadano_afectado" class="form-control @error('ciudadano_afectado') is-invalid @enderror" value="{{ old('ciudadano_afectado') }}" placeholder="Nombre del ciudadano afectado">
                                @error('ciudadano_afectado')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Información Inicial <span class="text-danger">*</span></label>
                                <textarea name="informacion_inicial" class="form-control @error('informacion_inicial') is-invalid @enderror" rows="2" required>{{ old('informacion_inicial') }}</textarea>
                                @error('informacion_inicial')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Detalle de la Emergencia <span class="text-danger">*</span></label>
                                <textarea name="detalle_emergencia" class="form-control @error('detalle_emergencia') is-invalid @enderror" rows="3" required>{{ old('detalle_emergencia') }}</textarea>
                                @error('detalle_emergencia')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Daños Estimados</label>
                                <input type="text" name="danos_estimados" class="form-control @error('danos_estimados') is-invalid @enderror" value="{{ old('danos_estimados') }}" placeholder="Ej: $10,000, Daños estructurales, etc.">
                                @error('danos_estimados')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña 2: Personal en Emergencia -->
                <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Personal que Asiste a la Emergencia</label>
                                <select name="usuarios[]" class="form-control select2" multiple style="width: 100%;">
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ old('usuarios') && in_array($usuario->id, old('usuarios')) ? 'selected' : '' }}>
                                            {{ $usuario->name }} - {{ $usuario->cargo ?? 'Bombero' }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén presionada la tecla Ctrl para seleccionar múltiples usuarios.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña 3: Vehículos -->
                <div class="tab-pane fade" id="vehiculos" role="tabpanel" aria-labelledby="vehiculos-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                                <i class="fas fa-plus"></i> Agregar Vehículo
                            </button>
                            <div id="vehiculos-container">
                                <!-- Se agregarán dinámicamente -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Emergencia
                </button>
                <a href="{{ route('emergencias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let vehiculoCount = 0;

function agregarVehiculo() {
    vehiculoCount++;
    const container = document.getElementById('vehiculos-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 p-3';
    div.id = 'vehiculo-' + vehiculoCount;
    div.innerHTML = `
        <div class="row">
            <div class="col-md-3">
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
                    <label>Conductor</label>
                    <select name="vehiculos[${vehiculoCount}][conductor_id]" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>KM Salida</label>
                    <input type="number" name="vehiculos[${vehiculoCount}][km_salida]" class="form-control" placeholder="KM">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>KM Retorno</label>
                    <input type="number" name="vehiculos[${vehiculoCount}][km_retorno]" class="form-control" placeholder="KM">
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
    `;
    container.appendChild(div);
}

function eliminarVehiculo(id) {
    const element = document.getElementById('vehiculo-' + id);
    if (element) element.remove();
}
</script>

<!-- Select2 para mejor selección múltiple -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Seleccione el personal...",
        allowClear: true
    });
});
</script>
@endsection