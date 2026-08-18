@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Movilización</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('movilizaciones.store') }}" method="POST" id="formMovilizacion">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha de Salida <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_salida" class="form-control @error('fecha_salida') is-invalid @enderror" value="{{ old('fecha_salida', date('Y-m-d')) }}" required>
                        @error('fecha_salida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hora de Salida <span class="text-danger">*</span></label>
                        <input type="time" name="hora_salida" class="form-control @error('hora_salida') is-invalid @enderror" value="{{ old('hora_salida', date('H:i')) }}" required>
                        @error('hora_salida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Motivo <span class="text-danger">*</span></label>
                        <input type="text" name="motivo" class="form-control @error('motivo') is-invalid @enderror" value="{{ old('motivo') }}" required>
                        @error('motivo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lugar de Origen <span class="text-danger">*</span></label>
                        <input type="text" name="lugar_origen" class="form-control @error('lugar_origen') is-invalid @enderror" value="{{ old('lugar_origen') }}" required>
                        @error('lugar_origen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Destino <span class="text-danger">*</span></label>
                        <input type="text" name="destino" class="form-control @error('destino') is-invalid @enderror" value="{{ old('destino') }}" required>
                        @error('destino')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Datos del Conductor</h5>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Nombres y Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="conductor_nombres" class="form-control @error('conductor_nombres') is-invalid @enderror" value="{{ old('conductor_nombres') }}" required>
                        @error('conductor_nombres')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cédula <span class="text-danger">*</span></label>
                        <input type="text" name="conductor_cedula" class="form-control @error('conductor_cedula') is-invalid @enderror" value="{{ old('conductor_cedula') }}" required>
                        @error('conductor_cedula')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cargo</label>
                        <input type="text" name="conductor_cargo" class="form-control @error('conductor_cargo') is-invalid @enderror" value="{{ old('conductor_cargo') }}">
                        @error('conductor_cargo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Datos del Vehículo</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Marca <span class="text-danger">*</span></label>
                        <input type="text" name="vehiculo_marca" class="form-control @error('vehiculo_marca') is-invalid @enderror" value="{{ old('vehiculo_marca') }}" required>
                        @error('vehiculo_marca')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Placas <span class="text-danger">*</span></label>
                        <input type="text" name="vehiculo_placa" class="form-control @error('vehiculo_placa') is-invalid @enderror" value="{{ old('vehiculo_placa') }}" required>
                        @error('vehiculo_placa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>KM de Salida <span class="text-danger">*</span></label>
                        <input type="number" name="km_salida" class="form-control @error('km_salida') is-invalid @enderror" value="{{ old('km_salida') }}" required min="0">
                        @error('km_salida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Vehículo en Sistema <span class="text-danger">*</span></label>
                        <select name="vehiculo_id" class="form-control @error('vehiculo_id') is-invalid @enderror" required>
                            <option value="">Seleccione Vehículo...</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                    {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehiculo_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Conductor Asignado</h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Conductor <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                            <option value="">Seleccione Conductor...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} - {{ $usuario->cargo ?? 'Bombero' }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Integrantes de la Comisión</h5>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarIntegrante()">
                        <i class="fas fa-plus"></i> Agregar Integrante
                    </button>
                    <div id="integrantes-container">
                        <!-- Se agregarán dinámicamente -->
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="2">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Movilización
                </button>
                <a href="{{ route('movilizaciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let integranteCount = 0;

function agregarIntegrante() {
    integranteCount++;
    const container = document.getElementById('integrantes-container');
    const div = document.createElement('div');
    div.className = 'card mb-2 p-3';
    div.id = 'integrante-' + integranteCount;
    div.innerHTML = `
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Nombres y Apellidos</label>
                    <input type="text" name="integrantes[${integranteCount}][nombre]" class="form-control" placeholder="Nombre completo">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Cédula</label>
                    <input type="text" name="integrantes[${integranteCount}][cedula]" class="form-control" placeholder="Cédula">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Cargo</label>
                    <input type="text" name="integrantes[${integranteCount}][cargo]" class="form-control" placeholder="Cargo">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarIntegrante(${integranteCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function eliminarIntegrante(id) {
    const element = document.getElementById('integrante-' + id);
    if (element) element.remove();
}
</script>
@endsection