
<?php $__env->startSection('title','Homepage'); ?>

<?php $__env->startSection('content'); ?>
<style>
    body {
        margin-left: 200px;
    }
</style>
<div class="container">
    <?php if(auth()->guard()->check()): ?>
    <pre><?php echo e((auth()->user()->fullname)->firstname); ?></pre>

    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/home.blade.php ENDPATH**/ ?>