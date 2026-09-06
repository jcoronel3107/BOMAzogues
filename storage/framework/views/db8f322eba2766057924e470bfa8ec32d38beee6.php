<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(url('/')); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-ambulance vibrate-1"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo trans('messages.name_app'); ?><sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo e(route('dashboard.emergencias')); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <?php echo trans('messages.operations'); ?>

    </div>

    

    <!-- Nav Item - Clave14 -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClave14" aria-expanded="true" aria-controls="collapseClave14">
            <i class="fas fa-fw fa-wallet"></i>
            <span><?php echo trans('messages.Clave14'); ?></span>
        </a>
        <div id="collapseClave14" class="collapse" aria-labelledby="headingClave14" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(route('clave.index')); ?>"><?php echo trans('messages.Index'); ?></a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Servicios -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServicios" aria-expanded="true" aria-controls="collapseServicios">
            <i class="fas fa-clipboard-check"></i>
            <span><?php echo trans('messages.Services'); ?></span>
        </a>
        <div id="collapseServicios" class="collapse" aria-labelledby="headingServicios" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(url('/servicio')); ?>"><?php echo trans('messages.Index'); ?></a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <?php echo trans('messages.Prevention Unit'); ?>

    </div>

    <!-- Nav Item - Prevencion -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrevencion" aria-expanded="true" aria-controls="collapsePrevencion">
            <i class="fas fa-clipboard-check"></i>
            <span><?php echo trans('messages.Mobilization'); ?></span>
        </a>
        <div id="collapsePrevencion" class="collapse" aria-labelledby="headingPrevencion" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(url('/prevencion')); ?>"><?php echo trans('messages.Index'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/consultaentrefechasmov')); ?>"><?php echo trans('messages.Search between dates'); ?></a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Inspeccion -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrevencionInsp" aria-expanded="true" aria-controls="collapsePrevencionInsp">
            <i class="fab fa-searchengin"></i>
            <span><?php echo trans('messages.Inspection'); ?></span>
        </a>
        <div id="collapsePrevencionInsp" class="collapse" aria-labelledby="headingPrevencionInsp" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(url('/inspeccion/')); ?>"><?php echo trans('messages.Index'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/inspeccion/create')); ?>">Nueva Inspección</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Emergencias -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmergencias" aria-expanded="true" aria-controls="collapseEmergencias">
            <i class="fas fa-fw fa-ambulance"></i>
            <span>Emergencias</span>
        </a>
        <div id="collapseEmergencias" class="collapse" aria-labelledby="headingEmergencias" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Emergencias:</h6>
                <a class="collapse-item" href="<?php echo e(route('emergencias.index')); ?>">Lista de Emergencias</a>
                <a class="collapse-item" href="<?php echo e(route('emergencias.create')); ?>">Nueva Emergencia</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Novedades -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNovedades" aria-expanded="true" aria-controls="collapseNovedades">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Novedades</span>
        </a>
        <div id="collapseNovedades" class="collapse" aria-labelledby="headingNovedades" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Novedades:</h6>
                <a class="collapse-item" href="<?php echo e(url('/estacion-novedades')); ?>">Lista de Novedades</a>
                <a class="collapse-item" href="<?php echo e(url('/estacion-novedades/create')); ?>">Nueva Novedad</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Movilizaciones -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMovilizaciones" aria-expanded="true" aria-controls="collapseMovilizaciones">
            <i class="fas fa-fw fa-truck-moving"></i>
            <span>Movilizaciones</span>
        </a>
        <div id="collapseMovilizaciones" class="collapse" aria-labelledby="headingMovilizaciones" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Movilizaciones:</h6>
                <a class="collapse-item" href="<?php echo e(route('movilizaciones.index')); ?>">Lista de Movilizaciones</a>
                <a class="collapse-item" href="<?php echo e(route('movilizaciones.create')); ?>">Nueva Movilización</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Reportes -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes" aria-expanded="true" aria-controls="collapseReportes">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Reportes</span>
        </a>
        <div id="collapseReportes" class="collapse" aria-labelledby="headingReportes" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Reportes:</h6>
                <a class="collapse-item" href="<?php echo e(route('reportes.emergencias')); ?>">Emergencias por Fechas</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Estadisticas -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEstadistica" aria-expanded="true" aria-controls="collapseEstadistica">
            <i class="fas fa-fw fa-filter"></i>
            <span><?php echo trans('messages.statistics'); ?></span>
        </a>
        <div id="collapseEstadistica" class="collapse" aria-labelledby="headingEstadistica" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(url('/consulta')); ?>"><?php echo trans('messages.Index'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/consultaentrefechas')); ?>"><?php echo trans('messages.Search between dates'); ?></a>
                <a class="collapse-item" href="<?php echo e(route('googlemymapsoptions')); ?>">Mapas</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Parametrizacion -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParametros" aria-expanded="true" aria-controls="collapseParametros">
            <i class="fas fa-fw fa-cogs"></i>
            <span><?php echo trans('messages.Parameterization'); ?></span>
        </a>
        <div id="collapseParametros" class="collapse" aria-labelledby="headingParametros" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(url('/incidente')); ?>"><?php echo trans('messages.Incidents'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/estacion')); ?>"><?php echo trans('messages.Firefighter station'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/gasolinera')); ?>"><?php echo trans('messages.Service Station'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/parroquia')); ?>"><?php echo trans('messages.Parishes'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/vehiculo')); ?>"><?php echo trans('messages.Vehicles'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/cie10/importar')); ?>">Cie10</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-users-cog"></i>
            <span><?php echo trans('messages.Users'); ?></span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a class="collapse-item" href="<?php echo e(url('/user')); ?>"><?php echo trans('messages.Index'); ?></a>
                <a class="collapse-item" href="<?php echo e(url('/users/roles')); ?>"><?php echo trans('messages.Permissions'); ?></a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 vibrate-1" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar --><?php /**PATH D:\Desarrollo\htdocs\resources\views/layouts/sidebar2.blade.php ENDPATH**/ ?>