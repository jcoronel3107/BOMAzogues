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

# Módulo de Novedades de Estación

Sistema de registro y gestión de novedades diarias de estación, con soporte para múltiples emergencias atendidas, novedades de vehículos, personal, integrantes de guardia y exportación a PDF/Excel.

---

## 📋 Descripción General

Este módulo permite registrar **novedades de estación** (reportes diarios de turno) donde una misma novedad puede contener:

- **Emergencias atendidas** durante el turno (con opción de importar emergencias existentes)
- **Novedades de vehículos** (estado, mantenimiento, kilometraje, reportes)
- **Novedades del personal** (turnos, estados, observaciones)
- **Integrantes de la guardia bomberil** (con nombre, cédula, cargo)
- **Observaciones generales** del turno

---

## 🗄️ Estructura de Base de Datos

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| `estacion_novedades` | Cabecera de la novedad (fecha, estación, observaciones) |
| `estacion_novedad_emergencias` | Emergencias atendidas en la novedad |
| `estacion_novedad_vehiculos` | Novedades de vehículos |
| `estacion_novedad_personal` | Novedades del personal |
| `estacion_novedad_integrantes` | Integrantes de la guardia |

### Tabla `estacion_novedades` (cabecera)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `fecha` | date | Fecha de la novedad |
| `estacion_id` | bigint | FK a `estaciones` |
| `observaciones` | text | Observaciones generales |
| `estado` | string(30) | Borrador, En revisión, Aprobada, Rechazada |
| `usuario_crea_id` | bigint | FK a `users` |
| `usuario_aprueba_id` | bigint | FK a `users` (nullable) |
| `fecha_aprobacion` | datetime | Fecha de aprobación |
| `created_at`, `updated_at` | timestamp | Auditoría |

### Tabla `estacion_novedad_emergencias`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `estacion_novedad_id` | bigint | FK a `estacion_novedades` |
| `emergencia_id` | bigint | FK a `emergencias` (opcional) |
| `tipo` | string(50) | Tipo de emergencia |
| `lugar` | string(255) | Lugar del incidente |
| `hora_ingreso` | time | Hora de ingreso |
| `hora_salida` | time | Hora de salida |
| `descripcion` | text | Descripción |

### Tabla `estacion_novedad_vehiculos`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `estacion_novedad_id` | bigint | FK a `estacion_novedades` |
| `vehiculo_id` | bigint | FK a `vehiculos` |
| `estado` | string(30) | Operativo, Mantenimiento, Averiado, Fuera de Servicio |
| `tipo_novedad` | string(100) | Tipo de novedad |
| `fecha_reporte` | date | Fecha de reporte |
| `fecha_solucion` | date | Fecha de solución (nullable) |
| `kilometraje` | integer | Kilometraje actual |
| `descripcion` | text | Descripción de la novedad |

### Tabla `estacion_novedad_personal`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `estacion_novedad_id` | bigint | FK a `estacion_novedades` |
| `user_id` | bigint | FK a `users` |
| `cargo` | string(100) | Cargo del funcionario |
| `turno` | string(20) | Mañana, Tarde, Noche, Descanso |
| `estado` | string(20) | Presente, Ausente, Permiso, Licencia, Comisión |
| `observaciones` | text | Observaciones |

### Tabla `estacion_novedad_integrantes`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID autoincremental |
| `estacion_novedad_id` | bigint | FK a `estacion_novedades` |
| `nombre` | string(150) | Nombre completo |
| `cedula` | string(20) | Cédula |
| `cargo` | string(50) | Bombero, Teniente, Capitán, etc. |
| `observaciones` | string(255) | Observaciones |

---

## 🔗 Relaciones del Modelo

```php
// EstacionNovedad
- estacion()              → belongsTo(Station::class)
- usuarioCrea()           → belongsTo(User::class)
- usuarioAprueba()        → belongsTo(User::class)
- emergencias()           → hasMany(EstacionNovedadEmergencia::class)
- vehiculos()             → hasMany(EstacionNovedadVehiculo::class)
- personal()              → hasMany(EstacionNovedadPersonal::class)
- integrantes()           → hasMany(EstacionNovedadIntegrante::class)









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
