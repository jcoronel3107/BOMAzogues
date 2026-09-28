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
            <div class="codigo"><?php echo e($emergenciaFuego->codigo); ?></div>
            <p style="font-size: 8px; margin: 3px 0;">Fecha: <?php echo e($emergenciaFuego->created_at->format('d/m/Y')); ?></p>
            <p style="font-size: 8px; margin: 0;">Hora: <?php echo e($emergenciaFuego->created_at->format('H:i')); ?></p>
        </td>
    </tr>
</table>


<h3>1. DATOS GENERALES DEL SERVICIO</h3>
<table class="datos-table">
    <tr>
        <td class="label">Fecha Salida</td>
        <td><?php echo e($emergenciaFuego->fecha_salida?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Llegada Sitio</td>
        <td><?php echo e($emergenciaFuego->fecha_llegada_sitio?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Control</td>
        <td><?php echo e($emergenciaFuego->fecha_control?->format('d/m/Y H:i') ?? '—'); ?></td>
    </tr>
    <tr>
        <td class="label">Extinción</td>
        <td><?php echo e($emergenciaFuego->fecha_extincion?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Llegada Base</td>
        <td><?php echo e($emergenciaFuego->fecha_llegada_base?->format('d/m/Y H:i') ?? '—'); ?></td>
        <td class="label">Tiempo Total</td>
        <td><strong><?php echo e($tiempos['tiempo_total'] !== null ? $tiempos['tiempo_total'] . ' min' : '—'); ?></strong></td>
    </tr>
    <tr>
        <td class="label">Dirección</td>
        <td colspan="3"><?php echo e($emergenciaFuego->direccion); ?></td>
        <td class="label">Referencia</td>
        <td><?php echo e($emergenciaFuego->referencia ?? '—'); ?></td>
    </tr>
    <tr>
        <td class="label">Parroquia</td>
        <td><?php echo e($emergenciaFuego->parroquia ?? '—'); ?></td>
        <td class="label">Sector</td>
        <td><?php echo e($emergenciaFuego->sector ?? '—'); ?></td>
        <td class="label">Motivo</td>
        <td><?php echo e($emergenciaFuego->motivo_llamado); ?></td>
    </tr>
    <tr>
        <td class="label">Tipo de Fuego</td>
        <td><strong><?php echo e($emergenciaFuego->tipo_fuego); ?></strong></td>
        <td class="label">Nivel de Riesgo</td>
        <td>
            <?php
                $claseBadge = [
                    'Bajo' => 'badge-verde',
                    'Medio' => 'badge-info',
                    'Alto' => 'badge-amarillo',
                    'Crítico' => 'badge-rojo',
                ][$emergenciaFuego->nivel_riesgo] ?? 'badge-gris';
            ?>
            <span class="badge <?php echo e($claseBadge); ?>"><?php echo e($emergenciaFuego->nivel_riesgo); ?></span>
        </td>
        <td class="label">Causa Probable</td>
        <td><?php echo e($emergenciaFuego->causa_probable ?? '—'); ?></td>
    </tr>
    <tr>
        <td class="label">Área Afectada</td>
        <td><?php echo e($emergenciaFuego->area_afectada_m2 ?? '—'); ?> m²</td>
        <td class="label">Pérdidas Estimadas</td>
        <td><?php echo e($emergenciaFuego->perdidas_estimadas ? '$ ' . number_format($emergenciaFuego->perdidas_estimadas, 2) : '—'); ?></td>
        <td class="label">Estado</td>
        <td><?php echo e($emergenciaFuego->estado); ?></td>
    </tr>
</table>


<h3>2. RECURSOS UTILIZADOS</h3>
<table class="datos-table">
    <tr>
        <td class="label">Agua</td>
        <td><?php echo e($emergenciaFuego->agua_utilizada_litros ?? '—'); ?> litros</td>
        <td class="label">Espuma</td>
        <td><?php echo e($emergenciaFuego->espuma_utilizada_litros ?? '—'); ?> litros</td>
        <td class="label">Químico</td>
        <td><?php echo e($emergenciaFuego->quimico_utilizado_litros ?? '—'); ?> litros</td>
    </tr>
    <tr>
        <td class="label">Víctimas Ilesos</td>
        <td><?php echo e($emergenciaFuego->victimas_ilesos ?? 0); ?></td>
        <td class="label">Víctimas Heridos</td>
        <td><strong style="color: #ffc107;"><?php echo e($emergenciaFuego->victimas_heridos ?? 0); ?></strong></td>
        <td class="label">Víctimas Fallecidos</td>
        <td><strong style="color: #dc3545;"><?php echo e($emergenciaFuego->victimas_fallecidos ?? 0); ?></strong></td>
    </tr>
    <?php if($emergenciaFuego->requirio_apoyo_externo): ?>
        <tr>
            <td class="label">Apoyo Externo</td>
            <td colspan="5">
                <strong>SÍ</strong>
                <?php if($emergenciaFuego->detalle_apoyo): ?>
                    — <?php echo e($emergenciaFuego->detalle_apoyo); ?>

                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
</table>


<h3>3. VEHÍCULOS UTILIZADOS (<?php echo e($emergenciaFuego->vehiculos->count()); ?>)</h3>
<?php if($emergenciaFuego->vehiculos->isEmpty()): ?>
    <p style="text-align:center; color:#888;">Sin vehículos registrados.</p>
<?php else: ?>
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
            <?php $__currentLoopData = $emergenciaFuego->vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="text-align:center;"><?php echo e($i + 1); ?></td>
                    <td><strong><?php echo e($v->placa); ?></strong></td>
                    <td><?php echo e($v->marca ?? ''); ?> <?php echo e($v->modelo ?? ''); ?></td>
                    <td><?php echo e($v->pivot->rol_en_emergencia ?? '—'); ?></td>
                    <td><?php echo e($v->pivot->km_salida ?? '—'); ?></td>
                    <td><?php echo e($v->pivot->km_llegada ?? '—'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>


<h3>4. PERSONAL QUE ATENDIÓ (<?php echo e($emergenciaFuego->personal->count()); ?>)</h3>
<?php if($emergenciaFuego->personal->isEmpty()): ?>
    <p style="text-align:center; color:#888;">Sin personal registrado.</p>
<?php else: ?>
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
            <?php $__currentLoopData = $emergenciaFuego->personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="text-align:center;"><?php echo e($i + 1); ?></td>
                    <td><strong><?php echo e($p->name); ?></strong></td>
                    <td><?php echo e($p->email); ?></td>
                    <td><?php echo e($p->pivot->rol_en_emergencia); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>


<?php if($emergenciaFuego->pacientes->count() > 0): ?>
    <h3>5. PACIENTES / VÍCTIMAS (<?php echo e($emergenciaFuego->pacientes->count()); ?>)</h3>
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
            <?php $__currentLoopData = $emergenciaFuego->pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="text-align:center;"><?php echo e($i + 1); ?></td>
                    <td><strong><?php echo e($pac->nombre_completo); ?></strong></td>
                    <td><?php echo e($pac->edad ?? '—'); ?></td>
                    <td><?php echo e($pac->sexo); ?></td>
                    <td><?php echo e($pac->condicion); ?></td>
                    <td><?php echo e($pac->tipo_lesion ?? '—'); ?></td>
                    <td><?php echo e($pac->hospital_destino ?? '—'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>


<?php if($emergenciaFuego->insumos->count() > 0): ?>
    <h3>6. INSUMOS UTILIZADOS (<?php echo e($emergenciaFuego->insumos->count()); ?>)</h3>
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
            <?php $__currentLoopData = $emergenciaFuego->insumos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="text-align:center;"><?php echo e($i + 1); ?></td>
                    <td><?php echo e($ins->descripcion); ?></td>
                    <td style="text-align:center;"><strong><?php echo e($ins->pivot->cantidad); ?></strong></td>
                    <td><?php echo e($ins->pivot->observaciones ?? '—'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>


<?php if($emergenciaFuego->observaciones_generales): ?>
    <h3>7. OBSERVACIONES GENERALES</h3>
    <div style="border: 1px solid #dbacac; padding: 5px; min-height: 25px; font-size: 9px;">
        <?php echo e($emergenciaFuego->observaciones_generales); ?>

    </div>
<?php endif; ?>


<table class="firmas-table" cellspacing="15" cellpadding="10">
    <tr>
        <td>
            <div class="firma-linea">
                <strong><?php echo e($emergenciaFuego->usuarioRegistra->name ?? 'Responsable'); ?></strong><br>
                Responsable del Registro
            </div>
        </td>
        <td>
            <div class="firma-linea">
                <strong><?php echo e($emergenciaFuego->personal->first()->name ?? 'Jefe de Incidente'); ?></strong><br>
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
</html><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_fuego/pdf/parte_bomberos.blade.php ENDPATH**/ ?>