
<?php $__env->startSection('title','Child | Reception'); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId])->html();
} elseif ($_instance->childHasBeenRendered('WjKFkB4')) {
    $componentId = $_instance->getRenderedChildComponentId('WjKFkB4');
    $componentTag = $_instance->getRenderedChildComponentTagName('WjKFkB4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('WjKFkB4');
} else {
    $response = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId]);
    $html = $response->html();
    $_instance->logRenderedChild('WjKFkB4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Hospital\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>