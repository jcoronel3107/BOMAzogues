<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergenciaPrehospitalaria extends Model
{
    protected $table = 'emergencias_prehospitalarias';
    
    protected $fillable = [
        'codigo', 'fecha_salida', 'fecha_llegada_sitio', 'fecha_salida_sitio',
        'fecha_llegada_base', 'direccion', 'referencia', 'motivo_llamado',
        'tipo_emergencia', 'prioridad', 'vehiculo_id', 'usuario_registra_id',
        'observaciones_generales', 'estado'
    ];

    protected $casts = [
        'fecha_salida' => 'datetime',
        'fecha_llegada_sitio' => 'datetime',
        'fecha_salida_sitio' => 'datetime',
        'fecha_llegada_base' => 'datetime',
    ];

    // Relaciones
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function usuarioRegistra()
    {
        return $this->belongsTo(User::class, 'usuario_registra_id');
    }

    public function personal()
    {
        return $this->belongsToMany(User::class, 'emergencia_personal')
                    ->withPivot('rol_en_emergencia')
                    ->withTimestamps();
    }

    public function insumos()
    {
        return $this->belongsToMany(InsumoMedico::class, 'emergencia_insumos')
                    ->withPivot('cantidad', 'observaciones')
                    ->withTimestamps();
    }

    public function pacientes()
    {
        return $this->hasMany(PacienteEmergencia::class, 'emergencia_prehospitalaria_id');
    }

    // Generar código automático
    public static function generarCodigo()
    {
        $anio = date('Y');
        $ultimo = self::whereYear('created_at', $anio)->count() + 1;
        return 'EP-' . $anio . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
    }
}