@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nueva Emergencia Médica</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('emergencias-medicas.store') }}" method="POST">
            @csrf

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                        <i class="fas fa-info-circle"></i> Información General
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="paciente-tab" data-toggle="tab" href="#paciente" role="tab" aria-controls="paciente" aria-selected="false">
                        <i class="fas fa-user"></i> Paciente
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="medica-tab" data-toggle="tab" href="#medica" role="tab" aria-controls="medica" aria-selected="false">
                        <i class="fas fa-stethoscope"></i> Atención Médica
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">
                        <i class="fas fa-users"></i> Personal
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-4" id="myTabContent">

                <!-- Pestaña 1: Información General -->
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha <span class="text-danger">*</span></label>
                                <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                @error('fecha')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Hora Llamada <span class="text-danger">*</span></label>
                                <input type="time" name="hora_llamada" class="form-control @error('hora_llamada') is-invalid @enderror" value="{{ old('hora_llamada', date('H:i')) }}" required>
                                @error('hora_llamada')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de Emergencia <span class="text-danger">*</span></label>
                                <select name="tipo_emergencia" class="form-control @error('tipo_emergencia') is-invalid @enderror" required>
                                    <option value="">Seleccione...</option>
                                    <option value="trauma" {{ old('tipo_emergencia') == 'trauma' ? 'selected' : '' }}>Trauma</option>
                                    <option value="cardiaco" {{ old('tipo_emergencia') == 'cardiaco' ? 'selected' : '' }}>Cardíaco</option>
                                    <option value="respiratorio" {{ old('tipo_emergencia') == 'respiratorio' ? 'selected' : '' }}>Respiratorio</option>
                                    <option value="neurologico" {{ old('tipo_emergencia') == 'neurologico' ? 'selected' : '' }}>Neurológico</option>
                                    <option value="obstetrico" {{ old('tipo_emergencia') == 'obstetrico' ? 'selected' : '' }}>Obstétrico</option>
                                    <option value="pediatrico" {{ old('tipo_emergencia') == 'pediatrico' ? 'selected' : '' }}>Pediátrico</option>
                                    <option value="psiquiatrico" {{ old('tipo_emergencia') == 'psiquiatrico' ? 'selected' : '' }}>Psiquiátrico</option>
                                    <option value="intoxicacion" {{ old('tipo_emergencia') == 'intoxicacion' ? 'selected' : '' }}>Intoxicación</option>
                                    <option value="quemadura" {{ old('tipo_emergencia') == 'quemadura' ? 'selected' : '' }}>Quemadura</option>
                                    <option value="otro" {{ old('tipo_emergencia') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('tipo_emergencia')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Hora Salida</label>
                                <input type="time" name="hora_salida" class="form-control @error('hora_salida') is-invalid @enderror" value="{{ old('hora_salida') }}">
                                @error('hora_salida')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Hora Llegada</label>
                                <input type="time" name="hora_llegada" class="form-control @error('hora_llegada') is-invalid @enderror" value="{{ old('hora_llegada') }}">
                                @error('hora_llegada')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lugar del Incidente <span class="text-danger">*</span></label>
                                <input type="text" name="lugar_incidente" class="form-control @error('lugar_incidente') is-invalid @enderror" value="{{ old('lugar_incidente') }}" required>
                                @error('lugar_incidente')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vehículo</label>
                                <select name="vehiculo_id" class="form-control @error('vehiculo_id') is-invalid @enderror">
                                    <option value="">Seleccione...</option>
                                    @foreach($vehiculos as $vehiculo)
                                        <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                            {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehiculo_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>KM Salida</label>
                                <input type="number" name="km_salida" class="form-control @error('km_salida') is-invalid @enderror" value="{{ old('km_salida') }}" min="0">
                                @error('km_salida')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nivel de Gravedad</label>
                                <select name="nivel_gravedad" class="form-control @error('nivel_gravedad') is-invalid @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="leve" {{ old('nivel_gravedad') == 'leve' ? 'selected' : '' }}>Leve</option>
                                    <option value="moderado" {{ old('nivel_gravedad') == 'moderado' ? 'selected' : '' }}>Moderado</option>
                                    <option value="grave" {{ old('nivel_gravedad') == 'grave' ? 'selected' : '' }}>Grave</option>
                                    <option value="critico" {{ old('nivel_gravedad') == 'critico' ? 'selected' : '' }}>Crítico</option>
                                </select>
                                @error('nivel_gravedad')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción del Incidente</label>
                                <textarea name="descripcion_incidente" class="form-control @error('descripcion_incidente') is-invalid @enderror" rows="2">{{ old('descripcion_incidente') }}</textarea>
                                @error('descripcion_incidente')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña 2: Paciente -->
                <div class="tab-pane fade" id="paciente" role="tabpanel" aria-labelledby="paciente-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres del Paciente <span class="text-danger">*</span></label>
                                <input type="text" name="paciente_nombres" class="form-control @error('paciente_nombres') is-invalid @enderror" value="{{ old('paciente_nombres') }}" required>
                                @error('paciente_nombres')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cédula</label>
                                <input type="text" name="paciente_cedula" class="form-control @error('paciente_cedula') is-invalid @enderror" value="{{ old('paciente_cedula') }}">
                                @error('paciente_cedula')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Edad</label>
                                <input type="text" name="paciente_edad" class="form-control @error('paciente_edad') is-invalid @enderror" value="{{ old('paciente_edad') }}" placeholder="Ej: 35 años">
                                @error('paciente_edad')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Género</label>
                                <select name="paciente_genero" class="form-control @error('paciente_genero') is-invalid @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="masculino" {{ old('paciente_genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('paciente_genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('paciente_genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('paciente_genero')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" name="paciente_telefono" class="form-control @error('paciente_telefono') is-invalid @enderror" value="{{ old('paciente_telefono') }}">
                                @error('paciente_telefono')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" name="paciente_direccion" class="form-control @error('paciente_direccion') is-invalid @enderror" value="{{ old('paciente_direccion') }}">
                                @error('paciente_direccion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contacto de Emergencia</label>
                                <input type="text" name="paciente_contacto_emergencia" class="form-control @error('paciente_contacto_emergencia') is-invalid @enderror" value="{{ old('paciente_contacto_emergencia') }}">
                                @error('paciente_contacto_emergencia')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono de Emergencia</label>
                                <input type="text" name="paciente_telefono_emergencia" class="form-control @error('paciente_telefono_emergencia') is-invalid @enderror" value="{{ old('paciente_telefono_emergencia') }}">
                                @error('paciente_telefono_emergencia')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña 3: Atención Médica -->
                <div class="tab-pane fade" id="medica" role="tabpanel" aria-labelledby="medica-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Síntomas</label>
                                <textarea name="sintomas" class="form-control @error('sintomas') is-invalid @enderror" rows="2">{{ old('sintomas') }}</textarea>
                                @error('sintomas')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Diagnóstico Presuntivo</label>
                                <input type="text" name="diagnostico_presuntivo" class="form-control @error('diagnostico_presuntivo') is-invalid @enderror" value="{{ old('diagnostico_presuntivo') }}">
                                @error('diagnostico_presuntivo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tratamiento Aplicado</label>
                                <textarea name="tratamiento_aplicado" class="form-control @error('tratamiento_aplicado') is-invalid @enderror" rows="2">{{ old('tratamiento_aplicado') }}</textarea>
                                @error('tratamiento_aplicado')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Medicamentos Administrados</label>
                                <textarea name="medicamentos_administrados" class="form-control @error('medicamentos_administrados') is-invalid @enderror" rows="2">{{ old('medicamentos_administrados') }}</textarea>
                                @error('medicamentos_administrados')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destino</label>
                                <input type="text" name="destino" class="form-control @error('destino') is-invalid @enderror" value="{{ old('destino') }}" placeholder="Hospital, Domicilio, etc.">
                                @error('destino')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hospital Destino</label>
                                <input type="text" name="hospital_destino" class="form-control @error('hospital_destino') is-invalid @enderror" value="{{ old('hospital_destino') }}">
                                @error('hospital_destino')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hora Traslado</label>
                                <input type="time" name="hora_traslado" class="form-control @error('hora_traslado') is-invalid @enderror" value="{{ old('hora_traslado') }}">
                                @error('hora_traslado')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable de Entrega</label>
                                <input type="text" name="responsable_entrega" class="form-control @error('responsable_entrega') is-invalid @enderror" value="{{ old('responsable_entrega') }}">
                                @error('responsable_entrega')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hora Retorno</label>
                                <input type="time" name="hora_retorno" class="form-control @error('hora_retorno') is-invalid @enderror" value="{{ old('hora_retorno') }}">
                                @error('hora_retorno')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Signos Vitales</label>
                                <input type="text" name="signos_vitales" class="form-control @error('signos_vitales') is-invalid @enderror" value="{{ old('signos_vitales') }}" placeholder='{"presion":"120/80","pulso":72,"respiracion":16,"temperatura":36.5}'>
                                @error('signos_vitales')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña 4: Personal -->
                <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Paramédicos</label>
                                <select name="paramedicos[]" class="form-control" multiple style="width: 100%; height: 100px;">
                                    @foreach($paramedicos as $paramedico)
                                        <option value="{{ $paramedico->id }}" {{ old('paramedicos') && in_array($paramedico->id, old('paramedicos')) ? 'selected' : '' }}>
                                            {{ $paramedico->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén presionada Ctrl para seleccionar múltiples.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Médicos</label>
                                <select name="medicos[]" class="form-control" multiple style="width: 100%; height: 100px;">
                                    @foreach($medicos as $medico)
                                        <option value="{{ $medico->id }}" {{ old('medicos') && in_array($medico->id, old('medicos')) ? 'selected' : '' }}>
                                            {{ $medico->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén presionada Ctrl para seleccionar múltiples.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4">
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
                    <i class="fas fa-save"></i> Guardar Emergencia Médica
                </button>
                <a href="{{ route('emergencias-medicas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection