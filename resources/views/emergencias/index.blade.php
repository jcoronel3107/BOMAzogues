@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Lista de Emergencias</h6>
        <div>
            <a href="{{ route('emergencias.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Emergencia
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Incidente</th>
                        <th>Estación</th>
                        <th>Personal</th>
                        <th>Vehículos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emergencias as $emergencia)
                    <tr>
                        <td>{{ $emergencia->id }}</td>
                        <td>{{ $emergencia->fecha->format('d/m/Y') }}</td>
                        <td>{{ $emergencia->tipoIncidente->nombre_incidente ?? 'N/A' }}</td>
                        <td>{{ $emergencia->estacion->nombre ?? 'N/A' }}</td>
                        <td>{{ $emergencia->usuarios->count() }}</td>
                        <td>{{ $emergencia->vehiculos->count() }}</td>
                        <td>
                            @if($emergencia->deleted_at)
                                <span class="badge badge-danger">Eliminado</span>
                            @else
                                <span class="badge badge-success">Activo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('emergencias.show', $emergencia) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('emergencias.edit', $emergencia) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(!$emergencia->deleted_at)
                                    <form action="{{ route('emergencias.destroy', $emergencia) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta emergencia?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay emergencias registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $emergencias->links() }}
    </div>
</div>
@endsection