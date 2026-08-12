<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstacionVehiculo extends Model
{
    protected $table = 'estacion_vehiculos';

    protected $fillable = [
        'estacion_novedad_id',
        'vehiculo_id',
        'estado',
        'tipo_novedad',
        'descripcion',
        'acciones_tomadas',
        'kilometraje',
        'fecha_reporte',
        'fecha_solucion',
    ];

    public function novedad()
    {
        return $this->belongsTo(EstacionNovedad::class, 'estacion_novedad_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}