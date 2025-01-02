
<?php $__env->startSection('title','Child | Reception'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Parent</h1>
    <form action="/patients/parent" method="post" class="bg-light p-4 rounded shadow-sm">
        <?php echo csrf_field(); ?>
        <!-- Fullname Fields -->
        <div class="row g-3">
            <div class="col-md-4">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo e(old('firstname')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" id="middlename" name="middlename" value="<?php echo e(old('middlename')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" id="surname" name="surname" value="<?php echo e(old('surname')); ?>" class="form-control">
            </div>
        </div>

        <!-- Date of Birth and Gender -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo e(old('dob')); ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="gender_id" class="form-label">Gender</label>
                <select id="gender_id" name="gender_id" class="form-select">
                    <option value="1" <?php echo e(old('gender_id') == '1' ? 'selected' : ''); ?>>Male</option>
                    <option value="2" <?php echo e(old('gender_id') == '2' ? 'selected' : ''); ?>>Female</option>
                </select>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo e(old('telephone')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="national_id" class="form-label">National ID</label>
                <input type="text" id="national_id" name="national_id" value="<?php echo e(old('national_id')); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control">
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
                    <option value="1" <?php echo e(old('relationship_id') == '1' ? 'selected' : ''); ?>>Parent</option>
                    <?php $__currentLoopData = $relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->relationship); ?>"><?php echo e($item->relationship); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </div>
        </div>

        <!-- Success Message -->
        <?php if(session()->has('success')): ?>
        <div class="alert alert-success mt-3">
            <?php echo e(session()->get('success')); ?>

        </div>
        <?php endif; ?>
    </form>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/child.blade.php ENDPATH**/ ?>