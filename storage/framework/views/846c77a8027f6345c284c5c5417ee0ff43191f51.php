<div>
    
    <!-- Search Parent Form -->
    

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 p-2">
    <select wire:model="selectedColumn" class="form-select">
        <?php $__currentLoopData = $searchColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="col-lg-8 col-md-6 col-sm-12 p-2">
    <input type="text" wire:model="query" class="form-control" placeholder="Enter search term">
                <?php $__errorArgs = ['query'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
    </div>

<?php if(!empty($parents)): ?>
    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <pre><?php echo e($parent->email); ?></pre>
        <pre><?php echo e($parent->telephone); ?></pre>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/child-parent-manager.blade.php ENDPATH**/ ?>