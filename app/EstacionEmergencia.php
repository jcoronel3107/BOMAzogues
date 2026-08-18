<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstacionEmergencia extends Model
{
    protected $table = 'estacion_emergencias';

    protected $fillable = [
        'estacion_novedad_id',
        'tipo_emergencia',
        'lugar',
        'direccion',
        'sector',
        'hora_ingreso',
        'hora_salida',
        'numero_afectados',
        'numero_vehiculos',
        'numero_bomberos',
        'descripcion',
        'recursos_utilizados',
        'observaciones',
    ];

    public function novedad()
    {
        return $this->belongsTo(EstacionNovedad::class, 'estacion_novedad_id');
    }
}