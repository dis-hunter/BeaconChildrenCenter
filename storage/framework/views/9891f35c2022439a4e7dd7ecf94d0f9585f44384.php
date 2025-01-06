
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-parent-manager')->html();
} elseif ($_instance->childHasBeenRendered('WrkVgwA')) {
    $componentId = $_instance->getRenderedChildComponentId('WrkVgwA');
    $componentTag = $_instance->getRenderedChildComponentTagName('WrkVgwA');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('WrkVgwA');
} else {
    $response = \Livewire\Livewire::mount('child-parent-manager');
    $html = $response->html();
    $_instance->logRenderedChild('WrkVgwA', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<div class="container">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId])->html();
} elseif ($_instance->childHasBeenRendered('JmO9vB8')) {
    $componentId = $_instance->getRenderedChildComponentId('JmO9vB8');
    $componentTag = $_instance->getRenderedChildComponentTagName('JmO9vB8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JmO9vB8');
} else {
    $response = \Livewire\Livewire::mount('parent-crud', ['parentId' => $parentId]);
    $html = $response->html();
    $_instance->logRenderedChild('JmO9vB8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/reception/search.blade.php ENDPATH**/ ?>