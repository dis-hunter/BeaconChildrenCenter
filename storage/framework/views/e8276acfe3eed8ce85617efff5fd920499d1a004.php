<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'label' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'label' => null,
]); ?>
<?php foreach (array_filter(([
    'label' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<label>
    <input
        <?php echo e($attributes->class([
                'block rounded border-gray-300 text-primary-600 shadow-sm outline-none focus:ring focus:ring-primary-200 focus:ring-opacity-50',
                'dark:border-gray-600 dark:bg-gray-700 dark:checked:border-primary-600 dark:checked:bg-primary-600' => config('tables.dark_mode'),
            ])); ?>

        wire:loading.attr="disabled"
        wire:target="<?php echo e(implode(',', \Filament\Tables\Table::LOADING_TARGETS)); ?>"
        type="checkbox"
    />

    <span class="sr-only">
        <?php echo e($label); ?>

    </span>
</label>
<?php /**PATH C:\Users\User\Downloads\Beacon\BeaconChildrenCenter\vendor\filament\tables\src\/../resources/views/components/checkbox/index.blade.php ENDPATH**/ ?>