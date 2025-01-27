
<?php $__env->startSection('title', 'Invoice Details'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Hide buttons when printing */
    @media print {
        button, a {
            display: none !important;
        }
    }
</style>

<div class="container">
    <h2>Invoice Details</h2>
    <p><strong>Patient Name:</strong> <?php echo e($child->full_name); ?></p>
    <p><strong>Registration Number:</strong> <?php echo e($child->registration_number); ?></p>
    <p><strong>Gender:</strong> <?php echo e($gender); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo e(\Carbon\Carbon::parse($child->dob)->format('d M, Y')); ?></p>

    <h3>Services</h3>
    <ul>
        <?php $__currentLoopData = $invoice->invoice_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($service); ?>: KES <?php echo e(number_format($price, 2)); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <p><strong>Total Amount:</strong> KES <?php echo e(number_format($invoice->total_amount, 2)); ?></p>

    <button onclick="window.print()" class="btn btn-success">Print</button>
    <a href="<?php echo e(route('invoices')); ?>" class="btn btn-secondary">Back</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('reception.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/reception/invoice-details.blade.php ENDPATH**/ ?>