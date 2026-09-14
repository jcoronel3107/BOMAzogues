

<?php $__env->startSection('cuerpo'); ?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-ambulance text-primary"></i> Emergencias Prehospitalarias
    </h1>
    <a href="<?php echo e(route('emergencias-prehospitalarias.create')); ?>" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm"></i> Nueva Emergencia
    </a>
</div>


<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>


<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Registradas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['total']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            En Curso
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['en_curso']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Finalizadas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['finalizadas']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Hoy
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($resumen['hoy']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         data-toggle="collapse" data-target="#filtrosCollapse" style="cursor:pointer;">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter"></i> Filtros de Búsqueda
        </h6>
        <span class="badge badge-primary">
            <?php echo e(collect(request()->only(['buscar','estado','prioridad','tipo_emergencia','vehiculo_id','user_id','fecha_desde','fecha_hasta']))->filter()->count()); ?> activo(s)
        </span>
    </div>
    <div class="collapse <?php echo e(request()->hasAny(['buscar','estado','prioridad','tipo_emergencia','vehiculo_id','user_id','fecha_desde','fecha_hasta']) ? 'show' : ''); ?>"
         id="filtrosCollapse">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('emergencias-prehospitalarias.index')); ?>" id="formFiltros">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Buscar</label>
                            <input type="text" name="buscar" class="form-control form-control-sm"
                                   placeholder="Código, dirección, motivo..."
                                   value="<?php echo e(request('buscar')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($e); ?>" <?php echo e(request('estado') == $e ? 'selected' : ''); ?>><?php echo e($e); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Prioridad</label>
                            <select name="prioridad" class="form-control form-control-sm">
                                <option value="">Todas</option>
                                <?php $__currentLoopData = $prioridades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p); ?>" <?php echo e(request('prioridad') == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo_emergencia" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t); ?>" <?php echo e(request('tipo_emergencia') == $t ? 'selected' : ''); ?>><?php echo e($t); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Vehículo</label>
                            <select name="vehiculo_id" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($v->id); ?>" <?php echo e(request('vehiculo_id') == $v->id ? 'selected' : ''); ?>>
                                        <?php echo e($v->placa); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Personal</label>
                            <select name="user_id" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($u->id); ?>" <?php echo e(request('user_id') == $u->id ? 'selected' : ''); ?>>
                                        <?php echo e($u->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Desde</label>
                            <input type="date" name="fecha_desde" class="form-control form-control-sm"
                                   value="<?php echo e(request('fecha_desde')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Hasta</label>
                            <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                                   value="<?php echo e(request('fecha_hasta')); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Por página</label>
                            <select name="per_page" class="form-control form-control-sm">
                                <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e(request('per_page', 10) == $n ? 'selected' : ''); ?>>
                                        <?php echo e($n); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <a href="<?php echo e(route('emergencias-prehospitalarias.index')); ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list"></i> Listado de Emergencias
        </h6>
    </div>
    <div class="card-body">
        <?php if($emergencias->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-gray-300"></i>
                <h5 class="mt-3">No se encontraron emergencias</h5>
                <p class="text-muted">
                    <?php if(request()->hasAny(['buscar','estado','prioridad','tipo_emergencia','vehiculo_id','user_id','fecha_desde','fecha_hasta'])): ?>
                        Intenta ajustar los filtros o
                        <a href="<?php echo e(route('emergencias-prehospitalarias.index')); ?>">limpiar la búsqueda</a>.
                    <?php else: ?>
                        Aún no hay emergencias registradas.
                        <a href="<?php echo e(route('emergencias-prehospitalarias.create')); ?>">Registrar la primera</a>.
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Código</th>
                            <th>Fecha Salida</th>
                            <th>Vehículo</th>
                            <th>Motivo / Dirección</th>
                            <th class="text-center">Pacientes</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $emergencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $prioridadColor = [
                                    'Rojo' => 'danger',
                                    'Naranja' => 'warning',
                                    'Amarillo' => 'warning',
                                    'Verde' => 'success',
                                    'Azul' => 'primary',
                                ][$e->prioridad] ?? 'secondary';

                                $estadoColor = [
                                    'En curso' => 'primary',
                                    'Finalizada' => 'success',
                                    'Cancelada' => 'danger',
                                    'Derivada' => 'warning',
                                ][$e->estado] ?? 'secondary';
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('emergencias-prehospitalarias.show', $e)); ?>"
                                       class="font-weight-bold text-primary">
                                        <?php echo e($e->codigo); ?>

                                    </a>
                                </td>
                                <td>
                                    <div><?php echo e($e->fecha_salida->format('d/m/Y')); ?></div>
                                    <small class="text-muted"><?php echo e($e->fecha_salida->format('H:i')); ?></small>
                                </td>
                                <td>
                                    <?php if($e->vehiculo): ?>
                                        <i class="fas fa-ambulance text-primary"></i>
                                        <strong><?php echo e($e->vehiculo->placa); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo e($e->vehiculo->marca ?? ''); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div><?php echo e(Str::limit($e->motivo_llamado, 40)); ?></div>
                                    <small class="text-muted"><?php echo e(Str::limit($e->direccion, 45)); ?></small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-user"></i> <?php echo e($e->pacientes->count()); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?php echo e($prioridadColor); ?>"><?php echo e($e->prioridad); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?php echo e($estadoColor); ?>"><?php echo e($e->estado); ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('emergencias-prehospitalarias.show', $e)); ?>"
                                       class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('emergencias-prehospitalarias.pdf', $e)); ?>"
                                       class="btn btn-danger btn-sm" title="PDF" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="<?php echo e(route('emergencias-prehospitalarias.edit', $e)); ?>"
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            title="Eliminar"
                                            onclick="confirmarEliminar(<?php echo e($e->id); ?>, '<?php echo e($e->codigo); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="formEliminar<?php echo e($e->id); ?>"
                                          action="<?php echo e(route('emergencias-prehospitalarias.destroy', $e)); ?>"
                                          method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($emergencias->hasPages()): ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Mostrando <strong><?php echo e($emergencias->firstItem()); ?></strong>
                        a <strong><?php echo e($emergencias->lastItem()); ?></strong>
                        de <strong><?php echo e($emergencias->total()); ?></strong> registros
                    </div>
                    <div>
                        <?php echo e($emergencias->links()); ?>

                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function confirmarEliminar(id, codigo) {
        if (confirm(`¿Está seguro de eliminar la emergencia ${codigo}?\n\n⚠️ Se restaurará el stock de los insumos utilizados.`)) {
            document.getElementById('formEliminar' + id).submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const perPageSelect = document.querySelector('select[name="per_page"]');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                document.getElementById('formFiltros').submit();
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\desarrollo\azogues\BOMAzogues\resources\views/emergencias_prehospitalarias/index.blade.php ENDPATH**/ ?>