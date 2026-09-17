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
            <div class="codigo"><?php echo e($emergenciaPrehospitalaria->codigo); ?></div>
            <p style="font-size: 8px; margin: 3px 0;">Fecha: <?php echo e($emergenciaPrehospitalaria->created_at->format('d/m/Y')); ?></p>
            <p style="font-size: 8px; margin: 0;">Hora: <?php echo e($emergenciaPrehospitalaria->created_at->format('H:i')); ?></p>
        </td>
    </tr>
</table>


<h3>1. DATOS GENERALES DEL SERVICIO</h3>
<table class="datos-table">
    <tr>
        <td class="label">Fecha Salida</td>
        <td><?php echo e($emergenciaPrehospitalaria->fecha_salida?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Llegada Sitio</td>
        <td><?php echo e($emergenciaPrehospitalaria->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Salida Sitio</td>
        <td><?php echo e($emergenciaPrehospitalaria->fecha_salida_sitio?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Llegada Base</td>
        <td><?php echo e($emergenciaPrehospitalaria->fecha_llegada_base?->format('d/m/Y H:i') ?? '—'); ?></td>
    </tr>
    <tr>
        <td class="label">Vehículo</td>
        <td colspan="3">
            <strong><?php echo e($emergenciaPrehospitalaria->vehiculo->placa ?? 'N/A'); ?></strong>
            — <?php echo e($emergenciaPrehospitalaria->vehiculo->marca ?? ''); ?>

            <?php echo e($emergenciaPrehospitalaria->vehiculo->modelo ?? ''); ?>

        </td>
        <td class="label">Prioridad</td>
        <td>
            <?php
                $claseBadge = [
                    'Rojo' => 'badge-rojo',
                    'Naranja' => 'badge-naranja',
                    'Amarillo' => 'badge-amarillo',
                    'Verde' => 'badge-verde',
                    'Azul' => 'badge-azul',
                ][$emergenciaPrehospitalaria->prioridad] ?? 'badge-gris';
            ?>
            <span class="badge <?php echo e($claseBadge); ?>"><?php echo e($emergenciaPrehospitalaria->prioridad); ?></span>
        </td>
        <td class="label">Estado</td>
        <td><?php echo e($emergenciaPrehospitalaria->estado); ?></td>
    </tr>
    <tr>
        <td class="label">Dirección</td>
        <td colspan="5"><?php echo e($emergenciaPrehospitalaria->direccion); ?></td>
        <td class="label">Referencia</td>
        <td><?php echo e($emergenciaPrehospitalaria->referencia ?? '—'); ?></td>
    </tr>
    <tr>
        <td class="label">Motivo Llamado</td>
        <td colspan="3"><?php echo e($emergenciaPrehospitalaria->motivo_llamado); ?></td>
        <td class="label">Tipo</td>
        <td colspan="3"><?php echo e($emergenciaPrehospitalaria->tipo_emergencia); ?></td>
    </tr>
</table>


<table class="datos-table">
    <tr>
        <td class="label">T. Respuesta</td>
        <td><?php echo e($tiempos['tiempo_respuesta'] !== null ? $tiempos['tiempo_respuesta'] . ' min' : '—'); ?></td>
        <td class="label">T. en Sitio</td>
        <td><?php echo e($tiempos['tiempo_en_sitio'] !== null ? $tiempos['tiempo_en_sitio'] . ' min' : '—'); ?></td>
        <td class="label">T. Traslado</td>
        <td><?php echo e($tiempos['tiempo_traslado'] !== null ? $tiempos['tiempo_traslado'] . ' min' : '—'); ?></td>
        <td class="label">T. Total</td>
        <td><strong><?php echo e($tiempos['tiempo_total'] !== null ? $tiempos['tiempo_total'] . ' min' : '—'); ?></strong></td>
    </tr>
</table>


<h3>2. PERSONAL QUE ATENDIÓ</h3>
<table class="datos-table">
    <tr>
        <?php $__empty_1 = true; $__currentLoopData = $emergenciaPrehospitalaria->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <td>
                <strong><?php echo e($p->name); ?></strong>
                <em>(<?php echo e($p->pivot->rol_en_emergencia); ?>)</em>
            </td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <td>Sin personal registrado.</td>
        <?php endif; ?>
    </tr>
</table>


<h3>3. PACIENTES ATENDIDOS (<?php echo e($emergenciaPrehospitalaria->pacientes->count()); ?>)</h3>

<?php $__empty_1 = true; $__currentLoopData = $emergenciaPrehospitalaria->pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="paciente-header">
        PACIENTE #<?php echo e($i + 1); ?> — <?php echo e(strtoupper($pac->nombre_completo)); ?>

        | <?php echo e($pac->edad); ?> años
        | <?php echo e($pac->sexo == 'M' ? 'Masculino' : ($pac->sexo == 'F' ? 'Femenino' : 'Indefinido')); ?>

        <?php if($pac->cedula): ?> | CI: <?php echo e($pac->cedula); ?> <?php endif; ?>
    </div>

    <div class="paciente-body">
        
        <p style="font-weight: bold; background-color: #e5e7eb; padding: 2px 5px; margin: 4px 0; font-size: 8px;">
            SIGNOS VITALES PREHOSPITALARIOS
        </p>
        <table class="signos-table">
            <tr>
                <td>
                    <span class="sv-label">FC</span><br>
                    <span class="sv-valor"><?php echo e($pac->frecuencia_cardiaca ?? '—'); ?></span><br>
                    <span class="sv-unidad">lpm</span>
                </td>
                <td>
                    <span class="sv-label">FR</span><br>
                    <span class="sv-valor"><?php echo e($pac->frecuencia_respiratoria ?? '—'); ?></span><br>
                    <span class="sv-unidad">rpm</span>
                </td>
                <td>
                    <span class="sv-label">SatO₂</span><br>
                    <span class="sv-valor"><?php echo e($pac->saturacion_oxigeno ?? '—'); ?></span><br>
                    <span class="sv-unidad">%</span>
                </td>
                <td>
                    <span class="sv-label">Temp</span><br>
                    <span class="sv-valor"><?php echo e($pac->temperatura ?? '—'); ?></span><br>
                    <span class="sv-unidad">°C</span>
                </td>
                <td>
                    <span class="sv-label">TA</span><br>
                    <span class="sv-valor"><?php echo e($pac->presion_sistolica ?? '—'); ?>/<?php echo e($pac->presion_diastolica ?? '—'); ?></span><br>
                    <span class="sv-unidad">mmHg</span>
                </td>
                <td>
                    <span class="sv-label">Glasgow</span><br>
                    <span class="sv-valor"><?php echo e($pac->glasgow ?? '—'); ?></span><br>
                    <span class="sv-unidad">/15</span>
                </td>
            </tr>
        </table>

        
        <p style="font-weight: bold; background-color: #e5e7eb; padding: 2px 5px; margin: 4px 0; font-size: 8px;">
            EVALUACIÓN Y PROCEDIMIENTOS
        </p>
        <table class="datos-table">
            <tr>
                <td class="label">Motivo Atención</td>
                <td colspan="3"><?php echo e($pac->motivo_atencion ?? '—'); ?></td>
            </tr>
            <tr>
                <td class="label">Evaluación</td>
                <td colspan="3"><?php echo e($pac->evaluacion ?? '—'); ?></td>
            </tr>
            <tr>
                <td class="label">Procedimientos</td>
                <td colspan="3"><?php echo e($pac->procedimientos_realizados ?? '—'); ?></td>
            </tr>
            <tr>
                <td class="label">Observaciones</td>
                <td colspan="3"><?php echo e($pac->observaciones ?? '—'); ?></td>
            </tr>
            <tr>
                <td class="label">Condición</td>
                <td><?php echo e($pac->condicion); ?></td>
                <td class="label">Destino</td>
                <td><?php echo e($pac->destino ?? '—'); ?> <?php echo e($pac->hospital_destino ? ' - ' . $pac->hospital_destino : ''); ?></td>
            </tr>
        </table>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p style="text-align:center; color:#888;">Sin pacientes registrados.</p>
<?php endif; ?>


<?php if($emergenciaPrehospitalaria->insumos->count() > 0): ?>
    <h3>4. INSUMOS UTILIZADOS (<?php echo e($emergenciaPrehospitalaria->insumos->count()); ?>)</h3>
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
            <?php $__currentLoopData = $emergenciaPrehospitalaria->insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="text-align:center;"><?php echo e($i + 1); ?></td>
                    <td><?php echo e($ins->descripcion); ?></td>
                    <td style="text-align:center;"><strong><?php echo e($ins->pivot->cantidad); ?></strong></td>
                    <td><?php echo e($ins->codigo ?? '—'); ?></td>
                    <td><?php echo e($ins->pivot->observaciones ?? '—'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>


<?php if($emergenciaPrehospitalaria->observaciones_generales): ?>
    <h3>5. OBSERVACIONES GENERALES</h3>
    <div style="border: 1px solid #888; padding: 5px; min-height: 25px;">
        <?php echo e($emergenciaPrehospitalaria->observaciones_generales); ?>

    </div>
<?php endif; ?>


<table class="firmas-table">
    <tr>
        <td>
            <div class="firma-linea">
                <strong><?php echo e($emergenciaPrehospitalaria->usuarioRegistra->name ?? 'Responsable'); ?></strong><br>
                Responsable del Registro
            </div>
        </td>
        <td>
            <div class="firma-linea">
                <strong><?php echo e($emergenciaPrehospitalaria->personal->first()->name ?? 'Médico/Paramédico'); ?></strong><br>
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
</html><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_prehospitalarias/pdf/parte_tcpdf.blade.php ENDPATH**/ ?>