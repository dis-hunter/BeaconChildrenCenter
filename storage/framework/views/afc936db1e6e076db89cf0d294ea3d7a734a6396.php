
<?php $__env->startSection('title','Child | Reception'); ?>

<?php $__env->startSection('content'); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-parent-manager')->html();
} elseif ($_instance->childHasBeenRendered('uoymiY8')) {
    $componentId = $_instance->getRenderedChildComponentId('uoymiY8');
    $componentTag = $_instance->getRenderedChildComponentTagName('uoymiY8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('uoymiY8');
} else {
    $response = \Livewire\Livewire::mount('child-parent-manager');
    $html = $response->html();
    $_instance->logRenderedChild('uoymiY8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<div class="container">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId])->html();
} elseif ($_instance->childHasBeenRendered('qAvxBnj')) {
    $componentId = $_instance->getRenderedChildComponentId('qAvxBnj');
    $componentTag = $_instance->getRenderedChildComponentTagName('qAvxBnj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qAvxBnj');
} else {
    $response = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId]);
    $html = $response->html();
    $_instance->logRenderedChild('qAvxBnj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>