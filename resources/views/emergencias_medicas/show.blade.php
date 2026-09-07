@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-ambulance"></i> Emergencia Médica: {{ $emergencia->codigo }}
        </h6>
        <div>
            <a href="{{ route('emergencias-medicas.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('emergencias-medicas.edit', $emergencia) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Estado -->
        <div class="alert alert-{{ $emergencia->getEstadoColor() }} mb-4">
            <strong>Estado:</strong> 
            <span class="badge badge-{{ $emergencia->getEstadoColor() }} badge-lg">
                {{ ucfirst($emergencia->estado) }}
            </span>
            @if($emergencia->estado == 'finalizada')
                <span class="ml-3"><i class="fas fa-user-check"></i> Finalizada por: {{ $emergencia->usuarioFinaliza->name ?? 'N/A' }}</span>
            @endif
        </div>

        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-info-circle"></i> Información General
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Código:</th>
                                <td><strong>{{ $emergencia->codigo }}</strong></td>
                            </tr>
                            <tr>
                                <th>Fecha:</th>
                                <td>{{ $emergencia->fecha->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Hora Llamada:</th>
                                <td>{{ $emergencia->hora_llamada }}</td>
                            </tr>
                            <tr>
                                <th>Hora Salida:</th>
                                <td>{{ $emergencia->hora_salida ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Hora Llegada:</th>
                                <td>{{ $emergencia->hora_llegada ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Hora Traslado:</th>
                                <td>{{ $emergencia->hora_traslado ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Hora Retorno:</th>
                                <td>{{ $emergencia->hora_retorno ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Tipo Emergencia:</th>
                                <td><span class="badge badge-info">{{ $emergencia->tipo_emergencia }}</span></td>
                            </tr>
                            <tr>
                                <th>Lugar Incidente:</th>
                                <td>{{ $emergencia->lugar_incidente }}</td>
                            </tr>
                            <tr>
                                <th>Nivel Gravedad:</th>
                                <td>
                                    @php
                                        $gravedadColores = [
                                            'leve' => 'success',
                                            'moderado' => 'warning',
                                            'grave' => 'danger',
                                            'critico' => 'dark'
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $gravedadColores[$emergencia->nivel_gravedad] ?? 'secondary' }}">
                                        {{ ucfirst($emergencia->nivel_gravedad ?? 'No definido') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Descripción:</th>
                                <td>{{ $emergencia->descripcion_incidente ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-user"></i> Datos del Paciente
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Nombres:</th>
                                <td><strong>{{ $emergencia->paciente_nombres }}</strong></td>
                            </tr>
                            <tr>
                                <th>Cédula:</th>
                                <td>{{ $emergencia->paciente_cedula ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Edad:</th>
                                <td>{{ $emergencia->paciente_edad ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Género:</th>
                                <td>{{ ucfirst($emergencia->paciente_genero ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Teléfono:</th>
                                <td>{{ $emergencia->paciente_telefono ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Dirección:</th>
                                <td>{{ $emergencia->paciente_direccion ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Contacto Emergencia:</th>
                                <td>{{ $emergencia->paciente_contacto_emergencia ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Teléfono Emergencia:</th>
                                <td>{{ $emergencia->paciente_telefono_emergencia ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-stethoscope"></i> Atención Médica
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Síntomas:</th>
                                <td>{{ $emergencia->sintomas ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Diagnóstico Presuntivo:</th>
                                <td>{{ $emergencia->diagnostico_presuntivo ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Tratamiento Aplicado:</th>
                                <td>{{ $emergencia->tratamiento_aplicado ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Medicamentos:</th>
                                <td>{{ $emergencia->medicamentos_administrados ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Signos Vitales:</th>
                                <td>
                                    @if($emergencia->signos_vitales)
                                        <pre class="mb-0">{{ json_encode($emergencia->signos_vitales, JSON_PRETTY_PRINT) }}</pre>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Destino:</th>
                                <td>{{ $emergencia->destino ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Hospital Destino:</th>
                                <td>{{ $emergencia->hospital_destino ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Responsable Entrega:</th>
                                <td>{{ $emergencia->responsable_entrega ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-warning text-white">
                        <i class="fas fa-vehicle"></i> Vehículo y Personal
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Vehículo:</th>
                                <td>
                                    @if($emergencia->vehiculo)
                                        {{ $emergencia->vehiculo->placa }} - {{ $emergencia->vehiculo->marca }} {{ $emergencia->vehiculo->modelo }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>KM Salida:</th>
                                <td>{{ $emergencia->km_salida ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Paramédicos:</th>
                                <td>
                                    @if($emergencia->paramedicos)
                                        @php
                                            $paramedicos = App\User::whereIn('id', $emergencia->paramedicos)->pluck('name')->implode(', ');
                                        @endphp
                                        {{ $paramedicos ?: 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Médicos:</th>
                                <td>
                                    @if($emergencia->medicos)
                                        @php
                                            $medicos = App\User::whereIn('id', $emergencia->medicos)->pluck('name')->implode(', ');
                                        @endphp
                                        {{ $medicos ?: 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        <i class="fas fa-clipboard-list"></i> Auditoría
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Creado por:</th>
                                <td>{{ $emergencia->usuarioCrea->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Fecha Creación:</th>
                                <td>{{ $emergencia->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($emergencia->usuario_edita_id)
                            <tr>
                                <th>Editado por:</th>
                                <td>{{ $emergencia->usuarioEdita->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Fecha Edición:</th>
                                <td>{{ $emergencia->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($emergencia->observaciones)
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-comment"></i> Observaciones
                    </div>
                    <div class="card-body">
                        {{ $emergencia->observaciones }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection