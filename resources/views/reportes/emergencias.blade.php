@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Reporte de Emergencias</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('reportes.emergencias.buscar') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Fecha Desde <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ date('Y-m-01') }}" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Fecha Hasta <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection