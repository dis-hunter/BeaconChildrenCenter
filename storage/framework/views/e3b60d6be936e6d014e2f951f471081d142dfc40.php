<!-- Search Form -->
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

<!-- Error Message -->
<?php if(session()->has('error')): ?>
<p style="color: red;">
    <?php echo e(session()->get('error')); ?>

</p>
<?php endif; ?>

<?php if(isset($parent)): ?>
    <h3>Parent Record</h3>
    <table style="border: 1;">
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

<form action="<?php echo e(route('children.store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="parent_id" value="<?php echo e(request('parent_id')); ?>">
    <!-- Rest of the form fields -->
    <tr>
        <td>First Name</td>
        <td><input type="text" name="firstname" value="<?php echo e(old('firstname')); ?>"></td>
    </tr>
    <tr>
        <td>Middle Name</td>
        <td><input type="text" name="middlename" value="<?php echo e(old('middlename')); ?>"></td>
    </tr>
    <tr>
        <td>Surname</td>
        <td><input type="text" name="surname" value="<?php echo e(old('surname')); ?>"></td>
    </tr>

        
        <!-- Date of Birth -->
        <tr>
            <td>Date of Birth</td>
            <td><input type="date" name="dob" value="<?php echo e(old('dob')); ?>"></td>
        </tr>

        <!-- Gender Dropdown -->
        <tr>
            <td>Gender</td>
            <td>
                <select name="gender_id">
                    <option value="1" <?php echo e(old('gender_id') == '1' ? 'selected' : ''); ?>>Male</option>
                    <option value="2" <?php echo e(old('gender_id') == '2' ? 'selected' : ''); ?>>Female</option>
                </select>
            </td>
        </tr>

        <!-- Telephone -->
        <tr>
            <td>birth Certificate</td>
            <td><input type="text" name="birth_cert" value="<?php echo e(old('birth_cert')); ?>"></td>
        </tr>

        <!-- National ID -->
        <tr>
            <td>Registration_number</td>
            <td><input type="text" name="registration_number" value="<?php echo e(old('registration_number')); ?>"></td>
        </tr>

        <!-- Employer -->
       
        <!-- Submit Button -->
        <tr>
            <td></td>
            <td><input type="submit" value="Register"></td>
        </tr>
    </table>

    <!-- Success Message -->
    <?php if(session()->has('success')): ?>
    <p style="color: blue;">
        <?php echo e(session()->get('success')); ?>

    </p>
    <?php endif; ?>
</form>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/childregistration.blade.php ENDPATH**/ ?>