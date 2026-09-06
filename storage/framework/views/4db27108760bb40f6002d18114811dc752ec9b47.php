

<?php $__env->startSection( "cabeza" ); ?>

		<title>Clave - Index - BCBVC</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection( "cuerpo" ); ?>
		<h2 class="mt-2 shadow p-3 mb-2 bg-white rounded text-danger">Consultar Información de Clave_14</h2>
		<?php echo $__env->make('clave.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<div class="row justify-content-between focus-in-expand"><!-- div Informacion -->
			
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
				<div class="card mb-5 text-white text-lg o-hidden ">
					<div class="card-body text-white bg-info">
						<div class="card-body-icon">
							<i class="fas fa-money-check-alt"></i>
					    </div>
						<div class="card-text">
							<h5> <?php echo trans('messages.Monthly Fuel Consumption'); ?></h5>$. <?php echo e($SumaValClaves); ?> USD.
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
				<div class="card mb-5 text-white text-sm o-hidden ">
					<div class="card-body text-white bg-warning">
						<div class="card-body-icon">
							<i class="fas fa-money-check-alt"></i>
						</div>
						<div class="card-text">
							<h5>Detalle Consumo $</h5> 
							<?php $__currentLoopData = $gasaccumulatedmonthly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo e($item->combustible); ?> ==> $. <?php echo e($item->accumulated_monthly); ?> USD.</br>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</div>
			</div>
					
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
					<div class="card mb-5 text-white text-sm o-hidden ">
						<div class="card-body text-white bg-secondary">
							<div class="card-body-icon"><i class="fas fa-gas-pump"></i></div>
								<div class="card-text">
									<h5>Detalle Consumo Glns</h5> 
								</div>	
								<?php $__currentLoopData = $gasstationexpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo e($item->combustible); ?> ==> <?php echo e($item->Glns); ?> Glns.</br>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				</div>	
			</div>
			
		
		
		<ul class="nav nav-pills flex-column flex-sm-row ml-4"><!-- div botones acciones -->
					<li class="nav-item">
								<div class="input-group mb-3 ">
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create event')): ?>	
										<div class="input-group-prepend">
											<span title="Nuevo" class="input-group-text"><i class="fas fa-plus"></i></span>
										</div>
										
										<a class="nav-link btn btn-outline-primary focus-in-expand" href="<?php echo e(route('clave.create')); ?>"><?php echo trans('messages.new'); ?></a>
										<?php endif; ?>
								</div>
					</li>
					<li class="nav-item">
								<div class="input-group mb-3 ">
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('allow export')): ?>
										<div class="input-group-prepend ml-2">
											<span title="Export" class="input-group-text"><i class="fas fa-file-export"></i></span>
										</div>
										<a class="nav-link btn btn-outline-secondary focus-in-expand" href="claves/export/"><?php echo trans('messages.export'); ?></a>
										<?php endif; ?>
								</div>
					</li>	
					<li class="nav-item">
						<div class="input-group mb-3 ">
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('allow import')): ?>
										<div class="input-group-prepend ml-2">
											<span title="Import" class="input-group-text"><i class="fas fa-file-import"></i></span>
										</div>
										
										<a class="nav-link btn btn-outline-success focus-in-expand" href="/claves/import"><?php echo trans('messages.import'); ?></a>
										<?php endif; ?>
						</div>
					</li>
					<li class="nav-item">
						<div class="input-group mb-3 ">
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('estadistica')): ?>
										<div class="input-group-prepend ml-2">
											<span title="Grafic" class="input-group-text"><i class="fas fa-chart-line"></i></span>
										</div>
										
										<a class="nav-link btn btn-outline-info focus-in-expand" href="claves/grafic/"><?php echo trans('messages.grafic'); ?></a>
										<?php endif; ?>
						</div>
					</li>
					
					
				
		</ul>
		<?php echo $__env->make('clave.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<table class="table p-3 table-hover table-condensed">
			<thead>
				<tr class="table-info">
					<td>id</td>
					<td><?php echo trans('messages.Order'); ?></td>
					<td><?php echo trans('messages.Dollars'); ?></td>
					<td><?php echo trans('messages.Gallons'); ?></td>
					<td><?php echo trans('messages.Fuel'); ?></td>
					<td><?php echo trans('messages.Gas Station'); ?></td>
					<td><?php echo trans('messages.Driver'); ?></td>
					<td><?php echo trans('messages.Vehicle'); ?></td>
					<td><?php echo trans('messages.Options'); ?></td>
				</tr>

			</thead>
			<tbody>
				<?php $__currentLoopData = $claves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($clave->id); ?></td>
					<td><?php echo e($clave->Orden); ?></td>
					<td>USD $<?php echo e($clave->dolares); ?></td>
					<td><?php echo e($clave->galones); ?></td>
					<td><?php echo e($clave->combustible); ?></td>
					<td><?php echo e($clave->gasolinera->razonsocial); ?></td>
					<td><?php echo e($clave->user->name); ?></td>
					<td><?php echo e($clave->vehiculo->codigodis); ?></td>
					<td>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit event')): ?>
						<a class="btn btn-outline-info btn-sm " data-toggle="tooltip" title="Edit" href="<?php echo e(route('clave.edit',$clave->id)); ?>"><i class="icon-edit"></i></a>
					<?php endif; ?>
						<a class="btn btn-outline-info btn-sm" data-toggle="tooltip" title="Ver" href="<?php echo e(route('clave.show',$clave->id)); ?>" role="button"><i class="icon-list"></i></a>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send mail')): ?>
						<a class="btn btn-outline-info btn-sm" data-toggle="modal" title="Enviar" data-target="#exampleModal" role="button"><i class="icon-envelope"></i></a>
					<?php endif; ?>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create pdf')): ?>
						<a class="btn btn-outline-info btn-sm" data-toggle="tooltip" title="PDF" href="<?php echo e(action('ClaveController@downloadPDF', $clave->id)); ?>" role="button"><i class="icon-file-text"></i></a>
					<?php endif; ?>
					</td>
				</tr>
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form method="get" action="<?php echo e(action('MailController@SendMailsClave', $clave->id  )); ?>" class="form-horizontal">
								<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Destinatario</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
								</div>
								<div class="modal-body">
										<div class="input-group mb-3">
										<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">@</span>
										</div>
											<input name="email" type="email" class="form-control" placeholder="example@bomberos.gob.ec" aria-label="Username" aria-describedby="basic-addon1">
										</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Enviar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
		</table>

		<?php echo e($claves -> appends(['searchText' => $query]) -> links()); ?>

	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection( "piepagina" ); ?> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make( "layouts.plantilla" , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views//clave/index.blade.php ENDPATH**/ ?>