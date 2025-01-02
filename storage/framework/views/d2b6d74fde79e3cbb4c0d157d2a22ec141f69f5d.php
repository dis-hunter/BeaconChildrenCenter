
<?php $__env->startSection('title','Homepage'); ?>

<?php $__env->startSection('content'); ?>
<style>
    body {
        margin-left: 200px;
    }
</style>
<div class="container">
    <?php if(auth()->guard()->check()): ?>
    <?php
    function printArray($array, $prefix = '') {
    foreach ($array as $key => $value) {
    if (is_array($value)) {
    echo $prefix . $key . ": <br>";
    printArray($value, $prefix . '&nbsp;&nbsp;&nbsp;'); // Indent nested values
    } else {
    echo $prefix . $key . ": " . htmlspecialchars($value) . "<br>";
    }
    }
    }
    ?>

    <?php printArray(auth()->user()->toArray()) ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/home.blade.php ENDPATH**/ ?>