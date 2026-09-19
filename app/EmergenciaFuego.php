<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergenciaFuego extends Model
{
    protected $table = 'emergencias_fuego';

    protected $fillable = [
        'codigo',
        'fecha_salida', 'fecha_llegada_sitio', 'fecha_control',
        'fecha_extincion', 'fecha_llegada_base',
        'direccion', 'referencia', 'parroquia_id', 'sector',
        'motivo_llamado', 'tipo_fuego', 'nivel_riesgo', 'causa_probable',
        'area_afectada_m2', 'perdidas_estimadas', 'moneda',
        'agua_utilizada_litros', 'espuma_utilizada_litros', 'quimico_utilizado_litros',
        'victimas_ilesos', 'victimas_heridos', 'victimas_fallecidos',
        'requirio_apoyo_externo', 'detalle_apoyo',
        'usuario_registra_id', 'observaciones_generales', 'estado'
    ];

    protected $casts = [
        'fecha_salida' => 'datetime',
        'fecha_llegada_sitio' => 'datetime',
        'fecha_control' => 'datetime',
        'fecha_extincion' => 'datetime',
        'fecha_llegada_base' => 'datetime',
        'requirio_apoyo_externo' => 'boolean',
        'area_afectada_m2' => 'decimal:2',
        'perdidas_estimadas' => 'decimal:2',
        'agua_utilizada_litros' => 'decimal:2',
        'espuma_utilizada_litros' => 'decimal:2',
        'quimico_utilizado_litros' => 'decimal:2',
    ];

    // ===== RELACIONES =====
    public function usuarioRegistra()
    {
        return $this->belongsTo(User::class, 'usuario_registra_id');
    }

    public function personal()
    {
        return $this->belongsToMany(User::class, 'emergencia_fuego_personal')
                    ->withPivot('rol_en_emergencia')
                    ->withTimestamps();
    }

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'emergencia_fuego_vehiculos')
                    ->withPivot('rol_en_emergencia', 'km_salida', 'km_llegada')
                    ->withTimestamps();
    }

    public function insumos()
    {
        return $this->belongsToMany(InsumoMedico::class, 'emergencia_fuego_insumos')
                    ->withPivot('cantidad', 'observaciones')
                    ->withTimestamps();
    }

    public function pacientes()
    {
        return $this->hasMany(PacienteEmergenciaFuego::class, 'emergencia_fuego_id');
    }

    public function archivos()
    {
        return $this->hasMany(EmergenciaFuegoArchivo::class, 'emergencia_fuego_id')
                    ->orderBy('created_at', 'desc');
    }

    // ===== ACCESORES =====
    public function getColorPrioridadAttribute()
    {
        return [
            'Bajo' => 'success',
            'Medio' => 'info',
            'Alto' => 'warning',
            'Crítico' => 'danger',
        ][$this->nivel_riesgo] ?? 'secondary';
    }

    public function getEstadoColorAttribute()
    {
        return [
            'En curso' => 'primary',
            'Controlado' => 'info',
            'Extinguido' => 'success',
            'En investigación' => 'warning',
            'Finalizado' => 'secondary',
        ][$this->estado] ?? 'secondary';
    }

    public function getEspacioUsadoAttribute()
    {
        return $this->archivos()->sum('tamano') ?? 0;
    }

    public function getEspacioUsadoMbAttribute()
    {
        return round($this->espacio_usado / 1024 / 1024, 2);
    }

    public function getLimiteMbAttribute()
    {
        return config('filesystems.emergencias_archivos.limite_mb', 50);
    }

    public function getEspacioDisponibleMbAttribute()
    {
        $limiteBytes = $this->limite_mb * 1024 * 1024;
        $disponible = max(0, $limiteBytes - $this->espacio_usado);
        return round($disponible / 1024 / 1024, 2);
    }

    public function getPorcentajeUsoAttribute()
    {
        $limiteBytes = $this->limite_mb * 1024 * 1024;
        if ($limiteBytes <= 0) return 0;
        return round(($this->espacio_usado / $limiteBytes) * 100, 1);
    }

    public function getColorBarraAttribute()
    {
        $porcentaje = $this->porcentaje_uso;
        if ($porcentaje >= 90) return 'danger';
        if ($porcentaje >= 70) return 'warning';
        return 'success';
    }

    // ===== GENERACIÓN DE CÓDIGO =====
    public static function generarCodigo()
    {
        $anio = date('Y');
        $ultimo = self::whereYear('created_at', $anio)->count() + 1;
        return 'EF-' . $anio . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
    }

    // ===== UTILIDADES =====
    public static function getTiposFuego()
    {
        return ['Estructural', 'Forestal', 'Vehicular', 'Basura', 'Quimico', 'Industrial', 'Otro'];
    }

    public static function getNivelesRiesgo()
    {
        return ['Bajo', 'Medio', 'Alto', 'Crítico'];
    }

    public static function getEstados()
    {
        return ['En curso', 'Controlado', 'Extinguido', 'En investigación', 'Finalizado'];
    }


    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class, 'parroquia_id');
    }

    public function herramientas()
    {
        return $this->belongsToMany(Herramienta::class, 'emergencia_fuego_herramientas')
                    ->withPivot('cantidad', 'observaciones')
                    ->withTimestamps();
    }
}