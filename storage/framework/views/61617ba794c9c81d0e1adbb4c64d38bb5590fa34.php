<?php if(Session::has('Envio Mail Correcto')): ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?php echo e(session('Envio Mail Correcto')); ?>

			<button type="button"
				class="close"
				data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

<?php endif; ?>

<?php if(Session::has('Registro_Borrado')): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?php echo e(session('Registro_Borrado')); ?>

		<button type="button"
				class="close"
				data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<?php endif; ?>

<?php if(Session::has('Registro_Actualizado')): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?php echo e(session('Registro_Actualizado')); ?>

		<button type="button"
				class="close"
				data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<?php endif; ?>

<?php if(Session::has('Registro_Almacenado')): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?php echo e(session('Registro_Almacenado')); ?>

		<button type="button"
				class="close"
				data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
<?php endif; ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/servicio/messages.blade.php ENDPATH**/ ?>