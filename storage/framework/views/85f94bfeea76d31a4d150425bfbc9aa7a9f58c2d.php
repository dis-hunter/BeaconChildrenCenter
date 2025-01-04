<form action="<?php echo e(route('parents.store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <table>
        <!-- Fullname fields -->
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
            <td>Telephone</td>
            <td><input type="text" name="telephone" value="<?php echo e(old('telephone')); ?>"></td>
        </tr>

        <!-- National ID -->
        <tr>
            <td>National ID</td>
            <td><input type="text" name="national_id" value="<?php echo e(old('national_id')); ?>"></td>
        </tr>

        <!-- Employer -->
        <tr>
            <td>Employer</td>
            <td><input type="text" name="employer" value="<?php echo e(old('employer')); ?>"></td>
        </tr>

        <!-- Insurance -->
        <tr>
            <td>Insurance</td>
            <td><input type="text" name="insurance" value="<?php echo e(old('insurance')); ?>"></td>
        </tr>

        <!-- Email -->
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="<?php echo e(old('email')); ?>"></td>
        </tr>

        <!-- Relationship -->
        <tr>
            <td>Relationship</td>
            <td>
                <select name="relationship_id">
                    <option value="1" <?php echo e(old('relationship_id') == '1' ? 'selected' : ''); ?>>Parent</option>
                    <option value="2" <?php echo e(old('relationship_id') == '2' ? 'selected' : ''); ?>>Sibling</option>
                    <option value="3" <?php echo e(old('relationship_id') == '3' ? 'selected' : ''); ?>>Friend</option>
                </select>
            </td>
        </tr>

        <!-- Referer -->
        <tr>
            <td>Referer</td>
            <td><input type="text" name="referer" value="<?php echo e(old('referer')); ?>"></td>
        </tr>

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
<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/reception/parentregistration.blade.php ENDPATH**/ ?>