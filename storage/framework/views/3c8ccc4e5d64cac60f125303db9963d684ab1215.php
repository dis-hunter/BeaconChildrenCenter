<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Therapist Appointments</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Child ID</th>
                    <th>Doctor ID</th>
                    <th>Staff Name</th>
                    <th>Specialization</th>
                    <th>Appointment Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($appointment->id); ?></td>
                        <td><?php echo e($appointment->child_id); ?></td>
                        <td><?php echo e($appointment->doctor_id); ?></td>
                        <td><?php echo e($appointment->staff_name); ?></td>
                        <td><?php echo e($appointment->specialization); ?></td>
                        <td><?php echo e($appointment->appointment_date); ?></td>
                        <td><?php echo e($appointment->start_time); ?></td>
                        <td><?php echo e($appointment->end_time); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">No appointments found for therapists.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/therapy_appointments.blade.php ENDPATH**/ ?>