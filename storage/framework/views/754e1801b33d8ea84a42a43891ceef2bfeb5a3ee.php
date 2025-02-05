<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'columns' => '3',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'columns' => '3',
]); ?>
<?php foreach (array_filter(([
    'columns' => '3',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $columns = (int) $columns;
?>

<div
    <?php echo e($attributes->class([
            'filament-stats grid gap-4 lg:gap-8',
            'md:grid-cols-3' => $columns === 3,
            'md:grid-cols-1' => $columns === 1,
            'md:grid-cols-2' => $columns === 2,
            'md:grid-cols-2 xl:grid-cols-4' => $columns === 4,
        ])); ?>

>
    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-2\vendor\filament\filament\src\/../resources/views/components/stats/index.blade.php ENDPATH**/ ?>