@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Emergencia de Fuego</h6>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('emergencias-fuego.store') }}" method="POST" id="formEmergencia">
            @csrf

            {{-- ===== SECCIÓN 1: DATOS GENERALES ===== --}}
            <h5 class="text-primary mb-3">1. Datos Generales</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha/Hora Salida <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_salida" class="form-control" required
                               value="{{ old('fecha_salida', now()->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada al sitio</label>
                        <input type="datetime-local" name="fecha_llegada_sitio" class="form-control"
                               value="{{ old('fecha_llegada_sitio') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Control del fuego</label>
                        <input type="datetime-local" name="fecha_control" class="form-control"
                               value="{{ old('fecha_control') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Extinción total</label>
                        <input type="datetime-local" name="fecha_extincion" class="form-control"
                               value="{{ old('fecha_extincion') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada a base</label>
                        <input type="datetime-local" name="fecha_llegada_base" class="form-control"
                               value="{{ old('fecha_llegada_base') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Dirección <span class="text-danger">*</span></label>
                        <input type="text" name="direccion" class="form-control" required
                               value="{{ old('direccion') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencia" class="form-control"
                               value="{{ old('referencia') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Parroquia</label>
                        <select name="parroquia_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($parroquias as $par)
                                <option value="{{ $par->id }}" {{ old('parroquia_id') == $par->id ? 'selected' : '' }}>
                                    {{ $par->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sector</label>
                        <input type="text" name="sector" class="form-control"
                               value="{{ old('sector') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Motivo del llamado <span class="text-danger">*</span></label>
                        <input type="text" name="motivo_llamado" class="form-control" required
                               value="{{ old('motivo_llamado') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo de fuego <span class="text-danger">*</span></label>
                        <select name="tipo_fuego" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($tipos as $t)
                                <option value="{{ $t }}" {{ old('tipo_fuego') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nivel de riesgo <span class="text-danger">*</span></label>
                        <select name="nivel_riesgo" class="form-control" required>
                            @foreach($niveles as $n)
                                <option value="{{ $n }}" {{ old('nivel_riesgo', 'Medio') == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Causa probable</label>
                        <input type="text" name="causa_probable" class="form-control"
                               placeholder="Eléctrica, Intencional, Negligencia..."
                               value="{{ old('causa_probable') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Área afectada (m²)</label>
                        <input type="number" step="0.01" name="area_afectada_m2" class="form-control"
                               value="{{ old('area_afectada_m2') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Pérdidas estimadas</label>
                        <input type="number" step="0.01" name="perdidas_estimadas" class="form-control"
                               value="{{ old('perdidas_estimadas') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Moneda</label>
                        <input type="text" name="moneda" class="form-control" value="{{ old('moneda', 'USD') }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 2: RECURSOS UTILIZADOS ===== --}}
            <h5 class="text-primary mb-3">2. Recursos Utilizados</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Agua utilizada (litros)</label>
                        <input type="number" step="0.01" name="agua_utilizada_litros" class="form-control"
                               value="{{ old('agua_utilizada_litros') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Espuma utilizada (litros)</label>
                        <input type="number" step="0.01" name="espuma_utilizada_litros" class="form-control"
                               value="{{ old('espuma_utilizada_litros') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Químico utilizado (litros)</label>
                        <input type="number" step="0.01" name="quimico_utilizado_litros" class="form-control"
                               value="{{ old('quimico_utilizado_litros') }}">
                    </div>
                </div>
            </div>

            {{-- ===== HERRAMIENTAS UTILIZADAS ===== --}}
            <h6 class="text-secondary mt-3 mb-2">
                <i class="fas fa-tools"></i> Herramientas Utilizadas
            </h6>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarHerramienta()">
                        <i class="fas fa-plus"></i> Añadir Herramienta
                    </button>
                    <div id="herramientas-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 3: VÍCTIMAS ===== --}}
            <h5 class="text-primary mb-3">3. Víctimas</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Ilesos</label>
                        <input type="number" name="victimas_ilesos" class="form-control" min="0"
                               value="{{ old('victimas_ilesos', 0) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Heridos</label>
                        <input type="number" name="victimas_heridos" class="form-control" min="0"
                               value="{{ old('victimas_heridos', 0) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fallecidos</label>
                        <input type="number" name="victimas_fallecidos" class="form-control" min="0"
                               value="{{ old('victimas_fallecidos', 0) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="apoyoExterno"
                                   name="requirio_apoyo_externo" value="1"
                                   {{ old('requirio_apoyo_externo') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="apoyoExterno">Requirió apoyo externo</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Detalle del apoyo externo</label>
                        <input type="text" name="detalle_apoyo" class="form-control"
                               placeholder="Otros cuerpos de bomberos, policía, etc."
                               value="{{ old('detalle_apoyo') }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 4: PERSONAL ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">4. Personal que Atiende <span class="text-danger">*</span></h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Añadir Personal
                    </button>
                    <div id="personal-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 5: VEHÍCULOS ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">5. Vehículos Utilizados <span class="text-danger">*</span></h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                        <i class="fas fa-plus"></i> Añadir Vehículo
                    </button>
                    <div id="vehiculos-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 6: PACIENTES ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">6. Pacientes / Víctimas Atendidas (opcional)</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPaciente()">
                        <i class="fas fa-plus"></i> Añadir Paciente
                    </button>
                    <div id="pacientes-container"></div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 7: INSUMOS ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">7. Insumos Utilizados</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarInsumo()">
                        <i class="fas fa-plus"></i> Añadir Insumo
                    </button>
                    <div id="insumos-container"></div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones Generales</label>
                        <textarea name="observaciones_generales" class="form-control" rows="3">{{ old('observaciones_generales') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Emergencia
                </button>
                <a href="{{ route('emergencias-fuego.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let personalCount = 0;
let vehiculoCount = 0;
let pacienteCount = 0;
let insumoCount = 0;
let herramientaCount = 0;

const personalOptions = `@foreach($personal as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach`;
const vehiculosOptions = `@foreach($vehiculos as $v)<option value="{{ $v->id }}">{{ $v->placa }} - {{ $v->marca ?? '' }}</option>@endforeach`;
const insumosOptions = `@foreach($insumos as $i)<option value="{{ $i->id }}">{{ $i->descripcion }}</option>@endforeach`;
const herramientasOptions = `@foreach($herramientas as $h)<option value="{{ $h->id }}">{{ $h->descripcion }} {{ $h->codigo ? '(' . $h->codigo . ')' : '' }}</option>@endforeach`;

// ===== PERSONAL =====
function agregarPersonal() {
    personalCount++;
    const html = `
    <div class="row personal-row mb-2" id="personal-${personalCount}">
        <div class="col-md-5">
            <select name="personal[${personalCount}][user_id]" class="form-control" required>
                <option value="">Seleccione usuario...</option>
                ${personalOptions}
            </select>
        </div>
        <div class="col-md-5">
            <input type="text" name="personal[${personalCount}][rol_en_emergencia]" class="form-control" 
                   placeholder="Rol (Bombero, Conductor, Jefe de Incidente...)" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('personal-${personalCount}').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    document.getElementById('personal-container').insertAdjacentHTML('beforeend', html);
}

// ===== VEHÍCULOS =====
function agregarVehiculo() {
    vehiculoCount++;
    const html = `
    <div class="card mb-2 p-3" id="vehiculo-${vehiculoCount}">
        <div class="row">
            <div class="col-md-4">
                <label class="small font-weight-bold">Vehículo <span class="text-danger">*</span></label>
                <select name="vehiculos[${vehiculoCount}][vehiculo_id]" class="form-control" required>
                    <option value="">Seleccione...</option>
                    ${vehiculosOptions}
                </select>
            </div>
            <div class="col-md-3">
                <label class="small font-weight-bold">Rol</label>
                <input type="text" name="vehiculos[${vehiculoCount}][rol_en_emergencia]" 
                       class="form-control" placeholder="Bomberos, Cisterna...">
            </div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Km Salida</label>
                <input type="number" name="vehiculos[${vehiculoCount}][km_salida]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Km Llegada</label>
                <input type="number" name="vehiculos[${vehiculoCount}][km_llegada]" class="form-control">
            </div>
            <div class="col-md-1">
                <label class="small font-weight-bold">&nbsp;</label>
                <button type="button" class="btn btn-danger form-control" onclick="document.getElementById('vehiculo-${vehiculoCount}').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>`;
    document.getElementById('vehiculos-container').insertAdjacentHTML('beforeend', html);
}

// ===== PACIENTES =====
function agregarPaciente() {
    pacienteCount++;
    const html = `
    <div class="card mb-2 p-3 border-warning" id="paciente-${pacienteCount}">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="text-warning">Paciente #${pacienteCount}</strong>
            <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('paciente-${pacienteCount}').remove()">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="small font-weight-bold">Nombre completo</label>
                <input type="text" name="pacientes[${pacienteCount}][nombre_completo]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Edad</label>
                <input type="number" name="pacientes[${pacienteCount}][edad]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Sexo</label>
                <select name="pacientes[${pacienteCount}][sexo]" class="form-control">
                    <option value="Indefinido">Indefinido</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Cédula</label>
                <input type="text" name="pacientes[${pacienteCount}][cedula]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="small font-weight-bold">Teléfono</label>
                <input type="text" name="pacientes[${pacienteCount}][telefono]" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <label class="small font-weight-bold">Condición</label>
                <select name="pacientes[${pacienteCount}][condicion]" class="form-control">
                    <option value="Ileso">Ileso</option>
                    <option value="Herido">Herido</option>
                    <option value="Fallecido">Fallecido</option>
                    <option value="Desconocido">Desconocido</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="small font-weight-bold">Tipo de lesión</label>
                <input type="text" name="pacientes[${pacienteCount}][tipo_lesion]" class="form-control" placeholder="Quemadura, inhalación...">
            </div>
            <div class="col-md-5">
                <label class="small font-weight-bold">Hospital destino</label>
                <input type="text" name="pacientes[${pacienteCount}][hospital_destino]" class="form-control">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2"><label class="small">FC</label><input type="number" name="pacientes[${pacienteCount}][frecuencia_cardiaca]" class="form-control"></div>
            <div class="col-md-2"><label class="small">FR</label><input type="number" name="pacientes[${pacienteCount}][frecuencia_respiratoria]" class="form-control"></div>
            <div class="col-md-2"><label class="small">SatO₂</label><input type="number" name="pacientes[${pacienteCount}][saturacion_oxigeno]" class="form-control"></div>
            <div class="col-md-2"><label class="small">Temp</label><input type="number" step="0.1" name="pacientes[${pacienteCount}][temperatura]" class="form-control"></div>
            <div class="col-md-4"><label class="small">Observaciones</label><input type="text" name="pacientes[${pacienteCount}][observaciones]" class="form-control"></div>
        </div>
    </div>`;
    document.getElementById('pacientes-container').insertAdjacentHTML('beforeend', html);
}

// ===== INSUMOS =====
function agregarInsumo() {
    insumoCount++;
    const html = `
    <div class="row insumo-row mb-2" id="insumo-${insumoCount}">
        <div class="col-md-5">
            <select name="insumos[${insumoCount}][insumo_medico_id]" class="form-control" required>
                <option value="">Seleccione insumo...</option>
                ${insumosOptions}
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="insumos[${insumoCount}][cantidad]" class="form-control" placeholder="Cantidad" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="insumos[${insumoCount}][observaciones]" class="form-control" placeholder="Observaciones">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('insumo-${insumoCount}').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    document.getElementById('insumos-container').insertAdjacentHTML('beforeend', html);
}

// ===== HERRAMIENTAS =====
function agregarHerramienta() {
    herramientaCount++;
    const html = `
    <div class="row herramienta-row mb-2" id="herramienta-${herramientaCount}">
        <div class="col-md-5">
            <select name="herramientas[${herramientaCount}][herramienta_id]" class="form-control">
                <option value="">Seleccione herramienta...</option>
                ${herramientasOptions}
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="herramientas[${herramientaCount}][cantidad]" class="form-control" 
                   placeholder="Cantidad" value="1" min="1">
        </div>
        <div class="col-md-3">
            <input type="text" name="herramientas[${herramientaCount}][observaciones]" class="form-control" 
                   placeholder="Observaciones">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" onclick="document.getElementById('herramienta-${herramientaCount}').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>`;
    document.getElementById('herramientas-container').insertAdjacentHTML('beforeend', html);
}

// Agregar 1 al cargar
document.addEventListener('DOMContentLoaded', function() {
    agregarPersonal();
    agregarVehiculo();
});
</script>
@endsection