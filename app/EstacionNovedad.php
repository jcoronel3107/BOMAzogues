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
        'usuario_ratifica_id',
        'estado',
        'fecha_elaboracion',
        'fecha_revision',
        'fecha_aprobacion',
        'fecha_ratificacion',
        'fecha_creacion',
        'observaciones',
        'bloqueado',
        'integrantes_guardia',  // <-- Agregar este campo
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_elaboracion' => 'datetime',
        'fecha_revision' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'fecha_ratificacion' => 'datetime',
        'fecha_creacion' => 'datetime',
        'bloqueado' => 'boolean',
        'integrantes_guardia' => 'array',  // <-- Agregar este cast
    ];

    // === ESTADOS DE LA NOVEDAD ===
    const ESTADO_ELABORACION = 'elaboracion';
    const ESTADO_REVISION = 'revision';
    const ESTADO_APROBADO = 'aprobado';
    
    public static function getEstados()
    {
        return [
            self::ESTADO_ELABORACION => 'Elaboración',
            self::ESTADO_REVISION    => 'Revisión',
            self::ESTADO_APROBADO    => 'Aprobado',
        ];
    }

    public function getEstadoColor()
    {
        $colores = [
            self::ESTADO_ELABORACION => 'warning',
            self::ESTADO_REVISION    => 'info',
            self::ESTADO_APROBADO    => 'success',
        ];
        return $colores[$this->estado] ?? 'secondary';
    }

    // === RELACIONES ===
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

    public function usuarioRatifica()
    {
        return $this->belongsTo(User::class, 'usuario_ratifica_id');
    }

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usuario_crea_id');
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

    // === MÉTODOS ===
    public function puedeEditar()
    {
        return $this->estado !== self::ESTADO_APROBADO && !$this->bloqueado;
    }

    public function puedeAprobar()
    {
        return $this->estado === self::ESTADO_REVISION && !$this->bloqueado;
    }

    public function puedeRevisar()
    {
        return $this->estado === self::ESTADO_ELABORACION && !$this->bloqueado;
    }

    public function scopeDeUsuario($query)
    {
        $user = auth()->user();
        if ($user && $user->station_id) {
            return $query->where('estacion_id', $user->station_id);
        }
        return $query;
    }

    public function index()
    {
        $novedades = EstacionNovedad::with(['estacion', 'usuarioElabora', 'usuarioRevisa', 'usuarioAprueba'])
            ->deUsuario()
            ->latest()
            ->paginate(15);
        
        return view('estacion_novedades.index', compact('novedades'));
    }
}