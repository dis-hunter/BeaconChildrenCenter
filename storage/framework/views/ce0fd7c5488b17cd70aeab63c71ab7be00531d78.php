<div>
    
    <div class="modal fade" id="editChildModal-<?php echo e($child->id); ?>" tabindex="-1" aria-labelledby="#editChildModalLabel-<?php echo e($child->id); ?>" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="#editChildModalLabel-<?php echo e($child->id); ?>">Edit Child Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" id="firstname" wire:model.defer="firstname" value="<?php echo e(old('firstname')); ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" id="middlename" wire:model.defer="middlename" value="<?php echo e(old('middlename')); ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input type="text" id="lastname" wire:model.defer="lastname" value="<?php echo e(old('lastname')); ?>" class="form-control">
                            </div>
                        </div>
                
                        <!-- Date of Birth and Gender -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" wire:model.defer="dob" value="<?php echo e(old('dob')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="gender_id" class="form-label">Gender</label>
                                <select id="gender_id" wire:model.defer="gender_id" class="form-select">
                                    <option disabled <?php echo e(old('gender_id') === null ? 'selected' : ''); ?>>Select...</option>
                                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php echo e(old('gender_id') === $item->id ? 'selected' : ''); ?>><?php echo e($item->gender); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                
                        <!-- Birth Certificate and Registration Number -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="birth_cert" class="form-label">Birth Certificate</label>
                                <input type="text" id="birth_cert" wire:model.defer="birth_cert" value="<?php echo e(old('birth_cert')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" id="registration_number" wire:model.defer="registration_number" value="<?php echo e(old('registration_number')); ?>" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/livewire/edit-child-modal.blade.php ENDPATH**/ ?>