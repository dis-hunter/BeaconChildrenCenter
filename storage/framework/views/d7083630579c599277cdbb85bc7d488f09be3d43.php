<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'extraAttributes' => [],
    'isSortColumn' => false,
    'name',
    'sortable' => false,
    'sortDirection',
    'alignment' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'extraAttributes' => [],
    'isSortColumn' => false,
    'name',
    'sortable' => false,
    'sortDirection',
    'alignment' => null,
]); ?>
<?php foreach (array_filter(([
    'extraAttributes' => [],
    'isSortColumn' => false,
    'name',
    'sortable' => false,
    'sortDirection',
    'alignment' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<th
    <?php echo e($attributes
            ->merge($extraAttributes)
            ->class(['filament-tables-header-cell p-0'])); ?>

>
    <button
        <?php if($sortable): ?>
            wire:click="sortTable('<?php echo e($name); ?>')"
        <?php endif; ?>
        type="button"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'flex w-full items-center gap-x-1 whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-600',
            'dark:text-gray-300' => config('tables.dark_mode'),
            'cursor-default' => ! $sortable,
            match ($alignment) {
                'start' => 'justify-start',
                'center' => 'justify-center',
                'end' => 'justify-end',
                'left' => 'justify-start rtl:flex-row-reverse',
                'center' => 'justify-center',
                'right' => 'justify-end rtl:flex-row-reverse',
                default => null,
            },
        ]) ?>"
    >
        <?php if($sortable): ?>
            <span class="sr-only">
                <?php echo e(__('tables::table.sorting.fields.column.label')); ?>

            </span>
        <?php endif; ?>

        <span>
            <?php echo e($slot); ?>

        </span>

        <?php if($sortable): ?>
            <span class="sr-only">
                <?php echo e($sortDirection === 'asc' ? __('tables::table.sorting.fields.direction.options.desc') : __('tables::table.sorting.fields.direction.options.asc')); ?>

            </span>
        <?php endif; ?>

        <?php if($sortable): ?>
            <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $isSortColumn && $sortDirection === 'asc' ? 'heroicon-s-chevron-up' : 'heroicon-s-chevron-down'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 
                    \Illuminate\Support\Arr::toCssClasses([
                        'filament-tables-header-cell-sort-icon h-3 w-3',
                        'dark:text-gray-300' => config('tables.dark_mode'),
                        'opacity-25' => ! $isSortColumn,
                    ])
                ]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
        <?php endif; ?>
    </button>
</th>
<?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-2\vendor\filament\tables\src\/../resources/views/components/header-cell.blade.php ENDPATH**/ ?>