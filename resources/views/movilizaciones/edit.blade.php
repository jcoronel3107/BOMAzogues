@extends('layouts.plantilla')

@section('cuerpo')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Editar Movilización - MOV-{{ str_pad($movilizacion->id, 6, '0', STR_PAD_LEFT) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('movilizaciones.update', $movilizacion) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $movilizacion->fecha->format('Y-m-d')) }}" required>
                        @error('fecha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hora de Salida <span class="text-danger">*</span></label>
                        <input type="time" name="hora_salida" class="form-control @error('hora_salida') is-invalid @enderror" value="{{ old('hora_salida', $movilizacion->hora_salida) }}" required>
                        @error('hora_salida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Motivo <span class="text-danger">*</span></label>
                        <input type="text" name="motivo" class="form-control @error('motivo') is-invalid @enderror" value="{{ old('motivo', $movilizacion->motivo) }}" required>
                        @error('motivo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lugar de Origen <span class="text-danger">*</span></label>
                        <input type="text" name="lugar_origen" class="form-control @error('lugar_origen') is-invalid @enderror" value="{{ old('lugar_origen', $movilizacion->lugar_origen) }}" required>
                        @error('lugar_origen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Destino <span class="text-danger">*</span></label>
                        <input type="text" name="destino" class="form-control @error('destino') is-invalid @enderror" value="{{ old('destino', $movilizacion->destino) }}" required>
                        @error('destino')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Datos del Conductor</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombres y Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="conductor_nombres" class="form-control @error('conductor_nombres') is-invalid @enderror" value="{{ old('conductor_nombres', $movilizacion->conductor_nombres) }}" required>
                        @error('conductor_nombres')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cédula <span class="text-danger">*</span></label>
                        <input type="text" name="conductor_cedula" class="form-control @error('conductor_cedula') is-invalid @enderror" value="{{ old('conductor_cedula', $movilizacion->conductor_cedula) }}" required>
                        @error('conductor_cedula')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cargo</label>
                        <input type="text" name="conductor_cargo" class="form-control @error('conductor_cargo') is-invalid @enderror" value="{{ old('conductor_cargo', $movilizacion->conductor_cargo) }}">
                        @error('conductor_cargo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Datos del Vehículo</h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Marca <span class="text-danger">*</span></label>
                        <input type="text" name="vehiculo_marca" class="form-control @error('vehiculo_marca') is-invalid @enderror" value="{{ old('vehiculo_marca', $movilizacion->vehiculo_marca) }}" required>
                        @error('vehiculo_marca')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Placas <span class="text-danger">*</span></label>
                        <input type="text" name="vehiculo_placa" class="form-control @error('vehiculo_placa') is-invalid @enderror" value="{{ old('vehiculo_placa', $movilizacion->vehiculo_placa) }}" required>
                        @error('vehiculo_placa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>KM de Salida <span class="text-danger">*</span></label>
                        <input type="number" name="vehiculo_km_salida" class="form-control @error('vehiculo_km_salida') is-invalid @enderror" value="{{ old('vehiculo_km_salida', $movilizacion->vehiculo_km_salida) }}" required min="0">
                        @error('vehiculo_km_salida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Integrantes de la Comisión</h5>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="agregarIntegrante()">
                        <i class="fas fa-plus"></i> Agregar Integrante
                    </button>
                    <div id="integrantes-container">
                        @if($movilizacion->integrantes)
                            @foreach($moviliz