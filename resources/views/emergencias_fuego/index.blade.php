@extends('layouts.plantilla')

@section('cuerpo')

{{-- ===== TÍTULO Y BOTÓN NUEVO ===== --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fire text-danger"></i> Emergencias de Fuego
    </h1>
    <a href="{{ route('emergencias-fuego.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm"></i> Nueva Emergencia
    </a>
</div>

{{-- ===== ALERTA DE ÉXITO ===== --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

{{-- ===== TARJETAS RESUMEN ===== --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['total'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-fire fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Curso</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['en_curso'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-hourglass-half fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Extinguidos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['extinguidos'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Hoy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resumen['hoy'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-day fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FILTROS ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         data-toggle="collapse" data-target="#filtrosCollapse" style="cursor:pointer;">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter"></i> Filtros de Búsqueda
        </h6>
        <span class="badge badge-primary">
            {{ collect(request()->only(['buscar','estado','tipo_fuego','nivel_riesgo','fecha_desde','fecha_hasta']))->filter()->count() }} activo(s)
        </span>
    </div>
    <div class="collapse {{ request()->hasAny(['buscar','estado','tipo_fuego','nivel_riesgo','fecha_desde','fecha_hasta']) ? 'show' : '' }}"
         id="filtrosCollapse">
        <div class="card-body">
            <form method="GET" action="{{ route('emergencias-fuego.index') }}" id="formFiltros">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="small font-weight-bold">Buscar</label>
                            <input type="text" name="buscar" class="form-control form-control-sm"
                                   placeholder="Código, dirección, motivo..."
                                   value="{{ request('buscar') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Estado</label>
                            <select name="estado" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                @foreach($estados as $e)
                                    <option value="{{ $e }}" {{ request('estado') == $e ? 'selected' : '' }}>{{ $e }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Tipo</label>
                            <select name="tipo_fuego" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                @foreach($tipos as $t)
                                    <option value="{{ $t }}" {{ request('tipo_fuego') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Riesgo</label>
                            <select name="nivel_riesgo" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                @foreach($niveles as $n)
                                    <option value="{{ $n }}" {{ request('nivel_riesgo') == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Desde</label>
                            <input type="date" name="fecha_desde" class="form-control form-control-sm"
                                   value="{{ request('fecha_desde') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Hasta</label>
                            <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                                   value="{{ request('fecha_hasta') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Por página</label>
                            <select name="per_page" class="form-control form-control-sm">
                                @foreach([10, 25, 50, 100] as $n)
                                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="small font-weight-bold">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filtrar</button>
                                <a href="{{ route('emergencias-fuego.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== TABLA ===== --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list"></i> Listado de Emergencias de Fuego
        </h6>
    </div>
    <div class="card-body">
        @if($emergencias->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-fire fa-3x text-gray-300"></i>
                <h5 class="mt-3">No se encontraron emergencias</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['buscar','estado','tipo_fuego','nivel_riesgo','fecha_desde','fecha_hasta']))
                        Intenta ajustar los filtros o
                        <a href="{{ route('emergencias-fuego.index') }}">limpiar la búsqueda</a>.
                    @else
                        Aún no hay emergencias registradas.
                        <a href="{{ route('emergencias-fuego.create') }}">Registrar la primera</a>.
                    @endif
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Código</th>
                            <th>Fecha Salida</th>
                            <th>Tipo</th>
                            <th>Riesgo</th>
                            <th>Dirección</th>
                            <th class="text-center">Vehículos</th>
                            <th class="text-center">Pacientes</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emergencias as $e)
                            <tr>
                                <td>
                                    <a href="{{ route('emergencias-fuego.show', $e) }}" class="font-weight-bold text-primary">
                                        {{ $e->codigo }}
                                    </a>
                                </td>
                                <td>
                                    <div>{{ $e->fecha_salida->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $e->fecha_salida->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $e->tipo_fuego }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $e->color_prioridad }}">{{ $e->nivel_riesgo }}</span>
                                </td>
                                <td>
                                    <div>{{ Str::limit($e->direccion, 40) }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $e->vehiculos->count() }} 🚒</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-warning">{{ $e->pacientes->count() }} 👤</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $e->estado_color }}">{{ $e->estado }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('emergencias-fuego.show', $e) }}" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('emergencias-fuego.pdf', $e) }}" class="btn btn-danger btn-sm" title="PDF" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('emergencias-fuego.edit', $e) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmarEliminar({{ $e->id }}, '{{ $e->codigo }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="formEliminar{{ $e->id }}"
                                          action="{{ route('emergencias-fuego.destroy', $e) }}"
                                          method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($emergencias->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando <strong>{{ $emergencias->firstItem() }}</strong>
                        a <strong>{{ $emergencias->lastItem() }}</strong>
                        de <strong>{{ $emergencias->total() }}</strong> registros
                    </div>
                    <div>{{ $emergencias->links() }}</div>
                </div>
            @endif
        @endif
    </div>
</div>

<script>
function confirmarEliminar(id, codigo) {
    if (confirm(`¿Eliminar la emergencia ${codigo}?\n\n⚠️ Se restaurará el stock de insumos.`)) {
        document.getElementById('formEliminar' + id).submit();
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const perPageSelect = document.querySelector('select[name="per_page"]');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            document.getElementById('formFiltros').submit();
        });
    }
});
</script>
@endsection