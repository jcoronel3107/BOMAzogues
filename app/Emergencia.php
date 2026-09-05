<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emergencia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fecha',
        'informacion_inicial',
        'tipo_incidente_id',
        'subcategoria',
        'estacion_id',
        'hora_salida_emergencia',
        'hora_llegada_emergencia',
        'hora_en_base',
        'detalle_emergencia',
        'ciudadano_afectado',
        'danos_estimados',
        'usr_creador',
        'usr_editor',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Relaciones
    public function tipoIncidente()
    {
        return $this->belongsTo(Incidente::class, 'tipo_incidente_id');
    }

    public function estacion()
    {
        return $this->belongsTo(Station::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'emergencia_user');
    }

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'emergencia_vehiculo')
            ->withPivot('conductor_id', 'km_salida', 'km_retorno')
            ->withTimestamps();
    }

    public function conductor()
    {
        return $this->belongsTo(User::class, 'conductor_id');
    }
}