
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-parent-manager')->html();
} elseif ($_instance->childHasBeenRendered('FS6yp8y')) {
    $componentId = $_instance->getRenderedChildComponentId('FS6yp8y');
    $componentTag = $_instance->getRenderedChildComponentTagName('FS6yp8y');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FS6yp8y');
} else {
    $response = \Livewire\Livewire::mount('child-parent-manager');
    $html = $response->html();
    $_instance->logRenderedChild('FS6yp8y', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<div class="container">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId])->html();
} elseif ($_instance->childHasBeenRendered('amrh9Md')) {
    $componentId = $_instance->getRenderedChildComponentId('amrh9Md');
    $componentTag = $_instance->getRenderedChildComponentTagName('amrh9Md');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('amrh9Md');
} else {
    $response = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId]);
    $html = $response->html();
    $_instance->logRenderedChild('amrh9Md', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>