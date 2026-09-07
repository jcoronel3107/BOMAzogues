<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Herramienta extends Model
{
    use SoftDeletes;

    protected $table = 'herramientas';

    protected $fillable = [
        'codigo',
        'descripcion',
        'ubicacion',
        'cantidad',
        'cantidad_minima',
        'marca',
        'modelo',
        'numero_serie',
        'categoria',
        'fecha_compra',
        'valor_compra',
        'fecha_mantenimiento',
        'observaciones',
        'estado',
        'usuario_crea_id',
        'usuario_edita_id',
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_mantenimiento' => 'date',
        'valor_compra' => 'decimal:2',
        'cantidad' => 'integer',
        'cantidad_minima' => 'integer',
    ];

    // === ESTADOS ===
    const ESTADO_DISPONIBLE = 'disponible';
    const ESTADO_EN_USO = 'en_uso';
    const ESTADO_MANTENIMIENTO = 'mantenimiento';
    const ESTADO_AVERIADA = 'averiada';
    const ESTADO_BAJA = 'baja';

    public static function getEstados()
    {
        return [
            self::ESTADO_DISPONIBLE => 'Disponible',
            self::ESTADO_EN_USO => 'En Uso',
            self::ESTADO_MANTENIMIENTO => 'Mantenimiento',
            self::ESTADO_AVERIADA => 'Averiada',
            self::ESTADO_BAJA => 'Baja',
        ];
    }

    public function getEstadoColor()
    {
        $colores = [
            self::ESTADO_DISPONIBLE => 'success',
            self::ESTADO_EN_USO => 'info',
            self::ESTADO_MANTENIMIENTO => 'warning',
            self::ESTADO_AVERIADA => 'danger',
            self::ESTADO_BAJA => 'secondary',
        ];
        return $colores[$this->estado] ?? 'secondary';
    }

    public function estaDisponible()
    {
        return $this->estado === self::ESTADO_DISPONIBLE && $this->cantidad > 0;
    }

    public function estaBajoStock()
    {
        return $this->cantidad > 0 && $this->cantidad <= $this->cantidad_minima;
    }

    // === RELACIONES ===
    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usuario_crea_id');
    }

    public function usuarioEdita()
    {
        return $this->belongsTo(User::class, 'usuario_edita_id');
    }
}