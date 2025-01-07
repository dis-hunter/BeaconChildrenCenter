<div>
    <div class="form-floating mb-4">
        <select class="form-select" name="role" id="role" wire:model="role">
            <option disabled <?php echo e(old('role') === null ? 'selected' : ''); ?>></option>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($role->role); ?>" <?php echo e(old('role') === $role->role ? 'selected' : ''); ?>><?php echo e($role->role); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <label for="role">Role</label>
    </div>

<?php if($showModal): ?>
            
                <div class="form-floating mb-4">
                    <select class="form-select" name="specialization" id="specialization" wire:model="specialization">
                        <option disabled <?php echo e(old('specialization') === null ? 'selected' : ''); ?>></option>
                        <?php $__currentLoopData = $specializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->specialization); ?>" <?php echo e(old('specialization') === $item->specialization ? 'selected' : ''); ?>><?php echo e($item->specialization); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <label for="specialization">Specialization</label>
                </div>
            
<?php endif; ?>
</div><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/specialization-modal.blade.php ENDPATH**/ ?>