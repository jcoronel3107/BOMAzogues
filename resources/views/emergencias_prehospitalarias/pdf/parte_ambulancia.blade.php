<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Parte de Ambulancia - {{ $emergenciaPrehospitalaria->codigo }}</title>
    <style>
        @page {
            margin: 15mm 12mm 18mm 12mm;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #222;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        /* ====== HEADER ====== */
        .header {
            border: 2px solid #000;
            padding: 6px 8px;
            margin-bottom: 6px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
            padding: 2px 4px;
        }
        .logo-cell {
            width: 90px;
            text-align: center;
        }
        .logo-placeholder {
            width: 70px;
            height: 70px;
            border: 1.5px dashed #666;
            border-radius: 50%;
            line-height: 66px;
            font-size: 8px;
            color: #666;
            margin: 0 auto;
        }
        .titulo-cell {
            text-align: center;
        }
        .titulo-cell h1 {
            margin: 0;
            font-size: 15px;
            letter-spacing: 1px;
            color: #000;
        }
        .titulo-cell h2 {
            margin: 2px 0 0;
            font-size: 11px;
            color: #b91c1c;
            letter-spacing: 0.5px;
        }
        .titulo-cell p {
            margin: 3px 0 0;
            font-size: 8px;
            color: #555;
        }
        .codigo-cell {
            width: 130px;
            text-align: right;
            font-size: 9px;
        }
        .codigo-box {
            border: 1.5px solid #000;
            padding: 3px 6px;
            display: inline-block;
            font-weight: bold;
            font-size: 11px;
        }

        /* ====== SECCIONES ====== */
        .seccion {
            border: 1px solid #000;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }
        .seccion-titulo {
            background: #1e3a8a;
            color: #fff;
            font-weight: bold;
            font-size: 9px;
            padding: 3px 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .seccion-contenido {
            padding: 5px 6px;
        }

        /* ====== TABLAS DE DATOS ====== */
        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
        }
        .tabla-datos td {
            border: 1px solid #888;
            padding: 3px 5px;
            vertical-align: top;
            font-size: 9px;
        }
        .tabla-datos .label {
            background: #f0f0f0;
            font-weight: bold;
            width: 90px;
            font-size: 8px;
            color: #333;
            text-transform: uppercase;
        }

        /* ====== BADGES ====== */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 3px;
            color: #fff;
            text-transform: uppercase;
        }
        .badge-rojo     { background: #dc2626; }
        .badge-naranja  { background: #ea580c; }
        .badge-amarillo { background: #ca8a04; }
        .badge-verde    { background: #16a34a; }
        .badge-azul     { background: #2563eb; }
        .badge-gris     { background: #6b7280; }

        /* ====== PACIENTES ====== */
        .paciente-card {
            border: 1px solid #000;
            margin-bottom: 6px;
            page-break-inside: avoid;
        }
        .paciente-header {
            background: #fef3c7;
            border-bottom: 1px solid #000;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
        }
        .paciente-header-left  { color: #000; }
        .paciente-header-right { color: #b91c1c; font-size: 9px; }
        .paciente-body {
            padding: 5px 6px;
        }

        /* ====== SIGNOS VITALES (grid de cajitas) ===== */
        .signos-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .signos-grid td {
            border: 1px solid #555;
            padding: 3px;
            text-align: center;
            width: 16.66%;
        }
        .signos-grid .sv-label {
            font-size: 7px;
            color: #555;
            text-transform: uppercase;
            display: block;
            letter-spacing: 0.3px;
        }
        .signos-grid .sv-valor {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            display: block;
            margin-top: 1px;
        }
        .signos-grid .sv-unidad {
            font-size: 7px;
            color: #777;
        }

        /* ====== SUBTÍTULOS ====== */
        .subtitulo {
            background: #e5e7eb;
            font-size: 8px;
            font-weight: bold;
            padding: 2px 5px;
            text-transform: uppercase;
            border-left: 3px solid #1e3a8a;
            margin: 4px 0 3px;
            color: #1e3a8a;
        }

        /* ====== TEXTO LARGO ====== */
        .texto-largo {
            border: 1px solid #888;
            padding: 4px 6px;
            min-height: 22px;
            font-size: 9px;
            margin-bottom: 4px;
        }

        /* ====== TABLA INSUMOS ====== */
        .tabla-insumos {
            width: 100%;
            border-collapse: collapse;
        }
        .tabla-insumos th {
            background: #1e3a8a;
            color: #fff;
            font-size: 8px;
            padding: 3px 5px;
            border: 1px solid #000;
            text-transform: uppercase;
        }
        .tabla-insumos td {
            border: 1px solid #888;
            padding: 3px 5px;
            font-size: 9px;
        }
        .tabla-insumos tr:nth-child(even) td {
            background: #f9fafb;
        }

        /* ====== PERSONAL ====== */
        .personal-item {
            display: inline-block;
            margin-right: 12px;
            margin-bottom: 2px;
            font-size: 9px;
        }

        /* ====== FIRMAS ====== */
        .firmas {
            margin-top: 12px;
            page-break-inside: avoid;
        }
        .firmas-table {
            width: 100%;
            border-collapse: collapse;
        }
        .firmas-table td {
            width: 33.33%;
            text-align: center;
            padding: 5px 8px;
            vertical-align: bottom;
        }
        .firma-linea {
            border-top: 1px solid #000;
            margin-top: 35px;
            padding-top: 3px;
            font-size: 8px;
            color: #333;
        }
        .firma-linea strong {
            display: block;
            font-size: 9px;
        }

        /* ====== FOOTER ====== */
        .footer {
            position: fixed;
            bottom: 5mm;
            left: 12mm;
            right: 12mm;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 3px;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            padding: 0;
        }
        .page-num:after {
            content: "Página " counter(page) " de " counter(pages);
        }
    </style>
</head>
<body>

{{-- ============================================================
     HEADER
============================================================ --}}
<div class="header">
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <div class="logo-placeholder">LOGO</div>
            </td>
            <td class="titulo-cell">
                <h1>PARTE DE ATENCIÓN PREHOSPITALARIA</h1>
                <h2>SERVICIO DE AMBULANCIAS</h2>
                <p>Sistema de Registro de Emergencias Médicas</p>
            </td>
            <td class="codigo-cell">
                <div class="codigo-box">{{ $emergenciaPrehospitalaria->codigo }}</div>
                <div style="margin-top:3px;">
                    Fecha: {{ $emergenciaPrehospitalaria->created_at->format('d/m/Y') }}
                </div>
                <div>Hora: {{ $emergenciaPrehospitalaria->created_at->format('H:i') }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ============================================================
     1. DATOS GENERALES
============================================================ --}}
<div class="seccion">
    <div class="seccion-titulo">1. Datos Generales del Servicio</div>
    <div class="seccion-contenido">
        <table class="tabla-datos">
            <tr>
                <td class="label">Fecha Salida</td>
                <td>{{ $emergenciaPrehospitalaria->fecha_salida?->format('d/m/Y H:i') ?? '—' }}</td>
                <td class="label">Llegada Sitio</td>
                <td>{{ $emergenciaPrehospitalaria->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—' }}</td>
                <td class="label">Salida Sitio</td>
                <td>{{ $emergenciaPrehospitalaria->fecha_salida_sitio?->format('d/m/Y H:i') ?? '—' }}</td>
                <td class="label">Llegada Base</td>
                <td>{{ $emergenciaPrehospitalaria->fecha_llegada_base?->format('d/m/Y H:i') ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Vehículo</td>
                <td colspan="3">
                    🚑 <strong>{{ $emergenciaPrehospitalaria->vehiculo->placa ?? 'N/A' }}</strong>
                    — {{ $emergenciaPrehospitalaria->vehiculo->marca ?? '' }}
                    {{ $emergenciaPrehospitalaria->vehiculo->modelo ?? '' }}
                </td>
                <td class="label">Prioridad</td>
                <td>
                    @php
                        $claseBadge = [
                            'Rojo' => 'badge-rojo',
                            'Naranja' => 'badge-naranja',
                            'Amarillo' => 'badge-amarillo',
                            'Verde' => 'badge-verde',
                            'Azul' => 'badge-azul',
                        ][$emergenciaPrehospitalaria->prioridad] ?? 'badge-gris';
                    @endphp
                    <span class="badge {{ $claseBadge }}">
                        {{ $emergenciaPrehospitalaria->prioridad }}
                    </span>
                </td>
                <td class="label">Estado</td>
                <td>{{ $emergenciaPrehospitalaria->estado }}</td>
            </tr>
            <tr>
                <td class="label">Dirección</td>
                <td colspan="5">{{ $emergenciaPrehospitalaria->direccion }}</td>
                <td class="label">Referencia</td>
                <td>{{ $emergenciaPrehospitalaria->referencia ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Motivo Llamado</td>
                <td colspan="3">{{ $emergenciaPrehospitalaria->motivo_llamado }}</td>
                <td class="label">Tipo</td>
                <td colspan="3">{{ $emergenciaPrehospitalaria->tipo_emergencia }}</td>
            </tr>
        </table>

        {{-- Tiempos calculados --}}
        <table class="tabla-datos" style="margin-top:4px;">
            <tr>
                <td class="label">T. Respuesta</td>
                <td>{{ $tiempos['tiempo_respuesta'] !== null ? $tiempos['tiempo_respuesta'] . ' min' : '—' }}</td>
                <td class="label">T. en Sitio</td>
                <td>{{ $tiempos['tiempo_en_sitio'] !== null ? $tiempos['tiempo_en_sitio'] . ' min' : '—' }}</td>
                <td class="label">T. Traslado</td>
                <td>{{ $tiempos['tiempo_traslado'] !== null ? $tiempos['tiempo_traslado'] . ' min' : '—' }}</td>
                <td class="label">T. Total</td>
                <td><strong>{{ $tiempos['tiempo_total'] !== null ? $tiempos['tiempo_total'] . ' min' : '—' }}</strong></td>
            </tr>
        </table>
    </div>
</div>

{{-- ============================================================
     2. PERSONAL QUE ATENDIÓ
============================================================ --}}
<div class="seccion">
    <div class="seccion-titulo">2. Personal que Atendió</div>
    <div class="seccion-contenido">
        @forelse($emergenciaPrehospitalaria->personal as $p)
            <span class="personal-item">
                <strong>{{ $p->name }}</strong>
                <em>({{ $p->pivot->rol_en_emergencia }})</em>
            </span>
        @empty
            <span style="color:#888;">Sin personal registrado.</span>
        @endforelse
    </div>
</div>

{{-- ============================================================
     3. PACIENTES ATENDIDOS
============================================================ --}}
<div class="seccion">
    <div class="seccion-titulo">
        3. Pacientes Atendidos ({{ $emergenciaPrehospitalaria->pacientes->count() }})
    </div>
    <div class="seccion-contenido">

        @forelse($emergenciaPrehospitalaria->pacientes as $i => $pac)
            <div class="paciente-card">
                <div class="paciente-header">
                    <span class="paciente-header-left">
                        PACIENTE #{{ $i + 1 }} — {{ strtoupper($pac->nombre_completo) }}
                    </span>
                    <span class="paciente-header-right">
                        {{ $pac->edad }} años |
                        {{ $pac->sexo == 'M' ? 'Masculino' : ($pac->sexo == 'F' ? 'Femenino' : 'Indefinido') }}
                        @if($pac->cedula) | CI: {{ $pac->cedula }} @endif
                    </span>
                </div>

                <div class="paciente-body">

                    {{-- Signos Vitales --}}
                    <div class="subtitulo">Signos Vitales Prehospitalarios</div>
                    <table class="signos-grid">
                        <tr>
                            <td>
                                <span class="sv-label">FC</span>
                                <span class="sv-valor">{{ $pac->frecuencia_cardiaca ?? '—' }}</span>
                                <span class="sv-unidad">lpm</span>
                            </td>
                            <td>
                                <span class="sv-label">FR</span>
                                <span class="sv-valor">{{ $pac->frecuencia_respiratoria ?? '—' }}</span>
                                <span class="sv-unidad">rpm</span>
                            </td>
                            <td>
                                <span class="sv-label">SatO₂</span>
                                <span class="sv-valor">{{ $pac->saturacion_oxigeno ?? '—' }}</span>
                                <span class="sv-unidad">%</span>
                            </td>
                            <td>
                                <span class="sv-label">Temp</span>
                                <span class="sv-valor">{{ $pac->temperatura ?? '—' }}</span>
                                <span class="sv-unidad">°C</span>
                            </td>
                            <td>
                                <span class="sv-label">TA</span>
                                <span class="sv-valor">
                                    {{ $pac->presion_sistolica ?? '—' }}/{{ $pac->presion_diastolica ?? '—' }}
                                </span>
                                <span class="sv-unidad">mmHg</span>
                            </td>
                            <td>
                                <span class="sv-label">Glasgow</span>
                                <span class="sv-valor">{{ $pac->glasgow ?? '—' }}</span>
                                <span class="sv-unidad">/15</span>
                            </td>
                        </tr>
                    </table>

                    {{-- Evaluación --}}
                    <div class="subtitulo">Evaluación y Procedimientos</div>
                    <table class="tabla-datos" style="margin-bottom:4px;">
                        <tr>
                            <td class="label">Motivo Atención</td>
                            <td colspan="3">{{ $pac->motivo_atencion ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Evaluación</td>
                            <td colspan="3">{{ $pac->evaluacion ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Procedimientos</td>
                            <td colspan="3">{{ $pac->procedimientos_realizados ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Observaciones</td>
                            <td colspan="3">{{ $pac->observaciones ?? '—' }}</td>
                        </tr>
                    </table>

                    {{-- Destino --}}
                    <div class="subtitulo">Condición y Destino</div>
                    <table class="tabla-datos">
                        <tr>
                            <td class="label">Condición</td>
                            <td>
                                @php
                                    $condBadge = [
                                        'Estable' => 'badge-verde',
                                        'Crítico' => 'badge-rojo',
                                        'Fallecido' => 'badge-gris',
                                        'Rechaza atención' => 'badge-amarillo',
                                    ][$pac->condicion] ?? 'badge-gris';
                                @endphp
                                <span class="badge {{ $condBadge }}">{{ $pac->condicion }}</span>
                            </td>
                            <td class="label">Destino</td>
                            <td>{{ $pac->destino ?? '—' }}</td>
                            <td class="label">Hospital</td>
                            <td>{{ $pac->hospital_destino ?? '—' }}</td>
                        </tr>
                    </table>

                </div>
            </div>
        @empty
            <p style="text-align:center;color:#888;margin:0;">Sin pacientes registrados.</p>
        @endforelse

    </div>
</div>

{{-- ============================================================
     4. INSUMOS UTILIZADOS
============================================================ --}}
@if($emergenciaPrehospitalaria->insumos->count() > 0)
<div class="seccion">
    <div class="seccion-titulo">
        4. Insumos Utilizados ({{ $emergenciaPrehospitalaria->insumos->count() }})
    </div>
    <div class="seccion-contenido" style="padding:0;">
        <table class="tabla-insumos">
            <thead>
                <tr>
                    <th style="width:30px;">#</th>
                    <th>Insumo</th>
                    <th style="width:60px;text-align:center;">Cantidad</th>
                    <th style="width:100px;">Código</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emergenciaPrehospitalaria->insumos as $i => $ins)
                    <tr>
                        <td style="text-align:center;">{{ $i + 1 }}</td>
                        <td>{{ $ins->nombre }}</td>
                        <td style="text-align:center;"><strong>{{ $ins->pivot->cantidad }}</strong></td>
                        <td>{{ $ins->codigo ?? '—' }}</td>
                        <td>{{ $ins->pivot->observaciones ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ============================================================
     5. OBSERVACIONES GENERALES
============================================================ --}}
@if($emergenciaPrehospitalaria->observaciones_generales)
<div class="seccion">
    <div class="seccion-titulo">5. Observaciones Generales</div>
    <div class="seccion-contenido">
        <div class="texto-largo">{{ $emergenciaPrehospitalaria->observaciones_generales }}</div>
    </div>
</div>
@endif

{{-- ============================================================
     FIRMAS
============================================================ --}}
<div class="firmas">
    <table class="firmas-table">
        <tr>
            <td>
                <div class="firma-linea">
                    <strong>{{ $emergenciaPrehospitalaria->usuarioRegistra->name ?? 'Responsable del Registro' }}</strong>
                    Responsable del Registro
                </div>
            </td>
            <td>
                <div class="firma-linea">
                    <strong>{{ $emergenciaPrehospitalaria->personal->first()->name ?? 'Médico/Paramédico' }}</strong>
                    Médico / Paramédico Tratante
                </div>
            </td>
            <td>
                <div class="firma-linea">
                    <strong>Sello y Firma</strong>
                    Jefe de Servicio
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ============================================================
     FOOTER FIJO
============================================================ --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td>
                Documento generado automáticamente — {{ config('app.name', 'Sistema de Emergencias') }}
                | Código: {{ $emergenciaPrehospitalaria->codigo }}
            </td>
            <td style="text-align:right;">
                <span class="page-num"></span> |
                Impreso: {{ now()->format('d/m/Y H:i') }}
            </td>
        </tr>
    </table>
</div>

</body>
</html>