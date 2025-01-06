
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-parent-manager')->html();
} elseif ($_instance->childHasBeenRendered('iyD9U4a')) {
    $componentId = $_instance->getRenderedChildComponentId('iyD9U4a');
    $componentTag = $_instance->getRenderedChildComponentTagName('iyD9U4a');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('iyD9U4a');
} else {
    $response = \Livewire\Livewire::mount('child-parent-manager');
    $html = $response->html();
    $_instance->logRenderedChild('iyD9U4a', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<div class="container">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId])->html();
} elseif ($_instance->childHasBeenRendered('YGIXSkN')) {
    $componentId = $_instance->getRenderedChildComponentId('YGIXSkN');
    $componentTag = $_instance->getRenderedChildComponentTagName('YGIXSkN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YGIXSkN');
} else {
    $response = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId]);
    $html = $response->html();
    $_instance->logRenderedChild('YGIXSkN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>