<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'allSelectableRecordsCount',
    'colspan',
    'deselectAllRecordsAction' => 'deselectAllRecords',
    'end' => null,
    'selectAllRecordsAction' => 'selectAllRecords',
    'selectedRecordsCount',
    'selectedRecordsPropertyName' => 'selectedRecords',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'allSelectableRecordsCount',
    'colspan',
    'deselectAllRecordsAction' => 'deselectAllRecords',
    'end' => null,
    'selectAllRecordsAction' => 'selectAllRecords',
    'selectedRecordsCount',
    'selectedRecordsPropertyName' => 'selectedRecords',
]); ?>
<?php foreach (array_filter(([
    'allSelectableRecordsCount',
    'colspan',
    'deselectAllRecordsAction' => 'deselectAllRecords',
    'end' => null,
    'selectAllRecordsAction' => 'selectAllRecords',
    'selectedRecordsCount',
    'selectedRecordsPropertyName' => 'selectedRecords',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    wire:key="<?php echo e($this->id); ?>.table.selection.indicator"
    x-cloak
    <?php echo e($attributes->class(['filament-tables-selection-indicator flex flex-wrap items-center gap-1 whitespace-nowrap bg-primary-500/10 px-4 py-2 text-sm'])); ?>

>
    <?php echo e($slot); ?>


    <div class="flex-1">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-support::components.loading-indicator','data' => ['xShow' => 'isLoading','class' => 'mr-3 inline-block h-4 w-4 text-primary-500 rtl:ml-3 rtl:mr-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament-support::loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-show' => 'isLoading','class' => 'mr-3 inline-block h-4 w-4 text-primary-500 rtl:ml-3 rtl:mr-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <span
            class="<?php echo \Illuminate\Support\Arr::toCssClasses(['dark:text-white' => config('tables.dark_mode')]) ?>"
            x-text="
                window.pluralize(<?php echo \Illuminate\Support\Js::from(__('tables::table.selection_indicator.selected_count'))->toHtml() ?>, <?php echo e($selectedRecordsPropertyName); ?>.length, {
                    count: <?php echo e($selectedRecordsPropertyName); ?>.length,
                })
            "
        ></span>

        <span
            id="<?php echo e($this->id); ?>.table.selection.indicator.record-count.<?php echo e($allSelectableRecordsCount); ?>"
            x-show="<?php echo e($allSelectableRecordsCount); ?> !== <?php echo e($selectedRecordsPropertyName); ?>.length"
        >
            <button
                x-on:click="<?php echo e($selectAllRecordsAction); ?>"
                class="text-sm font-medium text-primary-600"
                type="button"
            >
                <?php echo e(trans_choice('tables::table.selection_indicator.buttons.select_all.label', $allSelectableRecordsCount)); ?>.
            </button>
        </span>

        <span>
            <button
                x-on:click="<?php echo e($deselectAllRecordsAction); ?>"
                class="text-sm font-medium text-primary-600"
                type="button"
            >
                <?php echo e(__('tables::table.selection_indicator.buttons.deselect_all.label')); ?>.
            </button>
        </span>
    </div>

    <?php echo e($end); ?>

</div>
<?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-1\vendor\filament\tables\src\/../resources/views/components/selection-indicator.blade.php ENDPATH**/ ?>