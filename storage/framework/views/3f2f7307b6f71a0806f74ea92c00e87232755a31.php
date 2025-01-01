<!DOCTYPE html>
<html>
<head>
    <title>Add Doctor</title>
</head>
<body>
    <form action="/doctors" method="POST">
        <?php echo csrf_field(); ?>
        <label for="staff_id">Staff ID:</label>
        <input type="text" id="staff_id" name="staff_id" required>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required>

        <button type="submit">Add Doctor</button>
    </form>

    <?php if(session('success')): ?>
        <p><?php echo e(session('success')); ?></p>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-3\resources\views/doctor_form.blade.php ENDPATH**/ ?>