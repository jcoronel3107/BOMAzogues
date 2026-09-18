@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Editar Emergencia Prehospitalaria — {{ $emergenciaPrehospitalaria->codigo }}
        </h6>
        <a href="{{ route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria) }}"
           class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al detalle
        </a>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Por favor corrige los siguientes errores:</strong>
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

        <form action="{{ route('emergencias-prehospitalarias.update', $emergenciaPrehospitalaria) }}"
              method="POST" id="formEmergencia">
            @csrf
            @method('PUT')

            {{-- ===== SECCIÓN 1: DATOS GENERALES ===== --}}
            <h5 class="text-primary mb-3">1. Datos Generales</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha/Hora Salida <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_salida" class="form-control" required
                               value="{{ old('fecha_salida', $emergenciaPrehospitalaria->fecha_salida?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada al sitio</label>
                        <input type="datetime-local" name="fecha_llegada_sitio" class="form-control"
                               value="{{ old('fecha_llegada_sitio', $emergenciaPrehospitalaria->fecha_llegada_sitio?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Salida del sitio</label>
                        <input type="datetime-local" name="fecha_salida_sitio" class="form-control"
                               value="{{ old('fecha_salida_sitio', $emergenciaPrehospitalaria->fecha_salida_sitio?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada a base</label>
                        <input type="datetime-local" name="fecha_llegada_base" class="form-control"
                               value="{{ old('fecha_llegada_base', $emergenciaPrehospitalaria->fecha_llegada_base?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección <span class="text-danger">*</span></label>
                        <input type="text" name="direccion" class="form-control" required
                               value="{{ old('direccion', $emergenciaPrehospitalaria->direccion) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencia" class="form-control"
                               value="{{ old('referencia', $emergenciaPrehospitalaria->referencia) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Prioridad <span class="text-danger">*</span></label>
                        <select name="prioridad" class="form-control" required>
                            @foreach(['Rojo','Naranja','Amarillo','Verde','Azul'] as $p)
                                <option value="{{ $p }}"
                                    {{ old('prioridad', $emergenciaPrehospitalaria->prioridad) == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Motivo del llamado <span class="text-danger">*</span></label>
                        <input type="text" name="motivo_llamado" class="form-control" required
                               value="{{ old('motivo_llamado', $emergenciaPrehospitalaria->motivo_llamado) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo de Emergencia <span class="text-danger">*</span></label>
                        <select name="tipo_emergencia" class="form-control" required>
                            @foreach(['Accidente de tránsito','Emergencia médica','Trauma','Obstétrica','Pediatrica','Psiquiatrica','Otra'] as $t)
                                <option value="{{ $t }}"
                                    {{ old('tipo_emergencia', $emergenciaPrehospitalaria->tipo_emergencia) == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Vehículo (Ambulancia) <span class="text-danger">*</span></label>
                        <select name="vehiculo_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($vehiculos as $v)
                                <option value="{{ $v->id }}"
                                    {{ old('vehiculo_id', $emergenciaPrehospitalaria->vehiculo_id) == $v->id ? 'selected' : '' }}>
                                    {{ $v->placa }} - {{ $v->marca }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-control" required>
                            @foreach(['En curso','Finalizada','Cancelada','Derivada'] as $e)
                                <option value="{{ $e }}"
                                    {{ old('estado', $emergenciaPrehospitalaria->estado) == $e ? 'selected' : '' }}>
                                    {{ $e }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 2: PERSONAL ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">2. Personal que Atiende</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Añadir Personal
                    </button>
                    <div id="personal-container">
                        @foreach($emergenciaPrehospitalaria->personal as $i => $p)
                            <div class="card mb-2 p-3" id="personal-{{ $i }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Funcionario <span class="text-danger">*</span></label>
                                            <select name="personal[{{ $i }}][user_id]" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($personal as $u)
                                                    <option value="{{ $u->id }}" {{ $p->id == $u->id ? 'selected' : '' }}>
                                                        {{ $u->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Rol en la emergencia <span class="text-danger">*</span></label>
                                            <input type="text" name="personal[{{ $i }}][rol_en_emergencia]"
                                                   class="form-control" value="{{ $p->pivot->rol_en_emergencia }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control"
                                                    onclick="document.getElementById('personal-{{ $i }}').remove()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 3: PACIENTES ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">3. Pacientes Atendidos</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPaciente()">
                        <i class="fas fa-plus"></i> Añadir Paciente
                    </button>
                    <div id="pacientes-container">
                        @foreach($emergenciaPrehospitalaria->pacientes as $i => $pac)
                            <div class="card mb-2 p-3 border-warning" id="paciente-{{ $i }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-warning">Paciente #{{ $i + 1 }}</strong>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="document.getElementById('paciente-{{ $i }}').remove()">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre completo <span class="text-danger">*</span></label>
                                            <input type="text" name="pacientes[{{ $i }}][nombre_completo]"
                                                   class="form-control" value="{{ $pac->nombre_completo }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Edad <span class="text-danger">*</span></label>
                                            <input type="number" name="pacientes[{{ $i }}][edad]"
                                                   class="form-control" value="{{ $pac->edad }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Sexo <span class="text-danger">*</span></label>
                                            <select name="pacientes[{{ $i }}][sexo]" class="form-control" required>
                                                <option value="M" {{ $pac->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                                                <option value="F" {{ $pac->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
                                                <option value="Indefinido" {{ $pac->sexo == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cédula</label>
                                            <input type="text" name="pacientes[{{ $i }}][cedula]"
                                                   class="form-control" value="{{ $pac->cedula }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" name="pacientes[{{ $i }}][telefono]"
                                                   class="form-control" value="{{ $pac->telefono }}">
                                        </div>
                                    </div>
                                </div>

                                <h6 class="text-primary">Signos Vitales</h6>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>FC (lpm)</label>
                                            <input type="number" name="pacientes[{{ $i }}][frecuencia_cardiaca]"
                                                   class="form-control" value="{{ $pac->frecuencia_cardiaca }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>FR (rpm)</label>
                                            <input type="number" name="pacientes[{{ $i }}][frecuencia_respiratoria]"
                                                   class="form-control" value="{{ $pac->frecuencia_respiratoria }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>SatO₂ (%)</label>
                                            <input type="number" name="pacientes[{{ $i }}][saturacion_oxigeno]"
                                                   class="form-control" value="{{ $pac->saturacion_oxigeno }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Temp (°C)</label>
                                            <input type="number" step="0.1" name="pacientes[{{ $i }}][temperatura]"
                                                   class="form-control" value="{{ $pac->temperatura }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TA Sistólica</label>
                                            <input type="number" name="pacientes[{{ $i }}][presion_sistolica]"
                                                   class="form-control" value="{{ $pac->presion_sistolica }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TA Diastólica</label>
                                            <input type="number" name="pacientes[{{ $i }}][presion_diastolica]"
                                                   class="form-control" value="{{ $pac->presion_diastolica }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Glasgow</label>
                                            <input type="number" name="pacientes[{{ $i }}][glasgow]"
                                                   class="form-control" min="3" max="15" value="{{ $pac->glasgow }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Condición</label>
                                            <select name="pacientes[{{ $i }}][condicion]" class="form-control">
                                                @foreach(['Estable','Crítico','Fallecido','Rechaza atención'] as $c)
                                                    <option value="{{ $c }}" {{ $pac->condicion == $c ? 'selected' : '' }}>{{ $c }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Destino</label>
                                            <select name="pacientes[{{ $i }}][destino]" class="form-control">
                                                <option value="">--</option>
                                                @foreach(['Trasladado a hospital','Alta en sitio','Fuga','Fallecido en sitio','Otro'] as $d)
                                                    <option value="{{ $d }}" {{ $pac->destino == $d ? 'selected' : '' }}>{{ $d }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Hospital destino</label>
                                            <input type="text" name="pacientes[{{ $i }}][hospital_destino]"
                                                   class="form-control" value="{{ $pac->hospital_destino }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Motivo de atención</label>
                                            <textarea name="pacientes[{{ $i }}][motivo_atencion]" class="form-control" rows="2">{{ $pac->motivo_atencion }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Evaluación</label>
                                            <textarea name="pacientes[{{ $i }}][evaluacion]" class="form-control" rows="2">{{ $pac->evaluacion }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Procedimientos realizados</label>
                                            <textarea name="pacientes[{{ $i }}][procedimientos_realizados]" class="form-control" rows="2">{{ $pac->procedimientos_realizados }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea name="pacientes[{{ $i }}][observaciones]" class="form-control" rows="2">{{ $pac->observaciones }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 4: INSUMOS ===== --}}
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
                        @foreach($emergenciaPrehospitalaria->insumos as $i => $ins)
                            <div class="card mb-2 p-3" id="insumo-{{ $i }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Insumo <span class="text-danger">*</span></label>
                                            <select name="insumos[{{ $i }}][insumo_medico_id]" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($insumos as $insumo)
                                                    <option value="{{ $insumo->id }}" {{ $ins->id == $insumo->id ? 'selected' : '' }}>
                                                        {{ $insumo->descripcion  }} (Stock: {{ $insumo->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cantidad <span class="text-danger">*</span></label>
                                            <input type="number" name="insumos[{{ $i }}][cantidad]"
                                                   class="form-control" min="1" value="{{ $ins->pivot->cantidad }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <input type="text" name="insumos[{{ $i }}][observaciones]"
                                                   class="form-control" value="{{ $ins->pivot->observaciones }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control"
                                                    onclick="document.getElementById('insumo-{{ $i }}').remove()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
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
                        <textarea name="observaciones_generales" class="form-control" rows="3">{{ old('observaciones_generales', $emergenciaPrehospitalaria->observaciones_generales) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Emergencia
                </button>
                <a href="{{ route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria) }}"
                   class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

{{-- ====== SCRIPTS ====== --}}
<script>
    let pacienteCount = {{ $emergenciaPrehospitalaria->pacientes->count() }};
    let personalCount = {{ $emergenciaPrehospitalaria->personal->count() }};
    let insumoCount = {{ $emergenciaPrehospitalaria->insumos->count() }};

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
                            @foreach($personal as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
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
                            @foreach($insumos as $insumo)
                                <option value="{{ $insumo->id }}">{{ $insumo->descripcion  }}</option>
                            @endforeach
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
            <hr>

            {{-- ===== SECCIÓN: ARCHIVOS ADJUNTOS ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">
                        <i class="fas fa-paperclip"></i> Archivos Adjuntos
                        <span class="badge badge-info">{{ $emergenciaPrehospitalaria->archivos->count() }}</span>
                    </h5>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        La gestión de archivos se realiza desde la vista de detalle:
                        <a href="{{ route('emergencias-prehospitalarias.show', $emergenciaPrehospitalaria) }}"
                        class="alert-link" target="_blank">
                            Ver detalle
                        </a>
                    </div>
                </div>
            </div>
</div>
        `;
        container.appendChild(div);
    }
</script>
@endsection