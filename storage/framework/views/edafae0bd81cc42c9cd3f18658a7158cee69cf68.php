<!-- Search Form -->
 <h2>welcome</h2>
<form action="<?php echo e(route('parent.get-children')); ?>" method="post">
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

<?php if(isset($children) && $children->count() > 0): ?>
    <h3>Children Records</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($child->id); ?></td>
                    <td><?php echo e(json_decode($child->fullname)->firstname); ?> <?php echo e(json_decode($child->fullname)->surname); ?></td>
                    <td><?php echo e($child->dob); ?></td>
                    <td><?php echo e($child->gender_id); ?></td>
                    <td>
                        <form action="<?php echo e(route('children.create')); ?>" method="get">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="child_id" value="<?php echo e($child->id); ?>">
                            <button type="submit">Select</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>

<form action="<?php echo e(route('doctors.specializationSearch')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <label for="specialization">Select Specialization:</label>
    <select name="specialization_id" id="specialization">
        <option value="">-- Select Specialization --</option>
        <?php $__currentLoopData = $specializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($specialization->specialization_id); ?>">
                <?php echo e($specialization->specialization); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button type="submit">Search</button>
</form>

<h3>Staff Details</h3>
<table border="1">
    <thead>
        <tr>
            <th>Staff ID</th>
            <th>Full Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $staffDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($staff->id); ?></td>
                <td><?php echo e($staff->fullname); ?></td>
                <td>
                    <button onclick="selectStaff(<?php echo e($staff->id); ?>)">Select</button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>


<?php /**PATH C:\Users\giftg\beaconfolder\BeaconChildrenCenter\resources\views/receiptionist/visits.blade.php ENDPATH**/ ?>