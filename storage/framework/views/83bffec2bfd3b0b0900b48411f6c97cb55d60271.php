

<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('title', __('Página no encontrada')); ?>

<?php $__env->startSection('image'); ?>

<div style="background-image: url('/svg/404.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
<img src="/images/errors/404.gif"/>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('message', __('No hemos encontrado la página que buscas.')); ?>
<?php echo $__env->make('errors::illustrated-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desarrollo\htdocs\resources\views/errors/404.blade.php ENDPATH**/ ?>