@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Editar Emergencia de Fuego — {{ $emergenciaFuego->codigo }}
        </h6>
        <a href="{{ route('emergencias-fuego.show', $emergenciaFuego) }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al detalle
        </a>
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

        <form action="{{ route('emergencias-fuego.update', $emergenciaFuego) }}" method="POST" id="formEmergencia">
            @csrf
            @method('PUT')

            {{-- ===== SECCIÓN 1: DATOS GENERALES ===== --}}
            <h5 class="text-primary mb-3">1. Datos Generales</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha/Hora Salida <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_salida" class="form-control" required
                               value="{{ old('fecha_salida', $emergenciaFuego->fecha_salida?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada al sitio</label>
                        <input type="datetime-local" name="fecha_llegada_sitio" class="form-control"
                               value="{{ old('fecha_llegada_sitio', $emergenciaFuego->fecha_llegada_sitio?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Control del fuego</label>
                        <input type="datetime-local" name="fecha_control" class="form-control"
                               value="{{ old('fecha_control', $emergenciaFuego->fecha_control?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Extinción total</label>
                        <input type="datetime-local" name="fecha_extincion" class="form-control"
                               value="{{ old('fecha_extincion', $emergenciaFuego->fecha_extincion?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada a base</label>
                        <input type="datetime-local" name="fecha_llegada_base" class="form-control"
                               value="{{ old('fecha_llegada_base', $emergenciaFuego->fecha_llegada_base?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Dirección <span class="text-danger">*</span></label>
                        <input type="text" name="direccion" class="form-control" required
                               value="{{ old('direccion', $emergenciaFuego->direccion) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencia" class="form-control"
                               value="{{ old('referencia', $emergenciaFuego->referencia) }}">
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
                                <option value="{{ $par->id }}" {{ old('parroquia_id', $emergenciaFuego->parroquia_id) == $par->id ? 'selected' : '' }}>
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
                               value="{{ old('sector', $emergenciaFuego->sector) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Motivo del llamado <span class="text-danger">*</span></label>
                        <input type="text" name="motivo_llamado" class="form-control" required
                               value="{{ old('motivo_llamado', $emergenciaFuego->motivo_llamado) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo de fuego <span class="text-danger">*</span></label>
                        <select name="tipo_fuego" class="form-control" required>
                            @foreach($tipos as $t)
                                <option value="{{ $t }}" {{ old('tipo_fuego', $emergenciaFuego->tipo_fuego) == $t ? 'selected' : '' }}>{{ $t }}</option>
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
                                <option value="{{ $n }}" {{ old('nivel_riesgo', $emergenciaFuego->nivel_riesgo) == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-control" required>
                            @foreach($estados as $e)
                                <option value="{{ $e }}" {{ old('estado', $emergenciaFuego->estado) == $e ? 'selected' : '' }}>{{ $e }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Causa probable</label>
                        <input type="text" name="causa_probable" class="form-control"
                               value="{{ old('causa_probable', $emergenciaFuego->causa_probable) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Área afectada (m²)</label>
                        <input type="number" step="0.01" name="area_afectada_m2" class="form-control"
                               value="{{ old('area_afectada_m2', $emergenciaFuego->area_afectada_m2) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pérdidas estimadas</label>
                        <input type="number" step="0.01" name="perdidas_estimadas" class="form-control"
                               value="{{ old('perdidas_estimadas', $emergenciaFuego->perdidas_estimadas) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Agua utilizada (litros)</label>
                        <input type="number" step="0.01" name="agua_utilizada_litros" class="form-control"
                               value="{{ old('agua_utilizada_litros', $emergenciaFuego->agua_utilizada_litros) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Espuma utilizada (litros)</label>
                        <input type="number" step="0.01" name="espuma_utilizada_litros" class="form-control"
                               value="{{ old('espuma_utilizada_litros', $emergenciaFuego->espuma_utilizada_litros) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Químico utilizado (litros)</label>
                        <input type="number" step="0.01" name="quimico_utilizado_litros" class="form-control"
                               value="{{ old('quimico_utilizado_litros', $emergenciaFuego->quimico_utilizado_litros) }}">
                    </div>
                </div>
            </div>

            {{-- ===== HERRAMIENTAS UTILIZADAS ===== --}}
            <h6 class="text-secondary mt-3 mb-2">
                <i class="fas fa-tools"></i> Herramientas Utilizadas
            </h6>
            <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarHerramienta()">
                <i class="fas fa-plus"></i> Añadir Herramienta
            </button>

            <div id="herramientas-container">
                @foreach($emergenciaFuego->herramientas as $i => $herr)
                    <div class="row herramienta-row mb-2" id="herramienta-existente-{{ $i }}">
                        <div class="col-md-5">
                            <select name="herramientas[{{ $i }}][herramienta_id]" class="form-control">
                                <option value="">Seleccione herramienta...</option>
                                @foreach($herramientas as $h)
                                    <option value="{{ $h->id }}" {{ $herr->id == $h->id ? 'selected' : '' }}>
                                        {{ $h->descripcion }} {{ $h->codigo ? '(' . $h->codigo . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="herramientas[{{ $i }}][cantidad]" class="form-control" 
                                   value="{{ $herr->pivot->cantidad }}" min="1">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="herramientas[{{ $i }}][observaciones]" class="form-control" 
                                   value="{{ $herr->pivot->observaciones }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger" onclick="document.getElementById('herramienta-existente-{{ $i }}').remove()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ilesos</label>
                        <input type="number" name="victimas_ilesos" class="form-control" min="0"
                               value="{{ old('victimas_ilesos', $emergenciaFuego->victimas_ilesos ?? 0) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Heridos</label>
                        <input type="number" name="victimas_heridos" class="form-control" min="0"
                               value="{{ old('victimas_heridos', $emergenciaFuego->victimas_heridos ?? 0) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fallecidos</label>
                        <input type="number" name="victimas_fallecidos" class="form-control" min="0"
                               value="{{ old('victimas_fallecidos', $emergenciaFuego->victimas_fallecidos ?? 0) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="apoyoExterno"
                                   name="requirio_apoyo_externo" value="1"
                                   {{ old('requirio_apoyo_externo', $emergenciaFuego->requirio_apoyo_externo) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="apoyoExterno">Requirió apoyo externo</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Detalle del apoyo</label>
                        <input type="text" name="detalle_apoyo" class="form-control"
                               value="{{ old('detalle_apoyo', $emergenciaFuego->detalle_apoyo) }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 2: PERSONAL ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">2. Personal que Atiende <span class="text-danger">*</span></h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Añadir Personal
                    </button>
                    <div id="personal-container">
                        @foreach($emergenciaFuego->personal as $i => $p)
                            <div class="row personal-row mb-2" id="personal-existente-{{ $i }}">
                                <div class="col-md-5">
                                    <select name="personal[{{ $i }}][user_id]" class="form-control" required>
                                        <option value="">Seleccione usuario...</option>
                                        @foreach($personal as $u)
                                            <option value="{{ $u->id }}" {{ $p->id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="personal[{{ $i }}][rol_en_emergencia]" class="form-control"
                                           value="{{ $p->pivot->rol_en_emergencia }}" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('personal-existente-{{ $i }}').remove()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 3: VEHÍCULOS ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">3. Vehículos Utilizados <span class="text-danger">*</span></h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarVehiculo()">
                        <i class="fas fa-plus"></i> Añadir Vehículo
                    </button>
                    <div id="vehiculos-container">
                        @foreach($emergenciaFuego->vehiculos as $i => $v)
                            <div class="card mb-2 p-3" id="vehiculo-existente-{{ $i }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">Vehículo</label>
                                        <select name="vehiculos[{{ $i }}][vehiculo_id]" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($vehiculos as $veh)
                                                <option value="{{ $veh->id }}" {{ $v->id == $veh->id ? 'selected' : '' }}>
                                                    {{ $veh->placa }} - {{ $veh->marca ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small font-weight-bold">Rol</label>
                                        <input type="text" name="vehiculos[{{ $i }}][rol_en_emergencia]" class="form-control"
                                               value="{{ $v->pivot->rol_en_emergencia }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Km Salida</label>
                                        <input type="number" name="vehiculos[{{ $i }}][km_salida]" class="form-control"
                                               value="{{ $v->pivot->km_salida }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Km Llegada</label>
                                        <input type="number" name="vehiculos[{{ $i }}][km_llegada]" class="form-control"
                                               value="{{ $v->pivot->km_llegada }}">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="small font-weight-bold">&nbsp;</label>
                                        <button type="button" class="btn btn-danger form-control" onclick="document.getElementById('vehiculo-existente-{{ $i }}').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 4: PACIENTES ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">4. Pacientes / Víctimas</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPaciente()">
                        <i class="fas fa-plus"></i> Añadir Paciente
                    </button>
                    <div id="pacientes-container">
                        @foreach($emergenciaFuego->pacientes as $i => $pac)
                            <div class="card mb-2 p-3 border-warning" id="paciente-existente-{{ $i }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-warning">Paciente #{{ $i + 1 }}</strong>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('paciente-existente-{{ $i }}').remove()">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">Nombre completo</label>
                                        <input type="text" name="pacientes[{{ $i }}][nombre_completo]" class="form-control"
                                               value="{{ $pac->nombre_completo }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Edad</label>
                                        <input type="number" name="pacientes[{{ $i }}][edad]" class="form-control" value="{{ $pac->edad }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Sexo</label>
                                        <select name="pacientes[{{ $i }}][sexo]" class="form-control">
                                            @foreach(['Indefinido','M','F'] as $s)
                                                <option value="{{ $s }}" {{ $pac->sexo == $s ? 'selected' : '' }}>{{ $s }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Cédula</label>
                                        <input type="text" name="pacientes[{{ $i }}][cedula]" class="form-control" value="{{ $pac->cedula }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">Teléfono</label>
                                        <input type="text" name="pacientes[{{ $i }}][telefono]" class="form-control" value="{{ $pac->telefono }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label class="small font-weight-bold">Condición</label>
                                        <select name="pacientes[{{ $i }}][condicion]" class="form-control">
                                            @foreach(['Ileso','Herido','Fallecido','Desconocido'] as $c)
                                                <option value="{{ $c }}" {{ $pac->condicion == $c ? 'selected' : '' }}>{{ $c }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">Tipo de lesión</label>
                                        <input type="text" name="pacientes[{{ $i }}][tipo_lesion]" class="form-control" value="{{ $pac->tipo_lesion }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="small font-weight-bold">Hospital destino</label>
                                        <input type="text" name="pacientes[{{ $i }}][hospital_destino]" class="form-control" value="{{ $pac->hospital_destino }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2"><label class="small">FC</label><input type="number" name="pacientes[{{ $i }}][frecuencia_cardiaca]" class="form-control" value="{{ $pac->frecuencia_cardiaca }}"></div>
                                    <div class="col-md-2"><label class="small">FR</label><input type="number" name="pacientes[{{ $i }}][frecuencia_respiratoria]" class="form-control" value="{{ $pac->frecuencia_respiratoria }}"></div>
                                    <div class="col-md-2"><label class="small">SatO₂</label><input type="number" name="pacientes[{{ $i }}][saturacion_oxigeno]" class="form-control" value="{{ $pac->saturacion_oxigeno }}"></div>
                                    <div class="col-md-2"><label class="small">Temp</label><input type="number" step="0.1" name="pacientes[{{ $i }}][temperatura]" class="form-control" value="{{ $pac->temperatura }}"></div>
                                    <div class="col-md-4"><label class="small">Observaciones</label><input type="text" name="pacientes[{{ $i }}][observaciones]" class="form-control" value="{{ $pac->observaciones }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 5: INSUMOS ===== --}}
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
                        @foreach($emergenciaFuego->insumos as $i => $ins)
                            <div class="row insumo-row mb-2" id="insumo-existente-{{ $i }}">
                                <div class="col-md-5">
                                    <select name="insumos[{{ $i }}][insumo_medico_id]" class="form-control" required>
                                        <option value="">Seleccione insumo...</option>
                                        @foreach($insumos as $insumo)
                                            <option value="{{ $insumo->id }}" {{ $ins->id == $insumo->id ? 'selected' : '' }}>
                                                {{ $insumo->descripcion }} (Stock: {{ $insumo->cantidad }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="0.01" name="insumos[{{ $i }}][cantidad]" class="form-control"
                                           value="{{ $ins->pivot->cantidad }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="insumos[{{ $i }}][observaciones]" class="form-control" value="{{ $ins->pivot->observaciones }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('insumo-existente-{{ $i }}').remove()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Observaciones Generales</label>
                        <textarea name="observaciones_generales" class="form-control" rows="3">{{ old('observaciones_generales', $emergenciaFuego->observaciones_generales) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Emergencia
                </button>
                <a href="{{ route('emergencias-fuego.show', $emergenciaFuego) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let personalCount = {{ $emergenciaFuego->personal->count() }};
let vehiculoCount = {{ $emergenciaFuego->vehiculos->count() }};
let pacienteCount = {{ $emergenciaFuego->pacientes->count() }};
let insumoCount = {{ $emergenciaFuego->insumos->count() }};
let herramientaCount = {{ $emergenciaFuego->herramientas->count() }};

const personalOptions = `@foreach($personal as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach`;
const vehiculosOptions = `@foreach($vehiculos as $v)<option value="{{ $v->id }}">{{ $v->placa }} - {{ $v->marca ?? '' }}</option>@endforeach`;
const insumosOptions = `@foreach($insumos as $i)<option value="{{ $i->id }}">{{ $i->descripcion }}</option>@endforeach`;
const herramientasOptions = `@foreach($herramientas as $h)<option value="{{ $h->id }}">{{ $h->descripcion }} {{ $h->codigo ? '(' . $h->codigo . ')' : '' }}</option>@endforeach`;

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
@endsection