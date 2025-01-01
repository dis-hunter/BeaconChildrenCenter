
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-parent-manager')->html();
} elseif ($_instance->childHasBeenRendered('ggcIMFn')) {
    $componentId = $_instance->getRenderedChildComponentId('ggcIMFn');
    $componentTag = $_instance->getRenderedChildComponentTagName('ggcIMFn');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ggcIMFn');
} else {
    $response = \Livewire\Livewire::mount('child-parent-manager');
    $html = $response->html();
    $_instance->logRenderedChild('ggcIMFn', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>