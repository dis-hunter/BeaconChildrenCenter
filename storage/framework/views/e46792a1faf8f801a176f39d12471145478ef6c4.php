<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'actions',
    'alignment' => null,
    'record' => null,
    'wrap' => false,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'actions',
    'alignment' => null,
    'record' => null,
    'wrap' => false,
]); ?>
<?php foreach (array_filter(([
    'actions',
    'alignment' => null,
    'record' => null,
    'wrap' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    <?php echo e($attributes->class([
            'filament-tables-actions-container flex items-center gap-4',
            'flex-wrap' => $wrap,
            'md:flex-nowrap' => $wrap === '-md',
            match ($alignment ?? config('tables.layout.action_alignment') ?? config('tables.layout.actions.cell.alignment')) {
                'center' => 'justify-center',
                'left' => 'justify-start',
                'left md:right' => 'justify-start md:justify-end',
                default => 'justify-end',
            },
        ])); ?>

>
    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(! $action->record($record)->isHidden()): ?>
            <?php echo e($action); ?>

        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\Users\User\Downloads\Beacon\BeaconChildrenCenter\vendor\filament\tables\src\/../resources/views/components/actions/index.blade.php ENDPATH**/ ?>