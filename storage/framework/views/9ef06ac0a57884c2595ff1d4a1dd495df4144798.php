<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml"><!-- Div Logo -->
          <div class="d-flex justify-content-start ">
            <img style="opacity: 0.3; width: 190px; height: 40px;" src="/images/logotipo-05.jpg" alt="BCBVC">
        </div> 
    </ul>
    <ul class="navbar-nav ml-auto"><!-- Div Reloj -->
            <div id="clockdate">
                    <div class="clockdate-wrapper">
                        <div id="clock"></div>
                        <div id="date"></div>
                    </div>
                
            </div>
        
    </ul>

    <!-- ====== NOTIFICACIONES ====== -->
    <ul class="navbar-nav">
        <div class="topbar-divider d-none d-sm-block"></div>
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Contador de notificaciones no leídas -->
                <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                    <span class="badge badge-danger badge-counter"><?php echo e(auth()->user()->unreadNotifications->count()); ?></span>
                <?php endif; ?>
            </a>
            <!-- Dropdown - Notificaciones -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notificaciones
                    <span class="float-right">
                        <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                            <a href="<?php echo e(route('notificaciones.markAllAsRead')); ?>" class="text-white small">
                                <i class="fas fa-check-double"></i> Marcar todas
                            </a>
                        <?php endif; ?>
                    </span>
                </h6>
                
                <!-- Notificaciones no leídas -->
                <?php $__empty_1 = true; $__currentLoopData = auth()->user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo e($notification->data['url'] ?? '#'); ?>">
                        <div>
                            <div class="small text-gray-500"><?php echo e($notification->created_at->diffForHumans()); ?></div>
                            <span class="font-weight-bold"><?php echo e($notification->data['mensaje'] ?? 'Nueva notificación'); ?></span>
                            <div class="small text-muted"><?php echo e($notification->data['codigo'] ?? ''); ?></div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="text-center w-100">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <p class="text-gray-500 mt-2">No hay notificaciones pendientes</p>
                        </div>
                    </a>
                <?php endif; ?>
                
                <!-- Notificaciones leídas (opcional) -->
                <?php if(auth()->user()->readNotifications->count() > 0): ?>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">
                        Leídas
                    </h6>
                    <?php $__currentLoopData = auth()->user()->readNotifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item d-flex align-items-center text-muted" href="<?php echo e($notification->data['url'] ?? '#'); ?>">
                            <div>
                                <div class="small text-gray-500"><?php echo e($notification->created_at->diffForHumans()); ?></div>
                                <span><?php echo e($notification->data['mensaje'] ?? 'Notificación leída'); ?></span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </li>
    </ul>
    <!-- ====== FIN NOTIFICACIONES ====== -->

    <ul class="navbar-nav"><!-- Topbar NavItem Lenguaje -->
        <div class="topbar-divider d-none d-sm-block"></div>
        <!--Comprobamos si el status esta a true y existe más de un lenguaje-->
        <?php if(config('locale.status') && count(config('locale.languages')) > 1): ?>
        <div class="top-right links">
            <?php $__currentLoopData = array_keys(config('locale.languages')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($lang != App::getLocale()): ?>
            <a class="nav-link" href="<?php echo route('lang.swap', $lang); ?>" title="<?php echo trans('messages.language'); ?>">
                <i class="fa fa-language fa-lg"></i><?php echo e($lang); ?>

            </a>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

    </ul>
    <ul class="navbar-nav">
        <div class="topbar-divider d-none d-sm-block">
        </div>
    </ul>
    <ul class="navbar-nav"><!-- Topbar NavItem Clima -->
        <a class="nav-link" data-toggle="modal" data-target="#climaModal">
            <i class="fa fa-cloud-sun"></i>
            Clima
        </a>
    </ul>
    <ul class="navbar-nav">
        <div class="topbar-divider d-none d-sm-block">
        </div>
    </ul>
    <ul class="navbar-nav"><!-- Topbar NavItem Carretera -->
        <a class="nav-link" data-toggle="modal" data-target="#carreterasModal">
            <i class="fa fa-road"></i>
            Carreteras
        </a>
    </ul>
    <ul class="navbar-nav ml-right ">
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Authentication Links -->
        <?php if(auth()->guard()->guest()): ?>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
            </li>
            <?php if(Route::has('register')): ?>
            <!-- <li class="nav-item">
                                    <a class="nav-link dropdown-toggle" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li> -->
            <?php endif; ?> <?php else: ?>
            <li class="nav-item dropdown no-arrow">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(Auth::user()->name); ?> </span><img src="<?php echo e(asset('storage/avatar/'.Auth::user()->avatar)); ?>" height="40px" style="max-width: 100%" /><span class="caret"> </span>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile</a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view parametrizacion')): ?>
                    <a rel="nofollow noopener noreferrer" class="dropdown-item" target="_blank" href="/activitylog">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>Activity Log</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        <?php echo e(__('Logout')); ?>

                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
                
            </li>
        
        <?php endif; ?>

    </ul>
</nav>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><!-- Logout Modal Logout-->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo trans('messages.Ready to Leave?'); ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?php echo trans('messages.Select "Logout" below if you are ready to end your current session.'); ?></div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>

                <a class="btn btn-outline-danger" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="climaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><!-- Clima Modal -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Consulte Clima</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col"><!-- Div Clima -->
        
                    <div class="card">
                        <h4 class="card-header text-white bg-secondary">
                        
                            <div id="searchbox">
                                <input type="text" id="search" placeholder="Digite Ciudad">
                                <button>Search</button>
                            </div>
                            <div id="topbar">Clima<span id="searchicon">🔍</span></div>
                        </h4>
                        <div class="card-body">
                                <div id="mainbody">
                                    <img>
                                    <span id="city"></span>
                                    <span id="temp"></span>
                                    <span id="cond"></span>
                                    <hr>
                                    <div id="more">
                                        <span id="label">Humedad: </span><span id="humidity"></span>
                                    </div>
                                    <div id="more">
                                        <span id="label">Viento: </span><span id="wind"></span>
                                    </div>
                                    <div id="more">
                                        <span id="label">Dirección Viento: </span><span id="direction"></span>
                                    </div>
                                    <div>
                                        <span id="label">Sensación Térmica: </span><span id="feel"></span>
                                    </div>								
                                    <span style="font-size: 8px;">Ultima Actualización: </span><span style="font-size: 8px;" id="update"></span>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="carreterasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><!-- carreteras Modal -->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Consulte Estado Carreteras</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col"><!-- Div Clima -->
        
                    <div class="card lg">
                        <iframe src="<?php echo e(url('https://www.ecu911.gob.ec/consulta-de-vias/')); ?>">Your browser isn't compatible</iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- End of Topbar --><?php /**PATH D:\Desarrollo\htdocs\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>