# Módulo de Emergencias de Fuego

Sistema de registro y gestión de incendios y emergencias de fuego, con soporte para múltiples vehículos, personal, pacientes/víctimas, herramientas, recursos utilizados, archivos adjuntos y generación de PDF oficial del parte de bomberos.

---

## 📋 Descripción General

Este módulo permite registrar **emergencias de fuego** (incendios estructurales, forestales, vehiculares, etc.) donde una misma emergencia puede tener:

- **Múltiples vehículos** utilizados (bomberos, cisternas, rescate) con km de salida y llegada
- **Múltiples miembros del personal** que atienden (con rol en la emergencia)
- **Múltiples pacientes/víctimas** con condición (Ileso, Herido, Fallecido)
- **Recursos utilizados** (agua, espuma, químico en litros)
- **Herramientas utilizadas** (relación con tabla `herramientas`)
- **Insumos médicos** utilizados (con descuento automático de stock)
- **Parroquia** (relación con tabla `parroquias`)
- **Archivos adjuntos** (fotos del incendio, documentos) con límite de 50 MB

---

## 🗄️ Estructura de Base de Datos

### Tabla `emergencias_fuego` (cabecera)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `codigo` | string(30) | Código único (formato: EF-YYYY-NNNN) |
| `fecha_salida` | datetime | Salida de la base |
| `fecha_llegada_sitio` | datetime | Llegada al sitio |
| `fecha_control` | datetime | Control del fuego |
| `fecha_extincion` | datetime | Extinción total |
| `fecha_llegada_base` | datetime | Llegada a la base |
| `direccion` | string(255) | Dirección del incendio |
| `referencia` | string(255) | Referencia adicional |
| `parroquia_id` | bigint | FK a `parroquias` |
| `sector` | string(150) | Sector |
| `motivo_llamado` | string(255) | Motivo del llamado |
| `tipo_fuego` | enum | Estructural, Forestal, Vehicular, Basura, Químico, Industrial, Otro |
| `nivel_riesgo` | enum | Bajo, Medio, Alto, Crítico |
| `causa_probable` | string(150) | Causa probable |
| `area_afectada_m2` | decimal(10,2) | Área afectada en m² |
| `perdidas_estimadas` | decimal(12,2) | Pérdidas económicas |
| `moneda` | string(10) | Moneda (USD) |
| `agua_utilizada_litros` | decimal(10,2) | Agua utilizada |
| `espuma_utilizada_litros` | decimal(10,2) | Espuma utilizada |
| `quimico_utilizado_litros` | decimal(10,2) | Químico utilizado |
| `victimas_ilesos` | integer | Víctimas ilesas |
| `victimas_heridos` | integer | Víctimas heridas |
| `victimas_fallecidos` | integer | Víctimas fallecidas |
| `requirio_apoyo_externo` | boolean | Apoyo externo |
| `detalle_apoyo` | string(255) | Detalle |
| `usuario_registra_id` | bigint | FK a `users` |
| `observaciones_generales` | text | Notas |
| `estado` | enum | En curso, Controlado, Extinguido, En investigación, Finalizado |

### Tablas relacionadas

| Tabla | Descripción |
|-------|-------------|
| `pacientes_emergencia_fuego` | Pacientes/víctimas (1:N) |
| `emergencia_fuego_personal` | Personal que atiende (N:M con users) |
| `emergencia_fuego_vehiculos` | Vehículos (N:M con vehiculos + km) |
| `emergencia_fuego_insumos` | Insumos médicos (N:M con insumos_medicos) |
| `emergencia_fuego_herramientas` | Herramientas (N:M con herramientas) |
| `emergencia_fuego_archivos` | Archivos adjuntos (1:N) |

---

## 🔗 Relaciones del Modelo

```php
// EmergenciaFuego
- usuarioRegistra()  → belongsTo(User::class)
- parroquia()        → belongsTo(Parroquia::class, 'parroquia_id')
- personal()         → belongsToMany(User::class, 'emergencia_fuego_personal')
- vehiculos()        → belongsToMany(Vehiculo::class, 'emergencia_fuego_vehiculos')
- insumos()          → belongsToMany(InsumoMedico::class, 'emergencia_fuego_insumos')
- herramientas()     → belongsToMany(Herramienta::class, 'emergencia_fuego_herramientas')
- pacientes()        → hasMany(PacienteEmergenciaFuego::class)
- archivos()         → hasMany(EmergenciaFuegoArchivo::class)

// PacienteEmergenciaFuego
- emergencia()       → belongsTo(EmergenciaFuego::class)

// EmergenciaFuegoArchivo
- emergencia()       → belongsTo(EmergenciaFuego::class)
- usuario()          → belongsTo(User::class, 'usuario_subio_id')

// Parroquia
- emergenciasFuego() → hasMany(EmergenciaFuego::class, 'parroquia_id')

// Herramienta
- emergenciasFuego() → belongsToMany(EmergenciaFuego::class, 'emergencia_fuego_herramientas')