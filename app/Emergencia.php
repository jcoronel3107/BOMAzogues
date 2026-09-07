<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emergencia extends Model
{
    use SoftDeletes;

    // === ESTADOS ===
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_FINALIZADO = 'finalizado';


    protected $fillable = [
        'fecha',
        'informacion_inicial',
        'tipo_incidente_id',
        'subcategoria',
        'estacion_id',
        'parroquia_id', // <-- Agregar esta línea
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
    
    public function parroquia()
    {
    return $this->belongsTo(Parroquia::class);
    }

    // === ESTADOS ===
const ESTADO_ACTIVO = 'activo';
const ESTADO_FINALIZADO = 'finalizado';

public static function getEstados()
{
    return [
        self::ESTADO_ACTIVO => 'Activo',
        self::ESTADO_FINALIZADO => 'Finalizado',
    ];
}

public function getEstadoColor()
{
    $colores = [
        self::ESTADO_ACTIVO => 'success',
        self::ESTADO_FINALIZADO => 'secondary',
    ];
    return $colores[$this->estado] ?? 'secondary';
}

public function puedeFinalizar()
{
    return $this->estado === self::ESTADO_ACTIVO;
}

// Relación
public function usuarioFinaliza()
{
    return $this->belongsTo(User::class, 'usuario_finaliza_id');
}



}