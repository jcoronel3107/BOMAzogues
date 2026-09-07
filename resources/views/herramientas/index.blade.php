@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Lista de Herramientas</h6>
        <div>
            <a href="{{ route('herramientas.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Herramienta
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

        <!-- Alertas de stock bajo -->
        @php
            $stockBajo = $herramientas->filter(function($item) {
                return $item->estaBajoStock() && $item->estado != 'baja';
            });
        @endphp
        @if($stockBajo->count() > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Atención!</strong> Hay <strong>{{ $stockBajo->count() }}</strong> herramienta(s) con stock bajo.
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
                        <th>Descripción</th>
                        <th>Ubicación</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($herramientas as $herramienta)
                    <tr>
                        <td><strong>{{ $herramienta->codigo }}</strong></td>
                        <td>{{ $herramienta->descripcion }}</td>
                        <td>{{ $herramienta->ubicacion ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $herramienta->estaBajoStock() ? 'warning' : ($herramienta->cantidad <= 0 ? 'danger' : 'success') }}">
                                {{ $herramienta->cantidad }}
                            </span>
                        </td>
                        <td>{{ $herramienta->categoria ?? 'N/A' }}</td>
                        <td>
                            @php
                                $estados = [
                                    'disponible' => 'success',
                                    'en_uso' => 'info',
                                    'mantenimiento' => 'warning',
                                    'averiada' => 'danger',
                                    'baja' => 'secondary'
                                ];
                            @endphp
                            <span class="badge badge-{{ $estados[$herramienta->estado] ?? 'secondary' }}">
                                {{ ucfirst($herramienta->estado ?? 'Sin estado') }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('herramientas.show', $herramienta) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('herramientas.edit', $herramienta) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-primary btn-sm" title="Cambiar Estado" data-toggle="modal" data-target="#modalEstado{{ $herramienta->id }}">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                                <form action="{{ route('herramientas.destroy', $herramienta) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta herramienta?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Cambiar Estado -->
                    <div class="modal fade" id="modalEstado{{ $herramienta->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('herramientas.cambiar-estado', $herramienta) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cambiar Estado - {{ $herramienta->codigo }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Estado Actual: <strong>{{ ucfirst($herramienta->estado) }}</strong></label>
                                        </div>
                                        <div class="form-group">
                                            <label>Nuevo Estado <span class="text-danger">*</span></label>
                                            <select name="estado" class="form-control" required>
                                                @foreach(\App\Herramienta::getEstados() as $key => $value)
                                                    <option value="{{ $key }}" {{ $herramienta->estado == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay herramientas registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $herramientas->links() }}
    </div>
</div>
@endsection