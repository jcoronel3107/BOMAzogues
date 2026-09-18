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

    public function archivos()
    {
    return $this->hasMany(EmergenciaArchivo::class, 'emergencia_prehospitalaria_id')
                ->orderBy('created_at', 'desc');
    }

    /**
 * Espacio total usado en bytes
 */
public function getEspacioUsadoAttribute()
{
    return $this->archivos()->sum('tamano') ?? 0;
}

/**
 * Espacio total usado en MB
 */
public function getEspacioUsadoMbAttribute()
{
    return round($this->espacio_usado / 1024 / 1024, 2);
}

/**
 * Límite total en MB
 */
    public function getLimiteMbAttribute()
    {
        return config('filesystems.emergencias_archivos.limite_mb', 50);
    }

    /**
     * Espacio disponible en MB
     */
    public function getEspacioDisponibleMbAttribute()
    {
        $limiteBytes = $this->limite_mb * 1024 * 1024;
        $disponible = max(0, $limiteBytes - $this->espacio_usado);
        return round($disponible / 1024 / 1024, 2);
    }

    /**
     * Porcentaje de uso (0-100)
     */
    public function getPorcentajeUsoAttribute()
    {
        $limiteBytes = $this->limite_mb * 1024 * 1024;
        if ($limiteBytes <= 0) return 0;
        return round(($this->espacio_usado / $limiteBytes) * 100, 1);
    }

    /**
     * Color de la barra según el porcentaje
     */
    public function getColorBarraAttribute()
    {
        $porcentaje = $this->porcentaje_uso;
        if ($porcentaje >= 90) return 'danger';
        if ($porcentaje >= 70) return 'warning';
        return 'success';
    }
}