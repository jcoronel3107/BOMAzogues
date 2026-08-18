<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstacionPersonal extends Model
{
    protected $table = 'estacion_personal';

    protected $fillable = [
        'estacion_novedad_id',
        'user_id',
        'cargo',
        'turno',
        'hora_entrada',
        'hora_salida',
        'estado',
        'observaciones',
    ];

    public function novedad()
    {
        return $this->belongsTo(EstacionNovedad::class, 'estacion_novedad_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}