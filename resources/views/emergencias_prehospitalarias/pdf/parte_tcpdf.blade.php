<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parte de Ambulancia</title>
    <style>
    body {
        font-family: helvetica;
        font-size: 8px;
        color: #000;
        margin: 0;
        padding: 0;
    }
    h1 {
        font-size: 14px;
        color: #1e3a8a;
        text-align: center;
        margin: 0;
    }
    h2 {
        font-size: 11px;
        color: #b91c1c;
        text-align: center;
        margin: 2px 0;
    }
    h3 {
        font-size: 9px;
        background-color: #1e3a8a;
        color: #fff;
        padding: 3px;
        margin: 8px 0 3px 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .header-table {
        width: 100%;
        border-collapse: collapse;
        border: 1.5px solid #000;
    }
    .header-table td {
        padding: 4px;
        vertical-align: middle;
    }
    .titulo {
        text-align: center;
    }
    .codigo {
        border: 1.5px solid #000;
        padding: 2px 4px;
        font-weight: bold;
        font-size: 10px;
        text-align: center;
    }
    .datos-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
        table-layout: fixed;
    }
    .datos-table td {
        border: 1px solid #888;
        padding: 2px 4px;
        vertical-align: top;
        font-size: 7.5px;
        word-wrap: break-word;
    }
    .datos-table .label {
        background-color: #f0f0f0;
        font-weight: bold;
        width: 12%;
        font-size: 7px;
    }
    .signos-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        table-layout: fixed;
    }
    .signos-table td {
        border: 1px solid #555;
        padding: 3px;
        text-align: center;
        width: 16.66%;
    }
    .sv-label {
        font-size: 6.5px;
        color: #555;
    }
    .sv-valor {
        font-size: 11px;
        font-weight: bold;
    }
    .sv-unidad {
        font-size: 6.5px;
        color: #777;
    }
    .paciente-header {
        background-color: #fef3c7;
        border: 1px solid #000;
        padding: 3px 5px;
        font-weight: bold;
        font-size: 9px;
    }
    .paciente-body {
        border: 1px solid #000;
        padding: 4px;
        margin-bottom: 6px;
    }
    .insumos-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .insumos-table th {
        background-color: #1e3a8a;
        color: #fff;
        font-size: 7.5px;
        padding: 2px 4px;
        border: 1px solid #000;
    }
    .insumos-table td {
        border: 1px solid #888;
        padding: 2px 4px;
        font-size: 8px;
        word-wrap: break-word;
    }
    .badge {
        padding: 1px 4px;
        font-size: 7.5px;
        font-weight: bold;
        color: #fff;
    }
    .badge-rojo     { background-color: #dc2626; }
    .badge-naranja  { background-color: #ea580c; }
    .badge-amarillo { background-color: #ca8a04; }
    .badge-verde    { background-color: #16a34a; }
    .badge-azul     { background-color: #2563eb; }
    .badge-gris     { background-color: #6b7280; }
    .firmas-table {
        width: 100%;
        margin-top: 20px;
    }
    .firmas-table td {
        width: 33%;
        text-align: center;
        padding: 4px;
    }
    .firma-linea {
        border-top: 1px solid #000;
        padding-top: 3px;
        font-size: 7.5px;
    }
    .texto-largo {
        word-wrap: break-word;
        word-break: break-word;
    }
</style>
</head>
<body>

{{-- ===== HEADER ===== --}}
<table class="header-table">
    <tr>
        <td style="width: 15%; text-align: center;">
            <div style="border: 1px dashed #666; width: 60px; height: 60px; line-height: 60px; font-size: 8px; color: #666;">
                LOGO
            </div>
        </td>
        <td class="titulo" style="width: 60%;">
            <h1>PARTE DE ATENCIÓN PREHOSPITALARIA</h1>
            <h2>SERVICIO DE AMBULANCIAS</h2>
            <p style="font-size: 8px; color: #555; margin: 2px 0;">Sistema de Registro de Emergencias Médicas</p>
        </td>
        <td style="width: 25%; text-align: right;">
            <div class="codigo">{{ $emergenciaPrehospitalaria->codigo }}</div>
            <p style="font-size: 8px; margin: 3px 0;">Fecha: {{ $emergenciaPrehospitalaria->created_at->format('d/m/Y') }}</p>
            <p style="font-size: 8px; margin: 0;">Hora: {{ $emergenciaPrehospitalaria->created_at->format('H:i') }}</p>
        </td>
    </tr>
</table>

{{-- ===== 1. DATOS GENERALES ===== --}}
<h3>1. DATOS GENERALES DEL SERVICIO</h3>
<table class="datos-table">
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
            <strong>{{ $emergenciaPrehospitalaria->vehiculo->placa ?? 'N/A' }}</strong>
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
            <span class="badge {{ $claseBadge }}">{{ $emergenciaPrehospitalaria->prioridad }}</span>
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

{{-- ===== Tiempos ===== --}}
<table class="datos-table">
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

{{-- ===== 2. PERSONAL ===== --}}
<h3>2. PERSONAL QUE ATENDIÓ</h3>
<table class="datos-table">
    <tr>
        @forelse($emergenciaPrehospitalaria->personal as $p)
            <td>
                <strong>{{ $p->name }}</strong>
                <em>({{ $p->pivot->rol_en_emergencia }})</em>
            </td>
        @empty
            <td>Sin personal registrado.</td>
        @endforelse
    </tr>
</table>

{{-- ===== 3. PACIENTES ===== --}}
<h3>3. PACIENTES ATENDIDOS ({{ $emergenciaPrehospitalaria->pacientes->count() }})</h3>

@forelse($emergenciaPrehospitalaria->pacientes as $i => $pac)
    <div class="paciente-header">
        PACIENTE #{{ $i + 1 }} — {{ strtoupper($pac->nombre_completo) }}
        | {{ $pac->edad }} años
        | {{ $pac->sexo == 'M' ? 'Masculino' : ($pac->sexo == 'F' ? 'Femenino' : 'Indefinido') }}
        @if($pac->cedula) | CI: {{ $pac->cedula }} @endif
    </div>

    <div class="paciente-body">
        {{-- Signos Vitales --}}
        <p style="font-weight: bold; background-color: #e5e7eb; padding: 2px 5px; margin: 4px 0; font-size: 8px;">
            SIGNOS VITALES PREHOSPITALARIOS
        </p>
        <table class="signos-table">
            <tr>
                <td>
                    <span class="sv-label">FC</span><br>
                    <span class="sv-valor">{{ $pac->frecuencia_cardiaca ?? '—' }}</span><br>
                    <span class="sv-unidad">lpm</span>
                </td>
                <td>
                    <span class="sv-label">FR</span><br>
                    <span class="sv-valor">{{ $pac->frecuencia_respiratoria ?? '—' }}</span><br>
                    <span class="sv-unidad">rpm</span>
                </td>
                <td>
                    <span class="sv-label">SatO₂</span><br>
                    <span class="sv-valor">{{ $pac->saturacion_oxigeno ?? '—' }}</span><br>
                    <span class="sv-unidad">%</span>
                </td>
                <td>
                    <span class="sv-label">Temp</span><br>
                    <span class="sv-valor">{{ $pac->temperatura ?? '—' }}</span><br>
                    <span class="sv-unidad">°C</span>
                </td>
                <td>
                    <span class="sv-label">TA</span><br>
                    <span class="sv-valor">{{ $pac->presion_sistolica ?? '—' }}/{{ $pac->presion_diastolica ?? '—' }}</span><br>
                    <span class="sv-unidad">mmHg</span>
                </td>
                <td>
                    <span class="sv-label">Glasgow</span><br>
                    <span class="sv-valor">{{ $pac->glasgow ?? '—' }}</span><br>
                    <span class="sv-unidad">/15</span>
                </td>
            </tr>
        </table>

        {{-- Evaluación --}}
        <p style="font-weight: bold; background-color: #e5e7eb; padding: 2px 5px; margin: 4px 0; font-size: 8px;">
            EVALUACIÓN Y PROCEDIMIENTOS
        </p>
        <table class="datos-table">
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
            <tr>
                <td class="label">Condición</td>
                <td>{{ $pac->condicion }}</td>
                <td class="label">Destino</td>
                <td>{{ $pac->destino ?? '—' }} {{ $pac->hospital_destino ? ' - ' . $pac->hospital_destino : '' }}</td>
            </tr>
        </table>
    </div>
@empty
    <p style="text-align:center; color:#888;">Sin pacientes registrados.</p>
@endforelse

{{-- ===== 4. INSUMOS ===== --}}
@if($emergenciaPrehospitalaria->insumos->count() > 0)
    <h3>4. INSUMOS UTILIZADOS ({{ $emergenciaPrehospitalaria->insumos->count() }})</h3>
    <table class="insumos-table">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Insumo</th>
                <th style="width: 60px;">Cantidad</th>
                <th style="width: 100px;">Código</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emergenciaPrehospitalaria->insumos as $i => $ins)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
                    <td>{{ $ins->descripcion }}</td>
                    <td style="text-align:center;"><strong>{{ $ins->pivot->cantidad }}</strong></td>
                    <td>{{ $ins->codigo ?? '—' }}</td>
                    <td>{{ $ins->pivot->observaciones ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ===== 5. OBSERVACIONES GENERALES ===== --}}
@if($emergenciaPrehospitalaria->observaciones_generales)
    <h3>5. OBSERVACIONES GENERALES</h3>
    <div style="border: 1px solid #888; padding: 5px; min-height: 25px;">
        {{ $emergenciaPrehospitalaria->observaciones_generales }}
    </div>
@endif

{{-- ===== FIRMAS ===== --}}
<table class="firmas-table">
    <tr>
        <td>
            <div class="firma-linea">
                <strong>{{ $emergenciaPrehospitalaria->usuarioRegistra->name ?? 'Responsable' }}</strong><br>
                Responsable del Registro
            </div>
        </td>
        <td>
            <div class="firma-linea">
                <strong>{{ $emergenciaPrehospitalaria->personal->first()->name ?? 'Médico/Paramédico' }}</strong><br>
                Médico / Paramédico Tratante
            </div>
        </td>
        <td>
            <div class="firma-linea">
                <strong>Sello y Firma</strong><br>
                Jefe de Servicio
            </div>
        </td>
    </tr>
</table>

</body>
</html>