<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parte de Bomberos</title>
    <style>
        body {
            font-family: helvetica;
            font-size: 9px;
            color: #000;
        }
        h1 {
            font-size: 15px;
            color: #b91c1c;
            text-align: center;
            margin: 0;
        }
        h2 {
            font-size: 11px;
            color: #1e3a8a;
            text-align: center;
            margin: 2px 0;
        }
        h3 {
            font-size: 10px;
            background-color: #dbacac;
            color: #fff;
            padding: 3px;
            margin: 8px 0 3px 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }
        .header-table td {
            padding: 5px;
            vertical-align: middle;
        }
        .titulo {
            text-align: center;
        }
        .codigo {
            border: 1.5px solid #000;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
        }
        .datos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .datos-table td {
            border: 1px solid #888;
            padding: 3px 5px;
            vertical-align: top;
            font-size: 8px;
            word-wrap: break-word;
        }
        .datos-table .label {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 15%;
            font-size: 7.5px;
        }
        .insumos-table {
            width: 100%;
            border-collapse: collapse;
        }
        .insumos-table th {
            background-color: #dbacac;
            color: #fff;
            font-size: 8px;
            padding: 3px 5px;
            border: 1px solid #000;
        }
        .insumos-table td {
            border: 1px solid #888;
            padding: 3px 5px;
            font-size: 8px;
        }
        .badge {
            padding: 2px 5px;
            font-size: 8px;
            font-weight: bold;
            color: #fff;
        }
        .badge-verde    { background-color: #198754; }
        .badge-info     { background-color: #0dcaf0; color: #000; }
        .badge-amarillo { background-color: #ffc107; color: #000; }
        .badge-rojo     { background-color: #dc3545; }
        .badge-gris     { background-color: #6c757d; }
        .firmas-table {
            width: 100%;
             margin-top: 50px;  /* ⬅️ Aumentado de 20px a 50px */
        }
        .firmas-table td {
            width: 33%;
            text-align: center;
            padding: 5px;
             vertical-align: bottom;
             height: 120px;  /* ⬅️ Altura mínima para la rúbrica */
        }
        .firma-linea {
            border-top: 1px solid #000;
            padding-top: 5px;  /* ⬅️ Más espacio entre la línea y el texto */
            font-size: 8px;
            margin-top: 70px;  /* ⬅️ Espacio para la firma encima de la línea */
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
            <h1>PARTE DE ATENCIÓN DE INCENDIOS</h1>
            <h2>CUERPO DE BOMBEROS</h2>
            <p style="font-size: 8px; color: #555; margin: 2px 0;">Sistema de Registro de Emergencias de Fuego</p>
        </td>
        <td style="width: 25%; text-align: right;">
            <div class="codigo">{{ $emergenciaFuego->codigo }}</div>
            <p style="font-size: 8px; margin: 3px 0;">Fecha: {{ $emergenciaFuego->created_at->format('d/m/Y') }}</p>
            <p style="font-size: 8px; margin: 0;">Hora: {{ $emergenciaFuego->created_at->format('H:i') }}</p>
        </td>
    </tr>
</table>

{{-- ===== 1. DATOS GENERALES ===== --}}
<h3>1. DATOS GENERALES DEL SERVICIO</h3>
<table class="datos-table">
    <tr>
        <td class="label">Fecha Salida</td>
        <td>{{ $emergenciaFuego->fecha_salida?->format('d/m/Y H:i') ?? '—' }}</td>
        <td class="label">Llegada Sitio</td>
        <td>{{ $emergenciaFuego->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—' }}</td>
        <td class="label">Control</td>
        <td>{{ $emergenciaFuego->fecha_control?->format('d/m/Y H:i') ?? '—' }}</td>
    </tr>
    <tr>
        <td class="label">Extinción</td>
        <td>{{ $emergenciaFuego->fecha_extincion?->format('d/m/Y H:i') ?? '—' }}</td>
        <td class="label">Llegada Base</td>
        <td>{{ $emergenciaFuego->fecha_llegada_base?->format('d/m/Y H:i') ?? '—' }}</td>
        <td class="label">Tiempo Total</td>
        <td><strong>{{ $tiempos['tiempo_total'] !== null ? $tiempos['tiempo_total'] . ' min' : '—' }}</strong></td>
    </tr>
    <tr>
        <td class="label">Dirección</td>
        <td colspan="3">{{ $emergenciaFuego->direccion }}</td>
        <td class="label">Referencia</td>
        <td>{{ $emergenciaFuego->referencia ?? '—' }}</td>
    </tr>
    <tr>
        <td class="label">Parroquia</td>
        <td>{{ $emergenciaFuego->parroquia ?? '—' }}</td>
        <td class="label">Sector</td>
        <td>{{ $emergenciaFuego->sector ?? '—' }}</td>
        <td class="label">Motivo</td>
        <td>{{ $emergenciaFuego->motivo_llamado }}</td>
    </tr>
    <tr>
        <td class="label">Tipo de Fuego</td>
        <td><strong>{{ $emergenciaFuego->tipo_fuego }}</strong></td>
        <td class="label">Nivel de Riesgo</td>
        <td>
            @php
                $claseBadge = [
                    'Bajo' => 'badge-verde',
                    'Medio' => 'badge-info',
                    'Alto' => 'badge-amarillo',
                    'Crítico' => 'badge-rojo',
                ][$emergenciaFuego->nivel_riesgo] ?? 'badge-gris';
            @endphp
            <span class="badge {{ $claseBadge }}">{{ $emergenciaFuego->nivel_riesgo }}</span>
        </td>
        <td class="label">Causa Probable</td>
        <td>{{ $emergenciaFuego->causa_probable ?? '—' }}</td>
    </tr>
    <tr>
        <td class="label">Área Afectada</td>
        <td>{{ $emergenciaFuego->area_afectada_m2 ?? '—' }} m²</td>
        <td class="label">Pérdidas Estimadas</td>
        <td>{{ $emergenciaFuego->perdidas_estimadas ? '$ ' . number_format($emergenciaFuego->perdidas_estimadas, 2) : '—' }}</td>
        <td class="label">Estado</td>
        <td>{{ $emergenciaFuego->estado }}</td>
    </tr>
</table>

{{-- ===== 2. RECURSOS UTILIZADOS ===== --}}
<h3>2. RECURSOS UTILIZADOS</h3>
<table class="datos-table">
    <tr>
        <td class="label">Agua</td>
        <td>{{ $emergenciaFuego->agua_utilizada_litros ?? '—' }} litros</td>
        <td class="label">Espuma</td>
        <td>{{ $emergenciaFuego->espuma_utilizada_litros ?? '—' }} litros</td>
        <td class="label">Químico</td>
        <td>{{ $emergenciaFuego->quimico_utilizado_litros ?? '—' }} litros</td>
    </tr>
    <tr>
        <td class="label">Víctimas Ilesos</td>
        <td>{{ $emergenciaFuego->victimas_ilesos ?? 0 }}</td>
        <td class="label">Víctimas Heridos</td>
        <td><strong style="color: #ffc107;">{{ $emergenciaFuego->victimas_heridos ?? 0 }}</strong></td>
        <td class="label">Víctimas Fallecidos</td>
        <td><strong style="color: #dc3545;">{{ $emergenciaFuego->victimas_fallecidos ?? 0 }}</strong></td>
    </tr>
    @if($emergenciaFuego->requirio_apoyo_externo)
        <tr>
            <td class="label">Apoyo Externo</td>
            <td colspan="5">
                <strong>SÍ</strong>
                @if($emergenciaFuego->detalle_apoyo)
                    — {{ $emergenciaFuego->detalle_apoyo }}
                @endif
            </td>
        </tr>
    @endif
</table>

{{-- ===== 3. VEHÍCULOS ===== --}}
<h3>3. VEHÍCULOS UTILIZADOS ({{ $emergenciaFuego->vehiculos->count() }})</h3>
@if($emergenciaFuego->vehiculos->isEmpty())
    <p style="text-align:center; color:#888;">Sin vehículos registrados.</p>
@else
    <table class="insumos-table">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Placa</th>
                <th>Marca / Modelo</th>
                <th>Rol</th>
                <th style="width:80px;">Km Salida</th>
                <th style="width:80px;">Km Llegada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emergenciaFuego->vehiculos as $i => $v)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
                    <td><strong>{{ $v->placa }}</strong></td>
                    <td>{{ $v->marca ?? '' }} {{ $v->modelo ?? '' }}</td>
                    <td>{{ $v->pivot->rol_en_emergencia ?? '—' }}</td>
                    <td>{{ $v->pivot->km_salida ?? '—' }}</td>
                    <td>{{ $v->pivot->km_llegada ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ===== 4. PERSONAL ===== --}}
<h3>4. PERSONAL QUE ATENDIÓ ({{ $emergenciaFuego->personal->count() }})</h3>
@if($emergenciaFuego->personal->isEmpty())
    <p style="text-align:center; color:#888;">Sin personal registrado.</p>
@else
    <table class="insumos-table">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol en la Emergencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emergenciaFuego->personal as $i => $p)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->pivot->rol_en_emergencia }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ===== 5. PACIENTES ===== --}}
@if($emergenciaFuego->pacientes->count() > 0)
    <h3>5. PACIENTES / VÍCTIMAS ({{ $emergenciaFuego->pacientes->count() }})</h3>
    <table class="insumos-table">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Nombre</th>
                <th style="width:50px;">Edad</th>
                <th style="width:50px;">Sexo</th>
                <th>Condición</th>
                <th>Tipo Lesión</th>
                <th>Hospital Destino</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emergenciaFuego->pacientes as $i => $pac)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
                    <td><strong>{{ $pac->nombre_completo }}</strong></td>
                    <td>{{ $pac->edad ?? '—' }}</td>
                    <td>{{ $pac->sexo }}</td>
                    <td>{{ $pac->condicion }}</td>
                    <td>{{ $pac->tipo_lesion ?? '—' }}</td>
                    <td>{{ $pac->hospital_destino ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ===== 6. INSUMOS ===== --}}
@if($emergenciaFuego->insumos->count() > 0)
    <h3>6. INSUMOS UTILIZADOS ({{ $emergenciaFuego->insumos->count() }})</h3>
    <table class="insumos-table">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Insumo</th>
                <th style="width:80px;">Cantidad</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emergenciaFuego->insumos as $i => $ins)
                <tr>
                    <td style="text-align:center;">{{ $i + 1 }}</td>
                    <td>{{ $ins->descripcion }}</td>
                    <td style="text-align:center;"><strong>{{ $ins->pivot->cantidad }}</strong></td>
                    <td>{{ $ins->pivot->observaciones ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ===== 7. OBSERVACIONES ===== --}}
@if($emergenciaFuego->observaciones_generales)
    <h3>7. OBSERVACIONES GENERALES</h3>
    <div style="border: 1px solid #dbacac; padding: 5px; min-height: 25px; font-size: 9px;">
        {{ $emergenciaFuego->observaciones_generales }}
    </div>
@endif

{{-- ===== FIRMAS ===== --}}
<table class="firmas-table" cellspacing="15" cellpadding="10">
    <tr>
        <td>
            <div class="firma-linea">
                <strong>{{ $emergenciaFuego->usuarioRegistra->name ?? 'Responsable' }}</strong><br>
                Responsable del Registro
            </div>
        </td>
        <td>
            <div class="firma-linea">
                <strong>{{ $emergenciaFuego->personal->first()->name ?? 'Jefe de Incidente' }}</strong><br>
                Jefe de Incidente
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