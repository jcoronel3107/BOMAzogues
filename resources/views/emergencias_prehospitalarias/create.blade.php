@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Emergencia Prehospitalaria</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('emergencias-prehospitalarias.store') }}" method="POST" id="formEmergencia">
            @csrf

            {{-- ===== SECCIÓN 1: DATOS GENERALES ===== --}}
            <h5 class="text-primary mb-3">1. Datos Generales</h5>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fecha/Hora Salida <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="fecha_salida"
                               class="form-control @error('fecha_salida') is-invalid @enderror"
                               value="{{ old('fecha_salida', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_salida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada al sitio</label>
                        <input type="datetime-local" name="fecha_llegada_sitio"
                               class="form-control" value="{{ old('fecha_llegada_sitio') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Salida del sitio</label>
                        <input type="datetime-local" name="fecha_salida_sitio"
                               class="form-control" value="{{ old('fecha_salida_sitio') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Llegada a base</label>
                        <input type="datetime-local" name="fecha_llegada_base"
                               class="form-control" value="{{ old('fecha_llegada_base') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección <span class="text-danger">*</span></label>
                        <input type="text" name="direccion"
                               class="form-control @error('direccion') is-invalid @enderror"
                               value="{{ old('direccion') }}" required>
                        @error('direccion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencia" class="form-control"
                               value="{{ old('referencia') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Prioridad <span class="text-danger">*</span></label>
                        <select name="prioridad" class="form-control @error('prioridad') is-invalid @enderror" required>
                            <option value="Rojo" {{ old('prioridad') == 'Rojo' ? 'selected' : '' }}>🔴 Rojo</option>
                            <option value="Naranja" {{ old('prioridad') == 'Naranja' ? 'selected' : '' }}>🟠 Naranja</option>
                            <option value="Amarillo" {{ old('prioridad', 'Amarillo') == 'Amarillo' ? 'selected' : '' }}>🟡 Amarillo</option>
                            <option value="Verde" {{ old('prioridad') == 'Verde' ? 'selected' : '' }}>🟢 Verde</option>
                            <option value="Azul" {{ old('prioridad') == 'Azul' ? 'selected' : '' }}>🔵 Azul</option>
                        </select>
                        @error('prioridad')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Motivo del llamado <span class="text-danger">*</span></label>
                        <input type="text" name="motivo_llamado"
                               class="form-control @error('motivo_llamado') is-invalid @enderror"
                               value="{{ old('motivo_llamado') }}" required>
                        @error('motivo_llamado')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo de Emergencia <span class="text-danger">*</span></label>
                        <select name="tipo_emergencia" class="form-control @error('tipo_emergencia') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach(['Accidente de tránsito','Emergencia médica','Trauma','Obstétrica','Pediatrica','Psiquiatrica','Otra'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo_emergencia') == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_emergencia')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Vehículo (Ambulancia) <span class="text-danger">*</span></label>
                        <select name="vehiculo_id" class="form-control @error('vehiculo_id') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach($vehiculos as $v)
                                <option value="{{ $v->id }}" {{ old('vehiculo_id') == $v->id ? 'selected' : '' }}>
                                    {{ $v->placa }} - {{ $v->marca ?? '' }} {{ $v->modelo ?? '' }}
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

            {{-- ===== SECCIÓN 2: PERSONAL QUE ATIENDE ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">2. Personal que Atiende</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarPersonal()">
                        <i class="fas fa-plus"></i> Añadir Personal
                    </button>
                    <div id="personal-container">
                        {{-- Se agregan dinámicamente --}}
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
                        {{-- Se agregan dinámicamente --}}
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== SECCIÓN 4: INSUMOS ===== --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-primary">4. Insumos Utilizados</h5>
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarInsumo()">
                        <i class="fas fa-plus"></i> Añadir Insumo
                    </button>
                    <div id="insumos-container">
                        {{-- Se agregan dinámicamente --}}
                    </div>
                </div>
            </div>

            <hr>

            {{-- ===== OBSERVACIONES GENERALES ===== --}}
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
                <a href="{{ route('emergencias-prehospitalarias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Nota:</strong> Después de guardar la emergencia podrás adjuntar archivos (fotos, documentos, etc.)
                desde la vista de detalle.
            </div>
        </form>
    </div>
</div>

{{-- ====== SCRIPTS DINÁMICOS ====== --}}
<script>
    let pacienteCount = 0;
    let personalCount = 0;
    let insumoCount = 0;

    // ============ PACIENTES ============
    function agregarPaciente() {
        pacienteCount++;
        const container = document.getElementById('pacientes-container');
        const div = document.createElement('div');
        div.className = 'card mb-2 p-3 border-warning';
        div.id = 'paciente-' + pacienteCount;
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong class="text-warning">Paciente #<span class="paciente-num"></span></strong>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPaciente(${pacienteCount})">
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
                        <input type="number" name="pacientes[${pacienteCount}][edad]" class="form-control" min="0" max="120" required>
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label>FC (lpm)</label>
                        <input type="number" name="pacientes[${pacienteCount}][frecuencia_cardiaca]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>FR (rpm)</label>
                        <input type="number" name="pacientes[${pacienteCount}][frecuencia_respiratoria]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>SatO₂ (%)</label>
                        <input type="number" name="pacientes[${pacienteCount}][saturacion_oxigeno]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Temp (°C)</label>
                        <input type="number" step="0.1" name="pacientes[${pacienteCount}][temperatura]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>TA Sistólica</label>
                        <input type="number" name="pacientes[${pacienteCount}][presion_sistolica]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>TA Diastólica</label>
                        <input type="number" name="pacientes[${pacienteCount}][presion_diastolica]" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Glasgow</label>
                        <input type="number" name="pacientes[${pacienteCount}][glasgow]" class="form-control" min="3" max="15">
                    </div>
                </div>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hospital destino</label>
                        <input type="text" name="pacientes[${pacienteCount}][hospital_destino]" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Motivo de atención</label>
                        <textarea name="pacientes[${pacienteCount}][motivo_atencion]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Evaluación</label>
                        <textarea name="pacientes[${pacienteCount}][evaluacion]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Procedimientos realizados</label>
                        <textarea name="pacientes[${pacienteCount}][procedimientos_realizados]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="pacientes[${pacienteCount}][observaciones]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
        renumerarPacientes();
    }

    function eliminarPaciente(id) {
        const element = document.getElementById('paciente-' + id);
        if (element) {
            element.remove();
            renumerarPacientes();
        }
    }

    function renumerarPacientes() {
        const rows = document.querySelectorAll('#pacientes-container .card');
        rows.forEach((row, idx) => {
            const num = row.querySelector('.paciente-num');
            if (num) num.textContent = idx + 1;
        });
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
                            @foreach($personal as $persona)
                                <option value="{{ $persona->id }}">{{ $persona->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Rol en la emergencia <span class="text-danger">*</span></label>
                        <input type="text" name="personal[${personalCount}][rol_en_emergencia]" 
                               class="form-control" placeholder="Conductor, Paramédico..." required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarPersonal(${personalCount})">
                            <i class="fas fa-trash"></i>
                        </button>
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
                                <option value="{{ $insumo->id }}">{{ $insumo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cantidad <span class="text-danger">*</span></label>
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
                        <button type="button" class="btn btn-danger btn-sm form-control" onclick="eliminarInsumo(${insumoCount})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    }

    function eliminarInsumo(id) {
        const element = document.getElementById('insumo-' + id);
        if (element) element.remove();
    }

    // ============ INICIALIZAR CON 1 DE CADA UNO ============
    document.addEventListener('DOMContentLoaded', function() {
        agregarPaciente();
        agregarPersonal();
        agregarInsumo();
    });
</script>
@endsection