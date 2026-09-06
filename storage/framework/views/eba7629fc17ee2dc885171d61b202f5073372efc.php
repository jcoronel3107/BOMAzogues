	

	<?php $__env->startSection( "cabeza" ); ?>

	<title>Servicio - Index - BCBVC</title>
	<?php $__env->stopSection(); ?>

	<?php $__env->startSection( "cuerpo" ); ?>
		<h2 class="mt-5 shadow p-3 mb-5 bg-white rounded text-danger"><?php echo trans('messages.Check Services Commission Information'); ?></h2>
		<?php echo $__env->make('servicio.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="row nav justify-content-end">
			<li class="nav-item">
				<div class="input-group mb-3">
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create event')): ?>
							<div class="input-group-prepend">
								<span title="Nuevo" class="input-group-text"><i class="fas fa-plus"></i></span>
							</div>
								<a class="btn btn-outline-primary focus-in-expand" href="servicio/create"><?php echo trans('messages.new'); ?></a>
							<?php endif; ?>
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('allow export')): ?>
							<div class="input-group-prepend ml-2">
								<span title="Export" class="input-group-text"><i class="fas fa-file-export"></i></span>
							</div>
							
								<a class="btn btn-outline-secondary focus-in-expand" href="servicios/export/"><?php echo trans('messages.export'); ?></a>
							<?php endif; ?>
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('allow import')): ?>
							<div class="input-group-prepend ml-2">
								<span title="Import" class="input-group-text"><i class="fas fa-file-import"></i></span>
							</div>
							
							<a class="btn btn-outline-secondary focus-in-expand" href="servicios/import/"><?php echo trans('messages.import'); ?></a>
							<?php endif; ?>
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('estadistica')): ?>
							<div class="input-group-prepend ml-2">
								<span title="Grafic" class="input-group-text"><i class="fas fa-chart-line"></i></span>
							</div>
							
							<a class="btn btn-outline-info focus-in-expand" href="servicios/grafic/"><?php echo trans('messages.grafic'); ?></a>
							<?php endif; ?>
				</div> 
				
				
			</li>
			
		</div>
		
		<hr style="border:2px;">
		<?php echo $__env->make('servicio.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<table class="table p-3 table-hover ">
			<thead>
				<tr class="table-info">
					
					<td><?php echo trans('messages.departure date'); ?></td>
					<td><?php echo trans('messages.return_date'); ?></td>
					<td><?php echo trans('messages.office'); ?></td>
					<!-- <td><?php echo trans('messages.delegative'); ?></td> -->
					<td><?php echo trans('messages.km_output'); ?></td>
					<td><?php echo trans('messages.km_return'); ?></td>
					<td><?php echo trans('messages.Vehicle'); ?></td>
					<td><?php echo trans('messages.Options'); ?></td>

			</thead>
			<tbody>
				<?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					
					<td><?php echo e($servicio->fecha_salida); ?></td>
					<td><?php echo e($servicio->fecha_retorno); ?></td>
					<td><?php echo e($servicio->unidad); ?></td>
					<!-- <td><?php echo e($servicio->delegante); ?></td> -->
					<td><?php echo e($servicio->km_salida); ?>.Km</td>
					<td><?php echo e($servicio->km_retorno); ?>.Km</td>
					<td><?php echo e($servicio->vehiculo->codigodis); ?></td>
					<td>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update event')): ?>
						<a class="btn btn-primary " data-toggle="tooltip" title="Edit" href="<?php echo e(route('servicio.edit',$servicio->id)); ?>"><i class="icon-edit"></i></a>
					<?php endif; ?>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('read event')): ?>
						<a class="btn btn-outline-secondary" data-toggle="tooltip" title="Ver" href="<?php echo e(route('servicio.show',$servicio->id)); ?>" role="button"><i class="icon-list"></i></a>
					<?php endif; ?>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send mail')): ?>
						<a class="btn btn-outline-info" data-toggle="modal" title="Enviar" data-target="#exampleModal" role="button"><i class="icon-envelope"></i></a>
					<?php endif; ?>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create pdf')): ?>
						<a class="btn btn-outline-info" data-toggle="tooltip" title="Pdf" href="<?php echo e(action('ServicioController@downloadPDF', $servicio->id)); ?>" role="button"><i class="fas fa-file-pdf"></i></a>
					<?php endif; ?>
					</td>
				</tr>
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						<form method="get" action="<?php echo e(action('MailController@SendMailsServicio', $servicio->id  )); ?>" class="form-horizontal">
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
				</tr>
			</tbody>
		</table>

		<?php echo e($servicios -> appends(['searchText' => $query]) -> links()); ?>

	<?php $__env->stopSection(); ?>
 <?php $__env->startSection( "piepagina" ); ?> <?php $__env->stopSection(); ?>
<?php echo $__env->make( "layouts.plantilla" , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views//servicio/index.blade.php ENDPATH**/ ?>