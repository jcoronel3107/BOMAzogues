@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Lista de Emergencias Médicas</h6>
        <div>
            <a href="{{ route('emergencias-medicas.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Emergencia Médica
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
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Tipo Emergencia</th>
                        <th>Lugar</th>
                        <th>Vehículo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emergencias as $emergencia)
                    <tr>
                        <td><strong>{{ $emergencia->codigo }}</strong></td>
                        <td>{{ $emergencia->fecha->format('d/m/Y') }}</td>
                        <td>{{ $emergencia->paciente_nombres }}</td>
                        <td>{{ $emergencia->tipo_emergencia }}</td>
                        <td>{{ $emergencia->lugar_incidente }}</td>
                        <td>{{ $emergencia->vehiculo->placa ?? 'N/A' }}</td>
                        <td>
                            @php
                                $estados = [
                                    'registrada' => 'secondary',
                                    'en_atencion' => 'info',
                                    'trasladado' => 'warning',
                                    'finalizada' => 'success',
                                    'cancelada' => 'danger'
                                ];
                            @endphp
                            <span class="badge badge-{{ $estados[$emergencia->estado] ?? 'secondary' }}">
                                {{ ucfirst($emergencia->estado ?? 'Sin estado') }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('emergencias-medicas.show', $emergencia) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('emergencias-medicas.edit', $emergencia) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($emergencia->estado != 'finalizada' && $emergencia->estado != 'cancelada')
                                    <form action="{{ route('emergencias-medicas.finalizar', $emergencia) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Finalizar" onclick="return confirm('¿Estás seguro de finalizar esta emergencia médica?')">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('emergencias-medicas.cancelar', $emergencia) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Cancelar" onclick="return confirm('¿Estás seguro de cancelar esta emergencia médica?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('emergencias-medicas.destroy', $emergencia) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta emergencia médica?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay emergencias médicas registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $emergencias->links() }}
    </div>
</div>
@endsection