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
                <td colspan="8" class="text-center">No appointments found for therapists today.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/appointments/partials/therapy_appointments_table.blade.php ENDPATH**/ ?>