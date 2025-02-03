<div>
    
    
    <div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editParentModalLabel">Edit Parent Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <!-- Fullname Fields -->
        <div class="row g-3">
            <div class="col-md-4">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" id="firstname" wire:model.defer="firstname" value="<?php echo e(old('firstname',$parent->fullname->first_name)); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" id="middlename" wire:model.defer="middlename" value="<?php echo e(old('middlename',$parent->fullname->middle_name)); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="lastname" class="form-label">Surname</label>
                <input type="text" id="lastname" wire:model.defer="lastname" value="<?php echo e(old('lastname',$parent->fullname->last_name)); ?>" class="form-control" required>
            </div>
        </div>

        <!-- Date of Birth and Gender -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" wire:model.defer="dob" value="<?php echo e(old('dob', $parent->dob)); ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="gender_id" class="form-label">Gender</label>
                <select id="gender_id" wire:model.defer="gender_id" class="form-select" required>
                    <option disabled <?php echo e(old('gender_id', $parent->gender_id) === null ? 'selected' : ''); ?>>Select...</option>
                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->id); ?>" <?php echo e(old('gender_id', $parent->gender_id) === $item->id ? 'selected' : ''); ?>><?php echo e($item->gender); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" id="telephone" wire:model.defer="telephone" value="<?php echo e(old('telephone',$parent->telephone)); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" wire:model.defer="email" value="<?php echo e(old('email',$parent->email)); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="national_id" class="form-label">National ID</label>
                <input type="text" id="national_id" wire:model.defer="national_id" value="<?php echo e(old('national_id', $parent->national_id)); ?>" class="form-control" required>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="employer" class="form-label">Employer</label>
                <input type="text" id="employer" wire:model.defer="employer" value="<?php echo e(old('employer', $parent->employer)); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="insurance" class="form-label">Insurance</label>
                <input type="text" id="insurance" wire:model.defer="insurance" value="<?php echo e(old('insurance', $parent->insurance)); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="referer" class="form-label">Referer</label>
                <input type="text" id="referer" wire:model.defer="referer" value="<?php echo e(old('referer', $parent->referer)); ?>" class="form-control">
            </div>
        </div>

        <!-- Relationship -->
        <div class="row g-3 mt-3">
            <div class="col-md-12">
                <label for="relationship_id" class="form-label">Relationship</label>
                <select id="relationship_id" wire:model.defer="relationship_id" class="form-select">
                    <option disabled <?php echo e(old('relationship_id',$parent->relationship_id) === null ? 'selected' : ''); ?>>Select...</option>
                    <?php $__currentLoopData = $relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('relationship_id',$parent->relationship_id) === $item->id ? 'selected' : ''); ?>><?php echo e($item->relationship); ?></option>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between">
                        <div>
                            
                        </div>
                        <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\User\Hospital\BeaconChildrenCenter\resources\views/livewire/edit-parent-modal.blade.php ENDPATH**/ ?>