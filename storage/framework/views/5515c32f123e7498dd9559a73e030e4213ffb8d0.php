<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
</head>
<body>
    <h1>Doctor Details</h1>
    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><strong>Doctor ID:</strong> <?php echo e($doctor->doctor_id); ?></p>
        <p><strong>Specialization:</strong> <?php echo e($doctor->specialization); ?></p>
        <p><strong>Created At:</strong> <?php echo e($doctor->created_at); ?></p>
        <h2>Staff Details</h2>
        <p><strong>Staff ID:</strong> <?php echo e($doctor->staff_id); ?></p>
        <p><strong>Full Name:</strong> <?php echo e($doctor->fullname); ?></p>
        <p><strong>Telephone:</strong> <?php echo e($doctor->telephone); ?></p>
        <p><strong>Gender:</strong> <?php echo e($doctor->gender_id); ?></p>
        <p><strong>Role:</strong> <?php echo e($doctor->role_id); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/AddDoctor/doctors_display.blade.php ENDPATH**/ ?>