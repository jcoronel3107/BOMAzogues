

<?php $__env->startSection( "cabeza" ); ?>
<title>Usuarios - Index - BCBVC</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection( "cuerpo" ); ?>
<h2 class="mt-5 shadow p-3 mb-5 bg-white rounded text-danger"><?php echo trans('messages.Consult User Information'); ?></h2>
<?php echo $__env->make('user.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row nav justify-content-end">
			<li class="nav-item">
				<div class="input-group mb-3">
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create movilizacion')): ?>
							<div class="input-group-prepend">
								<span title="Nuevo" class="input-group-text"><i class="fas fa-plus"></i></span>
							</div>
								<a class="btn btn-outline-primary" href="<?php echo e(route('register')); ?>"><?php echo trans('messages.new'); ?></a>
							<?php endif; ?>
							
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('allow import')): ?>
							<div class="input-group-prepend ml-2">
								<span title="Grafic" class="input-group-text"><i class="icon-cloud-upload"></i></span>
							</div>
							<a class="btn btn-outline-info" href="/users/importar/"><?php echo trans('messages.import'); ?></a>
							<?php endif; ?>
				</div> 
			</li>
		</div>

<hr style="border:2px;">
<?php echo $__env->make('user.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<table id="dataTable" class="table table-hover table-condensed" role="grid" aria-describedby="dataTable_info">
	<thead>
		<tr role="row" class="table-info">
			<th>id</th>
			<th><?php echo trans('messages.name'); ?></th>
			<th><?php echo trans('messages.E-Mail Address'); ?></th>
			<th><?php echo trans('messages.avatar'); ?></th>
			<th><?php echo trans('messages.position'); ?></th>
			<th>Estación</th>
			<th><?php echo trans('messages.Rols'); ?></th>
			<th><?php echo trans('messages.status'); ?></th>
			<th><?php echo trans('messages.Options'); ?></th>

		</tr>
	</thead>
	<tbody>
		<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($user->id); ?></td>
			<td><?php echo e($user->name); ?></td>
			<td><?php echo e($user->email); ?></td>
			<td><img src="<?php echo e(asset('storage/avatar/'.$user->avatar)); ?>" alt="avatar" width="30" height="30"></td>
			<td><?php echo e($user->cargo); ?></td>
			<td><?php echo e($user->station->nombre ?? 'N/A'); ?></td>
			<td><?php echo e($user->getRoleNames()); ?></td>
			<td><?php echo e($user->status); ?></td>
			<td>
				<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit user')): ?>
				<a class="btn btn-outline-info btn-sm " data-toggle="tooltip" title="Edit" href="profile/edit/<?php echo e($user->id); ?>"><i class="icon-edit"></i></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</tbody>
	<tfoot>
		<tr class="table-info">
			<th>id</th>
			<th><?php echo trans('messages.name'); ?></th>
			<th><?php echo trans('messages.E-Mail Address'); ?></th>
			<th><?php echo trans('messages.avatar'); ?></th>
			<th><?php echo trans('messages.position'); ?></th>
			<th><?php echo trans('messages.Rols'); ?></th>
			<th><?php echo trans('messages.status'); ?></th>
			<th><?php echo trans('messages.Options'); ?></th>

		</tr>
	</tfoot>
</table>
<?php echo e($users -> appends(['searchText' => $query]) -> links()); ?>

<?php $__env->stopSection(); ?> <?php $__env->startSection( "piepagina" ); ?> <?php $__env->stopSection(); ?>
<?php echo $__env->make( "layouts.plantilla" , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views//user/index.blade.php ENDPATH**/ ?>