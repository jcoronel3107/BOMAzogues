<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstacionNovedad extends Model
{
    use SoftDeletes;

    protected $table = 'estacion_novedades';

    protected $fillable = [
        'fecha',
        'estacion_id',
        'usuario_elabora_id',
        'usuario_revisa_id',
        'usuario_aprueba_id',
        'estado',
        'fecha_elaboracion',
        'fecha_revision',
        'fecha_aprobacion',
        'observaciones',
        'bloqueado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_elaboracion' => 'datetime',
        'fecha_revision' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'bloqueado' => 'boolean',
    ];

    // Relaciones
    public function estacion()
    {
        return $this->belongsTo(Station::class, 'estacion_id');
    }

    public function usuarioElabora()
    {
        return $this->belongsTo(User::class, 'usuario_elabora_id');
    }

    public function usuarioRevisa()
    {
        return $this->belongsTo(User::class, 'usuario_revisa_id');
    }

    public function usuarioAprueba()
    {
        return $this->belongsTo(User::class, 'usuario_aprueba_id');
    }

    public function emergencias()
    {
        return $this->hasMany(EstacionEmergencia::class, 'estacion_novedad_id');
    }

    public function vehiculos()
    {
        return $this->hasMany(EstacionVehiculo::class, 'estacion_novedad_id');
    }

    public function personal()
    {
        return $this->hasMany(EstacionPersonal::class, 'estacion_novedad_id');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', '!=', 'aprobado');
    }

    public function scopePorEstacion($query, $estacionId)
    {
        return $query->where('estacion_id', $estacionId);
    }

    // Métodos
    public function puedeEditar()
    {
        return $this->estado !== 'aprobado' && !$this->bloqueado;
    }

    public function puedeAprobar()
    {
        return $this->estado === 'revision' && !$this->bloqueado;
    }

    public function puedeRevisar()
    {
        return $this->estado === 'elaboracion' && !$this->bloqueado;
    }
}