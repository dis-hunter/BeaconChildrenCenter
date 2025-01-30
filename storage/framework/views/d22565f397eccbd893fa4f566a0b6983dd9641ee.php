<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'alignment' => 'left',
    'darkMode' => false,
    'fullWidth' => false,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'alignment' => 'left',
    'darkMode' => false,
    'fullWidth' => false,
]); ?>
<?php foreach (array_filter(([
    'alignment' => 'left',
    'darkMode' => false,
    'fullWidth' => false,
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
            'filament-modal-actions',
            'flex flex-wrap items-center gap-4 rtl:space-x-reverse' => ! $fullWidth,
            'flex-row-reverse space-x-reverse' => (! $fullWidth) && ($alignment === 'right'),
            'justify-center' => (! $fullWidth) && ($alignment === 'center'),
            'grid grid-cols-[repeat(auto-fit,minmax(0,1fr))] gap-2' => $fullWidth,
        ])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\Users\User\Hospital\BeaconChildrenCenter\vendor\filament\support\src\/../resources/views/components/modal/actions.blade.php ENDPATH**/ ?>