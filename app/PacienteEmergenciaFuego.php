<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PacienteEmergenciaFuego extends Model
{
    protected $table = 'pacientes_emergencia_fuego';

    protected $fillable = [
        'emergencia_fuego_id',
        'nombre_completo', 'edad', 'sexo', 'cedula', 'telefono',
        'condicion', 'tipo_lesion', 'hospital_destino',
        'frecuencia_cardiaca', 'frecuencia_respiratoria',
        'saturacion_oxigeno', 'temperatura',
        'observaciones'
    ];

    public function emergencia()
    {
        return $this->belongsTo(EmergenciaFuego::class, 'emergencia_fuego_id');
    }

    public function getCondicionColorAttribute()
    {
        return [
            'Ileso' => 'success',
            'Herido' => 'warning',
            'Fallecido' => 'dark',
            'Desconocido' => 'secondary',
        ][$this->condicion] ?? 'secondary';
    }
}