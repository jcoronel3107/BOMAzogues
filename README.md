  Actuaizacion 17/09/2026
# Módulo de Emergencias Prehospitalarias

Sistema de registro y gestión de atenciones de ambulancias, con soporte para múltiples pacientes por emergencia, personal que atiende, insumos médicos utilizados, archivos adjuntos y generación de PDF oficial.

---

## 📋 Descripción General

Este módulo permite registrar **emergencias prehospitalarias** (salidas de ambulancia) donde una misma emergencia puede tener:

- **Múltiples pacientes** atendidos (con datos básicos y signos vitales prehospitalarios)
- **Múltiples miembros del personal** que atienden (relacionados con usuarios del sistema)
- **Múltiples insumos médicos** utilizados (con descuento automático de stock)
- **Un vehículo/ambulancia** asignado
- **Archivos adjuntos** (fotos, PDFs, documentos) con límite de 50 MB por emergencia

---

## 🗄️ Estructura de Base de Datos

### Tabla `emergencias_prehospitalarias` (cabecera)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `codigo` | string(30) | Código único (formato: EP-YYYY-NNNN) |
| `fecha_salida` | datetime | Fecha/hora de salida de la base |
| `fecha_llegada_sitio` | datetime | Llegada al sitio de la emergencia |
| `fecha_salida_sitio` | datetime | Salida del sitio |
| `fecha_llegada_base` | datetime | Llegada a la base |
| `direccion` | string(255) | Dirección del incidente |
| `referencia` | string(255) | Referencia adicional |
| `motivo_llamado` | string(255) | Motivo del llamado |
| `tipo_emergencia` | string | Tipo (Accidente, Trauma, Obstétrica, etc.) |
| `prioridad` | string(20) | Triage: Rojo, Naranja, Amarillo, Verde, Azul |
| `vehiculo_id` | bigint | FK a `vehiculos` |
| `usuario_registra_id` | bigint | FK a `users` |
| `observaciones_generales` | text | Notas adicionales |
| `estado` | string(30) | En curso, Finalizada, Cancelada, Derivada |
| `created_at`, `updated_at` | timestamp | Auditoría |

### Tabla `pacientes_emergencia` (muchos por emergencia)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `emergencia_prehospitalaria_id` | bigint | FK a `emergencias_prehospitalarias` |
| `nombre_completo` | string(150) | Nombre del paciente |
| `edad` | integer | Edad en años |
| `sexo` | string(20) | M, F, Indefinido |
| `cedula` | string(20) | Cédula (opcional) |
| `telefono` | string(20) | Teléfono (opcional) |
| **Signos vitales** | | |
| `frecuencia_cardiaca` | integer | FC en lpm |
| `frecuencia_respiratoria` | integer | FR en rpm |
| `saturacion_oxigeno` | integer | SatO₂ en % |
| `temperatura` | decimal(4,1) | Temperatura en °C |
| `presion_sistolica` | integer | TA sistólica en mmHg |
| `presion_diastolica` | integer | TA diastólica en mmHg |
| `glasgow` | integer | Escala de Glasgow (3-15) |
| **Evaluación** | | |
| `motivo_atencion` | text | Motivo de la atención |
| `evaluacion` | text | Evaluación médica |
| `procedimientos_realizados` | text | Procedimientos aplicados |
| `observaciones` | text | Notas adicionales |
| `condicion` | string(30) | Estable, Crítico, Fallecido, Rechaza atención |
| `destino` | string(100) | Trasladado, Alta en sitio, Fuga, etc. |
| `hospital_destino` | string(150) | Hospital de destino |

### Tabla `emergencia_personal` (pivote)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `emergencia_prehospitalaria_id` | bigint | FK a emergencias |
| `user_id` | bigint | FK a users |
| `rol_en_emergencia` | string(50) | Conductor, Paramédico, Médico, etc. |

### Tabla `emergencia_insumos` (pivote)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `emergencia_prehospitalaria_id` | bigint | FK a emergencias |
| `insumo_medico_id` | bigint | FK a `insumos_medicos` |
| `cantidad` | integer | Cantidad utilizada |
| `observaciones` | text | Notas adicionales |

### Tabla `emergencia_archivos` (adjuntos)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `emergencia_prehospitalaria_id` | bigint | FK a emergencias |
| `nombre_original` | string(255) | Nombre original del archivo |
| `nombre_archivo` | string(255) | Nombre único en el servidor |
| `ruta` | string(500) | Ruta relativa en storage |
| `tipo` | string(50) | Tipo de archivo |
| `mime_type` | string(100) | MIME type |
| `tamano` | bigint | Tamaño en bytes |
| `descripcion` | string(255) | Descripción opcional |
| `usuario_subio_id` | bigint | FK a users |

---

## 🔗 Relaciones del Modelo

```php
// EmergenciaPrehospitalaria
- vehiculo()              → belongsTo(Vehiculo::class)
- usuarioRegistra()       → belongsTo(User::class)
- personal()              → belongsToMany(User::class, 'emergencia_personal')
- insumos()               → belongsToMany(InsumoMedico::class, 'emergencia_insumos')
- pacientes()             → hasMany(PacienteEmergencia::class)
- archivos()              → hasMany(EmergenciaArchivo::class)

// PacienteEmergencia
- emergencia()            → belongsTo(EmergenciaPrehospitalaria::class)

// EmergenciaArchivo
- emergencia()            → belongsTo(EmergenciaPrehospitalaria::class)
- usuario()               → belongsTo(User::class, 'usuario_subio_id')
### Installation

1. Clone the repo
`git clone https://github.com/jcoronel3107/incidentes2.git`

2. Configure .env file
`mv .env.example .env`

3. Install composer
`composer install`

4.  Migrate database
`php artisan migrate`

5.  App key
`php artisan key:generate`

6. Seed database
`php artisan db:seed`

## Authors
Juan Fernando Coronel - jcoronel3107

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
