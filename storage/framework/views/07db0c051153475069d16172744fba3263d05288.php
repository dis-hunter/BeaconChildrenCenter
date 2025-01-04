<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/childreg.css')); ?>">
</head>
<body>
    


<!-- Search Form -->
 <div>
<form action="<?php echo e(route('parents.search')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <table>
        <tr>
            <td>Search by Telephone</td>
            <td><input type="text" name="telephone" placeholder="Enter Telephone" value="<?php echo e(old('telephone')); ?>"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
    </table>
</form>
</div>

<!-- Error Message -->
<?php if(session()->has('error')): ?>
<p style="color: red;">
    <?php echo e(session()->get('error')); ?>

</p>
<?php endif; ?>

<?php if(isset($parent)): ?>
    <h3>Parent Record</h3>
    <table border="1">
        <tr>
            <td>Full Name</td>
            <td><?php echo e(json_decode($parent->fullname)->firstname); ?> <?php echo e(json_decode($parent->fullname)->middlename); ?> <?php echo e(json_decode($parent->fullname)->surname); ?></td>
        </tr>
        <tr>
            <td>Telephone</td>
            <td><?php echo e($parent->telephone); ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo e($parent->email); ?></td>
        </tr>
        <tr>
            <td>Action</td>
            <td>
                <form action="<?php echo e(route('children.create')); ?>" method="get">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="parent_id" value="<?php echo e($parent->id); ?>">
                    <button type="submit">Use This Parent</button>
                </form>
            </td>
        </tr>
    </table>
<?php endif; ?>
<div class="container mt-5" style="border: 2px solid; border-radius: 10px; padding: 20px;">
    <!-- Flexbox Wrapper -->
    <div style="display: flex; align-items: flex-start; gap: 20px;">
        <!-- Image Section -->
        <div style="flex: 1; text-align: center;">
            <img src="/images/register_child.webp" alt="Register Child" style="margin-top:115px;width: 100%; height: 100% !important; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        </div>

        <!-- Form Section -->
        <div style="flex: 2;">
            <form action="<?php echo e(route('children.store')); ?>" method="post">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="parent_id" value="<?php echo e(request('parent_id')); ?>">

                <!-- Form Header -->
                <div class="mb-4">
                    <h3>Register a Child</h3>
                </div> <br>

                <!-- First Name -->
                <div class="mb-3 row">
                    <label for="firstname" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo e(old('firstname')); ?>" placeholder="Enter first name">
                    </div>
                </div> <br>

                <!-- Middle Name -->
                <div class="mb-3 row">
                    <label for="middlename" class="col-sm-3 col-form-label">Middle Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo e(old('middlename')); ?>" placeholder="Enter middle name">
                    </div>
                </div> <br>

                <!-- Surname -->
                <div class="mb-3 row">
                    <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="surname" name="surname" value="<?php echo e(old('surname')); ?>" placeholder="Enter surname">
                    </div>
                </div> <br>

                <!-- Date of Birth -->
                <div class="mb-3 row">
                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo e(old('dob')); ?>">
                    </div>
                </div> <br>

                <!-- Gender -->
                <div class="mb-3 row">
                    <label for="gender_id" class="col-sm-3 col-form-label">Gender</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="gender_id" name="gender_id">
                            <option value="1" <?php echo e(old('gender_id') == '1' ? 'selected' : ''); ?>>Male</option>
                            <option value="2" <?php echo e(old('gender_id') == '2' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>
                </div> <br>

                <!-- Birth Certificate -->
                <div class="mb-3 row">
                    <label for="birth_cert" class="col-sm-3 col-form-label">Birth Certificate</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="birth_cert" name="birth_cert" value="<?php echo e(old('birth_cert')); ?>" placeholder="Enter birth certificate number">
                    </div>
                </div> <br>

                <!-- Registration Number -->
                <div class="mb-3 row">
                    <label for="registration_number" class="col-sm-3 col-form-label">Registration Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="registration_number" name="registration_number" value="<?php echo e(old('registration_number')); ?>" placeholder="Enter registration number">
                    </div>
                </div> <br>

                <!-- Submit Button -->
                <div class="mb-3 row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div> <br>

                <!-- Success Message -->
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success mt-3">
                        <?php echo e(session()->get('success')); ?>

                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>



</body>
</html>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/childregistration.blade.php ENDPATH**/ ?>