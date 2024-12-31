<div>
    <?php switch($currentView):
        case ('home'): ?>
            <?php echo $__env->make('reception.childregistration', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php break; ?>
        <?php case ('about'): ?>
            <?php echo $__env->make('reception.parentregistration', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php break; ?>
        <?php default: ?>
            <?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endswitch; ?>
</div><?php /**PATH C:\Users\giftg\beaconfolder\BeaconChildrenCenter\resources\views/livewire/content-switcher.blade.php ENDPATH**/ ?>