
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-parent-manager')->html();
} elseif ($_instance->childHasBeenRendered('CTsG0Q0')) {
    $componentId = $_instance->getRenderedChildComponentId('CTsG0Q0');
    $componentTag = $_instance->getRenderedChildComponentTagName('CTsG0Q0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('CTsG0Q0');
} else {
    $response = \Livewire\Livewire::mount('child-parent-manager');
    $html = $response->html();
    $_instance->logRenderedChild('CTsG0Q0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<div class="container">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId])->html();
} elseif ($_instance->childHasBeenRendered('PnkHEPX')) {
    $componentId = $_instance->getRenderedChildComponentId('PnkHEPX');
    $componentTag = $_instance->getRenderedChildComponentTagName('PnkHEPX');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PnkHEPX');
} else {
    $response = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId]);
    $html = $response->html();
    $_instance->logRenderedChild('PnkHEPX', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>