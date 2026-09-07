<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmergenciaMedica extends Model
{
    use HasFactory;
}




class EmergenciaMedica extends Model
{
    use SoftDeletes;

    protected $table = 'emergencias_medicas';

    protected $fillable = [
        'codigo',
        'fecha',
        'hora_llamada',
        'hora_salida',
        'hora_llegada',
        'hora_traslado',
        'hora_retorno',
        'paciente_nombres',
        'paciente_cedula',
        'paciente_edad',
        'paciente_genero',
        'paciente_telefono',
        'paciente_direccion',
        'paciente_contacto_emergencia',
        'paciente_telefono_emergencia',
        'tipo_emergencia',
        'lugar_incidente',
        'parroquia_id',
        'descripcion_incidente',
        'sintomas',
        'diagnostico_presuntivo',
        'tratamiento_aplicado',
        'medicamentos_administrados',
        'signos_vitales',
        'nivel_gravedad',
        'destino',
        'hospital_destino',
        'responsable_entrega',
        'paramedicos',
        'medicos',
        'vehiculo_id',
        'km_salida',
        'km_llegada',
        'km_recorridos',
        'estado',
        'observaciones',
        'usuario_crea_id',
        'usuario_edita_id',
        'usuario_finaliza_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'paramedicos' => 'array',
        'medicos' => 'array',
        'signos_vitales' => 'array',
        'km_salida' => 'integer',
        'km_llegada' => 'integer',
        'km_recorridos' => 'integer',
    ];

    // === ESTADOS ===
    const ESTADO_REGISTRADA = 'registrada';
    const ESTADO_EN_ATENCION = 'en_atencion';
    const ESTADO_TRASLADADO = 'trasladado';
    const ESTADO_FINALIZADA = 'finalizada';
    const ESTADO_CANCELADA = 'cancelada';

    public static function getEstados()
    {
        return [
            self::ESTADO_REGISTRADA => 'Registrada',
            self::ESTADO_EN_ATENCION => 'En Atención',
            self::ESTADO_TRASLADADO => 'Trasladado',
            self::ESTADO_FINALIZADA => 'Finalizada',
            self::ESTADO_CANCELADA => 'Cancelada',
        ];
    }

    public function getEstadoColor()
    {
        $colores = [
            self::ESTADO_REGISTRADA => 'secondary',
            self::ESTADO_EN_ATENCION => 'info',
            self::ESTADO_TRASLADADO => 'warning',
            self::ESTADO_FINALIZADA => 'success',
            self::ESTADO_CANCELADA => 'danger',
        ];
        return $colores[$this->estado] ?? 'secondary';
    }

    // === RELACIONES ===
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usuario_crea_id');
    }

    public function usuarioEdita()
    {
        return $this->belongsTo(User::class, 'usuario_edita_id');
    }

    public function usuarioFinaliza()
    {
        return $this->belongsTo(User::class, 'usuario_finaliza_id');
    }
}