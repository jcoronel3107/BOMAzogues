<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspeccion extends Model
{
    use SoftDeletes;

    protected $table = 'inspeccions';

    protected $fillable = [
        'codigo_inspeccion',
        'fecha_inspeccion',
        'tipo_inspeccion',
        'lugar',
        'direccion',
        'ciudad',
        'provincia',
        'inspector_id',
        'cargo_inspector',
        'observaciones',
        'recomendaciones',
        'estado',
        'nivel_riesgo',
        'fecha_proxima_inspeccion',
        'documento_adjunto',
        'cumple_normativas',
        'usuario_crea_id',
        'usuario_asigna_id',
        'usuario_aprueba_id',
        'usuario_ratifica_id',
        'fecha_asignacion',
        'fecha_aprobacion',
        'fecha_ratificacion',
    ];

    protected $casts = [
        'fecha_inspeccion' => 'date',
        'fecha_proxima_inspeccion' => 'date',
        'cumple_normativas' => 'boolean',
        'fecha_asignacion' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'fecha_ratificacion' => 'datetime',
    ];

    // === ESTADOS DE LA INSPECCIÓN ===
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_EN_PROGRESO = 'en_progreso';
    const ESTADO_COMPLETADA = 'completada';
    const ESTADO_APROBADA = 'aprobada';
    const ESTADO_RECHAZADA = 'rechazada';
    const ESTADO_RATIFICADO = 'ratificado';

    public static function getEstados()
    {
        return [
            self::ESTADO_PENDIENTE    => 'Pendiente',
            self::ESTADO_EN_PROGRESO  => 'En Progreso',
            self::ESTADO_COMPLETADA   => 'Completada',
            self::ESTADO_APROBADA     => 'Aprobada',
            self::ESTADO_RECHAZADA    => 'Rechazada',
            self::ESTADO_RATIFICADO   => 'Ratificado',
        ];
    }

    public function puedeRatificar()
    {
        return $this->estado === self::ESTADO_APROBADA;
    }

    // === RELACIONES ===
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usuario_crea_id');
    }

    public function usuarioAsigna()
    {
        return $this->belongsTo(User::class, 'usuario_asigna_id');
    }

    public function usuarioAprueba()
    {
        return $this->belongsTo(User::class, 'usuario_aprueba_id');
    }

    public function usuarioRatifica()
    {
        return $this->belongsTo(User::class, 'usuario_ratifica_id');
    }
}