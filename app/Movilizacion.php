<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Movilizacion extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'fecha_salida',
        'fecha_retorno',
        'hora_salida',
        'km_salida',
        'km_retorno',
        'motivo',
        'lugar_origen',
        'destino',
        'conductor_nombres',
        'conductor_cedula',
        'conductor_cargo',
        'vehiculo_marca',
        'vehiculo_placa',
        'integrantes',
        'estado',
        'observaciones',
        'usr_creador',
        'usr_editor',
        'usr_autoriza',
        'fecha_autorizacion',
        'user_id',
        'vehiculo_id'
    ];

    protected $casts = [
        'integrantes' => 'array',
        'fecha_salida' => 'date',
        'fecha_retorno' => 'date',
        'fecha_autorizacion' => 'datetime',
    ];

    protected static $logFillable = true;
    
    public function actividad()
    {
        return $this->hasMany(Actividad::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usr_creador');
    }

    public function usuarioAutoriza()
    {
        return $this->belongsTo(User::class, 'usr_autoriza');
    }

    // Métodos de estado
    public function puedeEditar()
    {
        return in_array($this->estado, ['pendiente', 'rechazado']);
    }

    public function puedeAutorizar()
    {
        return $this->estado === 'pendiente';
    }

    public function calcularKmRecorridos()
    {
        if ($this->km_salida && $this->km_retorno) {
            return $this->km_retorno - $this->km_salida;
        }
        return null;
    }
}