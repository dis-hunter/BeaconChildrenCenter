
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mt-5">
    <div x-data="{showForm:true}">
    
        <button @click="showForm = !showForm" class="btn btn-primary mb-3">
        New Parent & Child
    </button>
    <form action="/patients/parent_child" method="post" class="bg-light p-4 rounded shadow-sm"  x-show="showForm" 
    x-transition >

        <?php echo csrf_field(); ?>
        <?php if($errors->any()): ?>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                
                                
                                <div>
                                    
                                    <p><?php echo e($error); ?></p>
                                    
                                </div>
                                
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <h3 class="text-center mb-4">Parent/Guardian</h3>
        <!-- Fullname Fields -->
        <div class="row g-3">
            <div class="col-md-4">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo e(old('firstname')); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" id="middlename" name="middlename" value="<?php echo e(old('middlename')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="lastname" class="form-label">Surname</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo e(old('lastname')); ?>" class="form-control" required>
            </div>
        </div>

        <!-- Date of Birth and Gender -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo e(old('dob')); ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="gender_id" class="form-label">Gender</label>
                <select id="gender_id" name="gender_id" class="form-select" required>
                    <option disabled <?php echo e(old('gender_id') === null ? 'selected' : ''); ?>>Select...</option>
                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->gender); ?>" <?php echo e(old('gender_id') === $item->gender ? 'selected' : ''); ?>><?php echo e($item->gender); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo e(old('telephone')); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="national_id" class="form-label">National ID</label>
                <input type="text" id="national_id" name="national_id" value="<?php echo e(old('national_id')); ?>" class="form-control" required>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="employer" class="form-label">Employer</label>
                <input type="text" id="employer" name="employer" value="<?php echo e(old('employer')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="insurance" class="form-label">Insurance</label>
                <input type="text" id="insurance" name="insurance" value="<?php echo e(old('insurance')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="referer" class="form-label">Referer</label>
                <input type="text" id="referer" name="referer" value="<?php echo e(old('referer')); ?>" class="form-control">
            </div>
        </div>

        <!-- Relationship -->
        <div class="row g-3 mt-3">
            <div class="col-md-12">
                <label for="relationship_id" class="form-label">Relationship</label>
                <select id="relationship_id" name="relationship_id" class="form-select">
                    <option disabled <?php echo e(old('relationship_id') === null ? 'selected' : ''); ?>>Select...</option>
                    <?php $__currentLoopData = $relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->relationship); ?>" <?php echo e(old('relationship_id') === $item->relationship ? 'selected' : ''); ?>><?php echo e($item->relationship); ?></option>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <hr class="mt-4">
        <h3 class="text-center mb-4">Child</h3>
        <!-- First Name, Middle Name, and Surname -->
        <div class="row g-3">
            <div class="col-md-4">
                <label for="firstname2" class="form-label">First Name</label>
                <input type="text" id="firstname2" name="firstname2" value="<?php echo e(old('firstname2')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="middlename2" class="form-label">Middle Name</label>
                <input type="text" id="middlename2" name="middlename2" value="<?php echo e(old('middlename2')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="lastname2" class="form-label">Surname</label>
                <input type="text" id="lastname2" name="lastname2" value="<?php echo e(old('lastname2')); ?>" class="form-control">
            </div>
        </div>

        <!-- Date of Birth and Gender -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="dob2" class="form-label">Date of Birth</label>
                <input type="date" id="dob2" name="dob2" value="<?php echo e(old('dob2')); ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="gender_id2" class="form-label">Gender</label>
                <select id="gender_id2" name="gender_id2" class="form-select">
                    <option disabled <?php echo e(old('gender_id2') === null ? 'selected' : ''); ?>>Select...</option>
                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->gender); ?>" <?php echo e(old('gender_id2') === $item->gender ? 'selected' : ''); ?>><?php echo e($item->gender); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!-- Birth Certificate and Registration Number -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="birth_cert" class="form-label">Birth Certificate</label>
                <input type="text" id="birth_cert" name="birth_cert" value="<?php echo e(old('birth_cert')); ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="registration_number" class="form-label">Registration Number</label>
                <input type="text" id="registration_number" name="registration_number" value="<?php echo e(old('registration_number')); ?>" class="form-control">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </div>
        </div>
                             <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <div>
                                    
                                    <?php echo e(session('error')); ?>

                                    
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(session()->has('success')): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <div>
                                    
                                    <?php echo e(session('success')); ?>

                                    
                                </div>
                            </div>
                            <?php endif; ?>
    </form>
</div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/child.blade.php ENDPATH**/ ?>