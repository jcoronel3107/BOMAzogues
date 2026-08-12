@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Novedades de Estación</h6>
        @can('crear novedades')
            <a href="{{ route('estacion-novedades.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Novedad
            </a>
        @endcan
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
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Estación</th>
                        <th>Elaborado por</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($novedades as $novedad)
                    <tr>
                        <td>NOV-{{ str_pad($novedad->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha)) }}</td>
                        <td>{{ $novedad->estacion->nombre ?? 'N/A' }}</td>
                        <td>{{ $novedad->usuarioElabora->name ?? 'N/A' }}</td>
                        <td>
                            @php
                                $estados = [
                                    'elaboracion' => 'warning',
                                    'revision' => 'info',
                                    'aprobado' => 'success'
                                ];
                            @endphp
                            <span class="badge badge-{{ $estados[$novedad->estado] ?? 'secondary' }}">
                                {{ ucfirst($novedad->estado) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('estacion-novedades.show', $novedad) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('estacion-novedades.pdf', $novedad) }}" class="btn btn-danger btn-sm" title="Exportar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @can('editar novedades')
                                    @if($novedad->puedeEditar())
                                        <a href="{{ route('estacion-novedades.edit', $novedad) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('estacion-novedades.destroy', $novedad) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta novedad?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                                @can('revisar novedades')
                                    @if($novedad->estado == 'elaboracion')
                                        <form action="{{ route('estacion-novedades.enviar-revision', $novedad) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm" title="Enviar a Revisión">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                                @can('aprobar novedades')
                                    @if($novedad->estado == 'revision')
                                        <form action="{{ route('estacion-novedades.aprobar', $novedad) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Aprobar" onclick="return confirm('¿Estás seguro de aprobar esta novedad?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $novedades->links() }}
    </div>
</div>
@endsection