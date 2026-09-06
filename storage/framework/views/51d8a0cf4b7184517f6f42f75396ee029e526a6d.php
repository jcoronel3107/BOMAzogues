<form method="get" action="/clave" autocomplete="off" role="search" >
<div class="form-group col-12">
	<div class="input-group "> <?php echo e(csrf_field()); ?>

		<input type="text" class="form-control" value="<?php echo e($query); ?>" name="searchText" placeholder="Buscar x Nro. Orden" >
		<span class="input-group-append">
			<button type="submit" class="btn btn-primary">Buscar</button>
		</span>
	</div>
</div>
</form>
<?php /**PATH D:\Desarrollo\htdocs\resources\views/clave/search.blade.php ENDPATH**/ ?>