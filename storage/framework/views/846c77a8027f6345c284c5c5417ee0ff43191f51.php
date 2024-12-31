<div>
    
    <!-- Search Parent Form -->
    

    <input type="text" class="form-input" placeholder="Search Contacts..." wire:model="query">

    <?php if(!empty($parents)): ?>
    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <pre><?php echo e($parent->email); ?></pre>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/child-parent-manager.blade.php ENDPATH**/ ?>