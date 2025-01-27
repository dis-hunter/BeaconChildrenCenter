<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'options',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'options',
]); ?>
<?php foreach (array_filter(([
    'options',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    class="filament-tables-pagination-records-per-page-selector flex items-center space-x-2 rtl:space-x-reverse"
>
    <label>
        <select
            wire:model="tableRecordsPerPage"
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'h-8 rounded-lg border-gray-300 pr-8 text-sm leading-none shadow-sm outline-none transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500',
                'dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500' => config('tables.dark_mode'),
            ]) ?>"
        >
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($option); ?>">
                    <?php echo e($option === -1 ? __('tables::table.pagination.fields.records_per_page.options.all') : $option); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <span
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'text-sm font-medium',
                'dark:text-white' => config('tables.dark_mode'),
            ]) ?>"
        >
            <?php echo e(__('tables::table.pagination.fields.records_per_page.label')); ?>

        </span>
    </label>
</div>
<?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter\vendor\filament\tables\src\/../resources/views/components/pagination/records-per-page-selector.blade.php ENDPATH**/ ?>