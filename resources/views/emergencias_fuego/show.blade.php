@extends('layouts.plantilla')

@section('cuerpo')

{{-- ===== ENCABEZADO ===== --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fire text-danger"></i>
        Emergencia de Fuego — {{ $emergenciaFuego->codigo }}
    </h1>
    <div>
        <a href="{{ route('emergencias-fuego.pdf', $emergenciaFuego) }}"
           class="btn btn-danger btn-sm shadow-sm" target="_blank">
            <i class="fas fa-file-pdf"></i> Generar PDF
        </a>
        <a href="{{ route('emergencias-fuego.edit', $emergenciaFuego) }}"
           class="btn btn-warning btn-sm shadow-sm">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('emergencias-fuego.index') }}"
           class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

{{-- ===== ALERTAS ===== --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

{{-- ===== BADGES ===== --}}
<div class="mb-3">
    <span class="badge badge-{{ $emergenciaFuego->estado_color }} p-2">
        <i class="fas fa-info-circle"></i> Estado: {{ $emergenciaFuego->estado }}
    </span>
    <span class="badge badge-{{ $emergenciaFuego->color_prioridad }} p-2">
        <i class="fas fa-exclamation-triangle"></i> Riesgo: {{ $emergenciaFuego->nivel_riesgo }}
    </span>
    <span class="badge badge-secondary p-2">
        <i class="fas fa-fire"></i> Tipo: {{ $emergenciaFuego->tipo_fuego }}
    </span>
</div>

{{-- ===== SECCIÓN 1: DATOS GENERALES ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">1. Datos Generales</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <small class="text-muted">Fecha/Hora Salida</small>
                <p class="mb-1"><strong>{{ $emergenciaFuego->fecha_salida->format('d/m/Y H:i') }}</strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Llegada al Sitio</small>
                <p class="mb-1">{{ $emergenciaFuego->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—' }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Control del Fuego</small>
                <p class="mb-1">{{ $emergenciaFuego->fecha_control?->format('d/m/Y H:i') ?? '—' }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Extinción Total</small>
                <p class="mb-1">{{ $emergenciaFuego->fecha_extincion?->format('d/m/Y H:i') ?? '—' }}</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">Dirección</small>
                <p class="mb-1"><strong>{{ $emergenciaFuego->direccion }}</strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Referencia</small>
                <p class="mb-1">{{ $emergenciaFuego->referencia ?? '—' }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Parroquia / Sector</small>
                <p class="mb-1">
                    {{ $emergenciaFuego->parroquia->nombre ?? '—' }} / {{ $emergenciaFuego->sector ?? '—' }}
                </p>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">
                <small class="text-muted">Motivo del Llamado</small>
                <p class="mb-1"><strong>{{ $emergenciaFuego->motivo_llamado }}</strong></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Tipo de Fuego</small>
                <p class="mb-1">{{ $emergenciaFuego->tipo_fuego }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Causa Probable</small>
                <p class="mb-1">{{ $emergenciaFuego->causa_probable ?? '—' }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Llegada a Base</small>
                <p class="mb-1">{{ $emergenciaFuego->fecha_llegada_base?->format('d/m/Y H:i') ?? '—' }}</p>
            </div>
        </div>

        @if($emergenciaFuego->observaciones_generales)
            <hr>
            <div>
                <small class="text-muted">Observaciones Generales</small>
                <p class="mb-0">{{ $emergenciaFuego->observaciones_generales }}</p>
            </div>
        @endif
    </div>
</div>

{{-- ===== SECCIÓN 2: MAGNITUD Y RECURSOS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">2. Magnitud y Recursos Utilizados</h6>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Área afectada</small>
                    <strong class="h5">{{ $emergenciaFuego->area_afectada_m2 ?? '—' }}</strong>
                    <small class="d-block text-muted">m²</small>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Pérdidas estimadas</small>
                    <strong class="h5">{{ $emergenciaFuego->perdidas_estimadas ?? '—' }}</strong>
                    <small class="d-block text-muted">{{ $emergenciaFuego->moneda }}</small>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Agua utilizada</small>
                    <strong class="h5">{{ $emergenciaFuego->agua_utilizada_litros ?? '—' }}</strong>
                    <small class="d-block text-muted">litros</small>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Espuma utilizada</small>
                    <strong class="h5">{{ $emergenciaFuego->espuma_utilizada_litros ?? '—' }}</strong>
                    <small class="d-block text-muted">litros</small>
                </div>
            </div>
        </div>

        <hr>

        <h6 class="text-primary">Víctimas</h6>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Ilesos</small>
                    <strong class="h4 text-success">{{ $emergenciaFuego->victimas_ilesos }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Heridos</small>
                    <strong class="h4 text-warning">{{ $emergenciaFuego->victimas_heridos }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Fallecidos</small>
                    <strong class="h4 text-danger">{{ $emergenciaFuego->victimas_fallecidos }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border rounded p-3 bg-light">
                    <small class="text-muted d-block">Apoyo externo</small>
                    <strong class="h5">{{ $emergenciaFuego->requirio_apoyo_externo ? 'Sí' : 'No' }}</strong>
                    @if($emergenciaFuego->detalle_apoyo)
                        <small class="d-block text-muted">{{ $emergenciaFuego->detalle_apoyo }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SECCIÓN 3: VEHÍCULOS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            3. Vehículos Utilizados
            <span class="badge badge-info">{{ $emergenciaFuego->vehiculos->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($emergenciaFuego->vehiculos->isEmpty())
            <p class="text-muted mb-0">No hay vehículos registrados.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Placa</th>
                            <th>Marca / Modelo</th>
                            <th>Rol</th>
                            <th>Km Salida</th>
                            <th>Km Llegada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emergenciaFuego->vehiculos as $i => $v)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $v->placa }}</strong></td>
                                <td>{{ $v->marca ?? '' }} {{ $v->modelo ?? '' }}</td>
                                <td><span class="badge badge-info">{{ $v->pivot->rol_en_emergencia ?? '—' }}</span></td>
                                <td>{{ $v->pivot->km_salida ?? '—' }}</td>
                                <td>{{ $v->pivot->km_llegada ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- ===== SECCIÓN 4: PERSONAL ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            4. Personal que Atendió
            <span class="badge badge-info">{{ $emergenciaFuego->personal->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($emergenciaFuego->personal->isEmpty())
            <p class="text-muted mb-0">No hay personal registrado.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emergenciaFuego->personal as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $p->name }}</strong></td>
                                <td>{{ $p->email }}</td>
                                <td><span class="badge badge-info">{{ $p->pivot->rol_en_emergencia }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- ===== SECCIÓN 5: PACIENTES ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            5. Pacientes / Víctimas
            <span class="badge badge-warning">{{ $emergenciaFuego->pacientes->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($emergenciaFuego->pacientes->isEmpty())
            <p class="text-muted mb-0">No hay pacientes registrados.</p>
        @else
            @foreach($emergenciaFuego->pacientes as $i => $pac)
                <div class="card mb-3 border-left-warning">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>Paciente #{{ $i + 1 }}: {{ $pac->nombre_completo }}</strong>
                        <span class="badge badge-{{ $pac->condicion_color }}">{{ $pac->condicion }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <small class="text-muted">Edad</small>
                                <p class="mb-1"><strong>{{ $pac->edad ?? '—' }} años</strong></p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Sexo</small>
                                <p class="mb-1">{{ $pac->sexo }}</p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Cédula</small>
                                <p class="mb-1">{{ $pac->cedula ?? '—' }}</p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Teléfono</small>
                                <p class="mb-1">{{ $pac->telefono ?? '—' }}</p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Tipo lesión</small>
                                <p class="mb-1">{{ $pac->tipo_lesion ?? '—' }}</p>
                            </div>
                            <div class="col-md-2">
                                <small class="text-muted">Hospital</small>
                                <p class="mb-1">{{ $pac->hospital_destino ?? '—' }}</p>
                            </div>
                        </div>
                        @if($pac->frecuencia_cardiaca || $pac->frecuencia_respiratoria || $pac->saturacion_oxigeno || $pac->temperatura)
                            <hr>
                            <div class="row">
                                <div class="col-md-2"><small class="text-muted d-block">FC</small><strong>{{ $pac->frecuencia_cardiaca ?? '—' }}</strong></div>
                                <div class="col-md-2"><small class="text-muted d-block">FR</small><strong>{{ $pac->frecuencia_respiratoria ?? '—' }}</strong></div>
                                <div class="col-md-2"><small class="text-muted d-block">SatO₂</small><strong>{{ $pac->saturacion_oxigeno ?? '—' }}</strong></div>
                                <div class="col-md-2"><small class="text-muted d-block">Temp</small><strong>{{ $pac->temperatura ?? '—' }}</strong></div>
                            </div>
                        @endif
                        @if($pac->observaciones)
                            <hr>
                            <small class="text-muted">Observaciones</small>
                            <p class="mb-0">{{ $pac->observaciones }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

{{-- ===== SECCIÓN 6: HERRAMIENTAS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-tools"></i> Herramientas Utilizadas
            <span class="badge badge-info">{{ $emergenciaFuego->herramientas->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($emergenciaFuego->herramientas->isEmpty())
            <p class="text-muted mb-0">No se registraron herramientas.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Herramienta</th>
                            <th>Código</th>
                            <th>Marca</th>
                            <th class="text-center">Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emergenciaFuego->herramientas as $i => $herr)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $herr->descripcion }}</strong></td>
                                <td>{{ $herr->codigo ?? '—' }}</td>
                                <td>{{ $herr->marca ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-primary">{{ $herr->pivot->cantidad }}</span>
                                </td>
                                <td>{{ $herr->pivot->observaciones ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- ===== SECCIÓN 7: INSUMOS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            7. Insumos Utilizados
            <span class="badge badge-secondary">{{ $emergenciaFuego->insumos->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($emergenciaFuego->insumos->isEmpty())
            <p class="text-muted mb-0">No se registraron insumos.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Insumo</th>
                            <th class="text-center">Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emergenciaFuego->insumos as $i => $ins)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $ins->descripcion }}</strong></td>
                                <td class="text-center"><span class="badge badge-primary">{{ $ins->pivot->cantidad }}</span></td>
                                <td>{{ $ins->pivot->observaciones ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- ===== SECCIÓN 8: ARCHIVOS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-paperclip"></i> Archivos Adjuntos
            <span class="badge badge-info">{{ $emergenciaFuego->archivos->count() }}</span>
        </h6>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSubirArchivos"
                {{ $emergenciaFuego->porcentaje_uso >= 100 ? 'disabled' : '' }}>
            <i class="fas fa-upload"></i> Subir Archivos
        </button>
    </div>

    <div class="card-body py-2 border-bottom bg-light">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="font-weight-bold">
                <i class="fas fa-hdd"></i> Espacio usado:
                <strong>{{ $emergenciaFuego->espacio_usado_mb }} MB</strong>
                de <strong>{{ $emergenciaFuego->limite_mb }} MB</strong>
            </small>
            <small class="text-{{ $emergenciaFuego->color_barra }}">
                <strong>{{ $emergenciaFuego->porcentaje_uso }}%</strong>
            </small>
        </div>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-{{ $emergenciaFuego->color_barra }}"
                 style="width: {{ $emergenciaFuego->porcentaje_uso }}%"></div>
        </div>
    </div>

    <div class="card-body">
        @if($emergenciaFuego->archivos->isEmpty())
            <p class="text-muted mb-0 text-center">
                <i class="fas fa-folder-open fa-2x d-block mb-2 text-gray-300"></i>
                No hay archivos adjuntos.
            </p>
        @else
            <div class="row">
                @foreach($emergenciaFuego->archivos as $archivo)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card h-100 shadow-sm">
                            @if($archivo->es_imagen)
                                <img src="{{ asset('storage/' . $archivo->ruta) }}" class="card-img-top"
                                     style="height: 120px; object-fit: cover; cursor: pointer;"
                                     data-toggle="modal" data-target="#modalPreviewImagen"
                                     data-img="{{ asset('storage/' . $archivo->ruta) }}"
                                     data-titulo="{{ $archivo->nombre_original }}">
                            @else
                                <div class="text-center py-4 bg-light">
                                    <i class="fas {{ $archivo->icono }} fa-3x text-secondary"></i>
                                </div>
                            @endif
                            <div class="card-body p-2">
                                <small class="d-block text-truncate" title="{{ $archivo->nombre_original }}">
                                    <strong>{{ $archivo->nombre_original }}</strong>
                                </small>
                                <small class="text-muted d-block">{{ $archivo->tamano_legible }}</small>
                            </div>
                            <div class="card-footer p-1 d-flex justify-content-between">
                                <a href="{{ route('emergencias-fuego.archivos.descargar', $archivo) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('emergencias-fuego.archivos.eliminar', $archivo) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este archivo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ===== INFO DE REGISTRO ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Información de Registro</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <small class="text-muted">Registrado por</small>
                <p class="mb-1"><strong>{{ $emergenciaFuego->usuarioRegistra->name ?? 'N/A' }}</strong></p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Fecha de Registro</small>
                <p class="mb-1">{{ $emergenciaFuego->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Última Actualización</small>
                <p class="mb-1">{{ $emergenciaFuego->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- ===== BOTONES FINALES ===== --}}
<div class="text-center mb-5">
    <a href="{{ route('emergencias-fuego.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
    <a href="{{ route('emergencias-fuego.pdf', $emergenciaFuego) }}" class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf"></i> PDF Parte de Bomberos
    </a>
    <a href="{{ route('emergencias-fuego.edit', $emergenciaFuego) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <form action="{{ route('emergencias-fuego.destroy', $emergenciaFuego) }}" method="POST" class="d-inline"
          onsubmit="return confirm('¿Eliminar esta emergencia? Se restaurará el stock de insumos.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
    </form>
</div>

{{-- ===== MODAL SUBIR ARCHIVOS ===== --}}
<div class="modal fade" id="modalSubirArchivos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('emergencias-fuego.archivos.subir', $emergenciaFuego) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-upload"></i> Subir Archivos</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info py-2">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            Disponible: <strong>{{ $emergenciaFuego->espacio_disponible_mb }} MB</strong>
                            de {{ $emergenciaFuego->limite_mb }} MB
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Seleccione archivos <span class="text-danger">*</span></label>
                        <input type="file" name="archivos[]" class="form-control-file" multiple required
                               accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.mp4,.mp3,.zip,.rar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL PREVIEW IMAGEN ===== --}}
<div class="modal fade" id="modalPreviewImagen" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloPreview">Vista previa</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img id="imagenPreview" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalPreview = document.getElementById('modalPreviewImagen');
    if (modalPreview) {
        modalPreview.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            document.getElementById('imagenPreview').src = trigger.getAttribute('data-img');
            document.getElementById('tituloPreview').textContent = trigger.getAttribute('data-titulo');
        });
    }
});
</script>

@endsection