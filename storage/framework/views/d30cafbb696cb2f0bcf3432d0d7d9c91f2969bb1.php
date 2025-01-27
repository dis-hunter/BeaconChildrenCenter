
<?php $__env->startSection('title', 'Invoices'); ?>


<?php $__env->startSection('content'); ?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    .container {
        padding: 20px;
    }
</style>

<div class="container">
    <h2 class="text-center">Invoices for <?php echo e(now()->format('d M, Y')); ?></h2>

    <?php if($invoices->isEmpty()): ?>
        <p>No invoices found for today.</p>
    <?php else: ?>
    <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Total Amount</th>
            <th>Invoice Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($invoice->patient_name); ?></td>
                <td>KES <?php echo e(number_format($invoice->total_amount, 2)); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y')); ?></td>
                <td>
                    <a href="<?php echo e(route('invoice.details', ['invoiceId' => $invoice->id])); ?>" class="btn btn-primary">
                        View
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('reception.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/reception/invoice.blade.php ENDPATH**/ ?>