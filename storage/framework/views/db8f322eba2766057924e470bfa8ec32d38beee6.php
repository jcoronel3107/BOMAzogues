<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary  sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
  
    <div class="sidebar-brand-icon rotate-n-15">
       <i class="fas fa-ambulance vibrate-1"></i>
    </div>
    <div class="sidebar-brand-text mx-3"><?php echo trans('messages.name_app'); ?><sup>2</sup></div>
  </a>
  
  <hr class="sidebar-divider"><!--   Divider -->
  <div class="sidebar-heading"><!--  Heading Menu incident's -->
        <?php echo trans('messages.operations'); ?>

  </div>
  <hr class="sidebar-divider"><!--   Divider -->
  <li class="nav-item"><!--          Nav Item - Utilities Collapse Menu Operaciones-->  
      
      <li class="nav-item"><!--     Nav Item - Pages Collapse Menu Incidentes-->
        <a rel="nofollow noopener noreferrer" class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" target="_blank" aria-controls="collapseTwo">
          <i class="fa fa-star-half" aria-hidden="true"></i>
          <span><?php echo trans('messages.Incidents'); ?></span>
        </a>
        <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?>:</h6>
            <a rel="nofollow noopener noreferrer" class="collapse-item" target="_blank" href="/eventoE1/"><?php echo trans('messages.Station1'); ?></a>
            <a rel="nofollow noopener noreferrer" class="collapse-item" target="_blank" href="/eventoE2/"><?php echo trans('messages.Station2'); ?></a>
            <a rel="nofollow noopener noreferrer" class="collapse-item" target="_blank" href="/eventoE3/"><?php echo trans('messages.Station3'); ?></a>
           
          </div>
        </div>
      </li>
       
      <li class="nav-item"><!--     Nav Item - Utilities Collapse Menu C14-->
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClave14" aria-expanded="true" aria-controls="collapseClave14">
          <i class="fas fa-fw fa-wallet"></i>
          <span><?php echo trans('messages.Clave14'); ?></span>
        </a>
        <div id="collapseClave14" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
            <a rel="nofollow noopener noreferrer" class="collapse-item" target="_blank" href="<?php echo e(route('clave.index')); ?>"><?php echo trans('messages.Index'); ?></a>
          </div>
        </div>
      </li>
  
      <li class="nav-item"><!--     Nav Item - Utilities Collapse Menu Servicio-->
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServicios" aria-expanded="true" aria-controls="collapseServicios">
          <i class="fas fa-clipboard-check"></i>
          <span><?php echo trans('messages.Services'); ?></span>
        </a>
        <div id="collapseServicios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
            <a rel="nofollow noopener noreferrer" class="collapse-item" target="_blank" href="/servicio"><?php echo trans('messages.Index'); ?></a>
          </div>
        </div>
      </li>
  </li> 
  <hr class="sidebar-divider"><!--   Divider -->
  <div class="sidebar-heading"><!--  Heading Menu Prevencion -->
      <?php echo trans('messages.Prevention Unit'); ?>

  </div>
  <hr class="sidebar-divider"><!--   Divider --> 
  <li class="nav-item"><!--          Nav Item - Utilities Collapse Prevencion-->
        
        <div id="collapsePrevencion" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
            
              <a rel="nofollow noopener noreferrer" class="collapse-item" href="/prevencion"><?php echo trans('messages.Index'); ?></a>         
              <a class="collapse-item" href="/consultaentrefechasmov"><?php echo trans('messages.Search between dates'); ?></a>
      
          </div>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrevencionInsp" aria-expanded="true" aria-controls="collapsePrevencionInsp">
          <i class="fab fa-searchengin"></i>
          <span><?php echo trans('messages.Inspection'); ?></span>
        </a>
        <div id="collapsePrevencionInsp" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
                <a rel="nofollow noopener noreferrer" class="collapse-item" href="<?php echo e(url('/inspeccion/')); ?>"><?php echo trans('messages.Index'); ?></a>
                <a rel="nofollow noopener noreferrer" class="collapse-item" href="<?php echo e(url('/inspeccion/create')); ?>">Nueva Inspección</a>
            </div>
        </div>
  </li>
  <hr class="sidebar-divider"><!--   Divider --> 
  
    
  
    <hr class="sidebar-divider"><!--   Divider -->
    <div class="sidebar-heading"><!--  Heading -->
      Addons
          <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Novedades de Estación -->
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
<!-- Nav Item - Dashboard Novedades -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDashboard" aria-expanded="true" aria-controls="collapseDashboard">
        <i class="fas fa-fw fa-chart-pie"></i>
        <span>Dashboard</span>
    </a>
    <div id="collapseDashboard" class="collapse" aria-labelledby="headingDashboard" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Estadísticas:</h6>
            <a class="collapse-item" href="<?php echo e(route('dashboard.novedades')); ?>">Novedades</a>
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


    </div>
    <hr class="sidebar-divider"><!--   Divider -->
    <li class="nav-item"><!--          Nav Item - Pages Collapse Menu estadisticas-->
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEstadistica" aria-expanded="true" aria-controls="collapseEstadistica">
        <i class="fas fa-fw fa-filter"></i>
        <span><?php echo trans('messages.statistics'); ?></span>
      </a>
      <div id="collapseEstadistica" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
          <a class="collapse-item" href="/consulta"><?php echo trans('messages.Index'); ?></a>
          <a class="collapse-item" href="/consultaentrefechas"><?php echo trans('messages.Search between dates'); ?></a>
          <a class="collapse-item" href="<?php echo e(route('googlemymapsoptions')); ?>">Mapas</a>
        </div>
      </div>

    </li>
    <li class="nav-item"><!--         Nav Item - Pages Collapse Menu parametrizacion-->
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParametros" aria-expanded="true" aria-controls="collapseParametros">
        <i class="fas fa-fw fa-cogs"></i>
        <span><?php echo trans('messages.Parameterization'); ?></span>
      </a>
      <div id="collapseParametros" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
          
          <a class="collapse-item" href="/incidente/"> <?php echo trans('messages.Incidents'); ?></a>
          <a class="collapse-item" href="/estacion"><?php echo trans('messages.Firefighter station'); ?></a>
          <a class="collapse-item" href="/gasolinera"><?php echo trans('messages.Service Station'); ?></a>
          <a class="collapse-item" href="/parroquia"><?php echo trans('messages.Parishes'); ?></a>
          <a class="collapse-item" href="/vehiculo"><?php echo trans('messages.Vehicles'); ?></a>
          <a class="collapse-item" href="/cie10/importar">Cie10</a>
         
        </div>
      </div>
    </li>
    <li class="nav-item"><!--       Nav Item - Pages Collapse Menu Users -->
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
          <i class="fas fa-users-cog"></i>
          <span><?php echo trans('messages.Users'); ?></span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><?php echo trans('messages.Choices'); ?></h6>
            <a class="collapse-item" href="/user"><?php echo trans('messages.Index'); ?></a>
            
            <a class="collapse-item" href="<?php echo e(url('/users/roles')); ?>"><?php echo trans('messages.Permissions'); ?></a>
            
          </div>
        </div>
      </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0 vibrate-1" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar --><?php /**PATH D:\Desarrollo\htdocs\resources\views/layouts/sidebar2.blade.php ENDPATH**/ ?>