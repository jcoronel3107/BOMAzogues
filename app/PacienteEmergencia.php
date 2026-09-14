<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PacienteEmergencia extends Model
{
    protected $table = 'pacientes_emergencia';
    
    protected $fillable = [
        'emergencia_prehospitalaria_id', 'nombre_completo', 'edad', 'sexo',
        'cedula', 'telefono', 'frecuencia_cardiaca', 'frecuencia_respiratoria',
        'saturacion_oxigeno', 'temperatura', 'presion_sistolica', 'presion_diastolica',
        'glasgow', 'motivo_atencion', 'evaluacion', 'procedimientos_realizados',
        'observaciones', 'condicion', 'destino', 'hospital_destino'
    ];

    public function emergencia()
    {
        return $this->belongsTo(EmergenciaPrehospitalaria::class, 'emergencia_prehospitalaria_id');
    }
}