<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsumoMedico extends Model
{
    use SoftDeletes;

    protected $table = 'insumos_medicos';

    protected $fillable = [
        'codigo',
        'descripcion',
        'caso_uso',
        'cantidad',
        'cantidad_minima',
        'categoria',
        'presentacion',
        'fecha_vencimiento',
        'ubicacion',
        'observaciones',
        'estado',
        'usuario_crea_id',
        'usuario_edita_id',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'cantidad' => 'integer',
        'cantidad_minima' => 'integer',
    ];

    // === ESTADOS ===
    const ESTADO_DISPONIBLE = 'disponible';
    const ESTADO_AGOTADO = 'agotado';
    const ESTADO_VENCIDO = 'vencido';

    public static function getEstados()
    {
        return [
            self::ESTADO_DISPONIBLE => 'Disponible',
            self::ESTADO_AGOTADO => 'Agotado',
            self::ESTADO_VENCIDO => 'Vencido',
        ];
    }

    public function getEstadoColor()
    {
        $colores = [
            self::ESTADO_DISPONIBLE => 'success',
            self::ESTADO_AGOTADO => 'danger',
            self::ESTADO_VENCIDO => 'warning',
        ];
        return $colores[$this->estado] ?? 'secondary';
    }

    public function estaAgotado()
    {
        return $this->cantidad <= 0;
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