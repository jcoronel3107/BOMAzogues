@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nuevo Insumo Médico</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('insumos-medicos.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripción <span class="text-danger">*</span></label>
                        <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}" required>
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Caso de Uso <span class="text-danger">*</span></label>
                        <input type="text" name="caso_uso" class="form-control @error('caso_uso') is-invalid @enderror" value="{{ old('caso_uso') }}" required>
                        @error('caso_uso')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cantidad <span class="text-danger">*</span></label>
                        <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', 0) }}" min="0" required>
                        @error('cantidad')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cantidad Mínima</label>
                        <input type="number" name="cantidad_minima" class="form-control @error('cantidad_minima') is-invalid @enderror" value="{{ old('cantidad_minima', 5) }}" min="0">
                        @error('cantidad_minima')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Presentación</label>
                        <select name="presentacion" class="form-control @error('presentacion') is-invalid @enderror">
                            <option value="">Seleccione...</option>
                            <option value="unidad" {{ old('presentacion') == 'unidad' ? 'selected' : '' }}>Unidad</option>
                            <option value="caja" {{ old('presentacion') == 'caja' ? 'selected' : '' }}>Caja</option>
                            <option value="frasco" {{ old('presentacion') == 'frasco' ? 'selected' : '' }}>Frasco</option>
                            <option value="ampolla" {{ old('presentacion') == 'ampolla' ? 'selected' : '' }}>Ampolla</option>
                            <option value="tubo" {{ old('presentacion') == 'tubo' ? 'selected' : '' }}>Tubo</option>
                            <option value="kit" {{ old('presentacion') == 'kit' ? 'selected' : '' }}>Kit</option>
                        </select>
                        @error('presentacion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoría</label>
                        <input type="text" name="categoria" class="form-control @error('categoria') is-invalid @enderror" value="{{ old('categoria') }}" placeholder="Ej: Medicamentos, Insumos, Equipos">
                        @error('categoria')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ubicación</label>
                        <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion') }}" placeholder="Ej: Bodega A, Estación 1">
                        @error('ubicacion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="form-control @error('fecha_vencimiento') is-invalid @enderror" value="{{ old('fecha_vencimiento') }}">
                        @error('fecha_vencimiento')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
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
                    <i class="fas fa-save"></i> Guardar Insumo
                </button>
                <a href="{{ route('insumos-medicos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection