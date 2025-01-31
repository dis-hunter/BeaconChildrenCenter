<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'footer' => null,
    'header' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'footer' => null,
    'header' => null,
]); ?>
<?php foreach (array_filter(([
    'footer' => null,
    'header' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<table
    <?php echo e($attributes->class([
            'filament-tables-table w-full table-auto divide-y text-start',
            'dark:divide-gray-700' => config('tables.dark_mode'),
        ])); ?>

>
    <?php if($header): ?>
        <thead>
            <tr class="bg-gray-500/5">
                <?php echo e($header); ?>

            </tr>
        </thead>
    <?php endif; ?>

    <tbody
        wire:sortable
        wire:end.stop="reorderTable($event.target.sortable.toArray())"
        wire:sortable.options="{ animation: 100 }"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'divide-y whitespace-nowrap',
            'dark:divide-gray-700' => config('tables.dark_mode'),
        ]) ?>"
    >
        <?php echo e($slot); ?>

    </tbody>

    <?php if($footer): ?>
        <tfoot>
            <tr class="bg-gray-50">
                <?php echo e($footer); ?>

            </tr>
        </tfoot>
    <?php endif; ?>
</table>
<?php /**PATH C:\Users\User\Downloads\Beacon\BeaconChildrenCenter\vendor\filament\tables\src\/../resources/views/components/table.blade.php ENDPATH**/ ?>