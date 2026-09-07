@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Editar Insumo Médico</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('insumos-medicos.update', $insumo) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" class="form-control" value="{{ $insumo->codigo }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripción <span class="text-danger">*</span></label>
                        <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $insumo->descripcion) }}" required>
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Caso de Uso <span class="text-danger">*</span></label>
                        <input type="text" name="caso_uso" class="form-control @error('caso_uso') is-invalid @enderror" value="{{ old('caso_uso', $insumo->caso_uso) }}" required>
                        @error('caso_uso')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cantidad <span class="text-danger">*</span></label>
                        <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad', $insumo->cantidad) }}" min="0" required>
                        @error('cantidad')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cantidad Mínima</label>
                        <input type="number" name="cantidad_minima" class="form-control @error('cantidad_minima') is-invalid @enderror" value="{{ old('cantidad_minima', $insumo->cantidad_minima) }}" min="0">
                        @error('cantidad_minima')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Categoría</label>
                        <input type="text" name="categoria" class="form-control @error('categoria') is-invalid @enderror" value="{{ old('categoria', $insumo->categoria) }}">
                        @error('categoria')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Presentación</label>
                        <select name="presentacion" class="form-control @error('presentacion') is-invalid @enderror">
                            <option value="">Seleccione...</option>
                            <option value="unidad" {{ old('presentacion', $insumo->presentacion) == 'unidad' ? 'selected' : '' }}>Unidad</option>
                            <option value="caja" {{ old('presentacion', $insumo->presentacion) == 'caja' ? 'selected' : '' }}>Caja</option>
                            <option value="frasco" {{ old('presentacion', $insumo->presentacion) == 'frasco' ? 'selected' : '' }}>Frasco</option>
                            <option value="ampolla" {{ old('presentacion', $insumo->presentacion) == 'ampolla' ? 'selected' : '' }}>Ampolla</option>
                            <option value="tubo" {{ old('presentacion', $insumo->presentacion) == 'tubo' ? 'selected' : '' }}>Tubo</option>
                            <option value="kit" {{ old('presentacion', $insumo->presentacion) == 'kit' ? 'selected' : '' }}>Kit</option>
                        </select>
                        @error('presentacion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ubicación</label>
                        <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion', $insumo->ubicacion) }}">
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
                        <input type="date" name="fecha_vencimiento" class="form-control @error('fecha_vencimiento') is-invalid @enderror" value="{{ old('fecha_vencimiento', $insumo->fecha_vencimiento ? $insumo->fecha_vencimiento->format('Y-m-d') : '') }}">
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
                        <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="2">{{ old('observaciones', $insumo->observaciones) }}</textarea>
                        @error('observaciones')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Insumo
                </button>
                <a href="{{ route('insumos-medicos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection