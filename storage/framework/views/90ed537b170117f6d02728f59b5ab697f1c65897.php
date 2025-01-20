<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'column',
    'isClickDisabled' => false,
    'record',
    'recordAction' => null,
    'recordKey' => null,
    'recordUrl' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'column',
    'isClickDisabled' => false,
    'record',
    'recordAction' => null,
    'recordKey' => null,
    'recordUrl' => null,
]); ?>
<?php foreach (array_filter(([
    'column',
    'isClickDisabled' => false,
    'record',
    'recordAction' => null,
    'recordKey' => null,
    'recordUrl' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $action = $column->getAction();
    $name = $column->getName();
    $shouldOpenUrlInNewTab = $column->shouldOpenUrlInNewTab();
    $tooltip = $column->getTooltip();
    $url = $column->getUrl();

    $columnClasses = \Illuminate\Support\Arr::toCssClasses([
        'flex w-full',
        match ($column->getAlignment()) {
            'center' => 'justify-center text-center',
            'end' => 'justify-end text-end',
            'left' => 'justify-start text-left',
            'right' => 'justify-end text-right',
            'justify' => 'justify-between text-justify',
            default => 'justify-start text-start',
        },
    ]);

    $slot = $column->viewData(['recordKey' => $recordKey]);
?>

<div
    <?php if($tooltip): ?>
        x-data="{}"
        x-tooltip.raw="<?php echo e($tooltip); ?>"
    <?php endif; ?>
    <?php echo e($attributes->class(['filament-tables-column-wrapper'])); ?>

>
    <?php if(($url || ($recordUrl && $action === null)) && (! $isClickDisabled)): ?>
        <a
            href="<?php echo e($url ?: $recordUrl); ?>"
            <?php echo $shouldOpenUrlInNewTab ? 'target="_blank"' : null; ?>

            class="<?php echo e($columnClasses); ?>"
        >
            <?php echo e($slot); ?>

        </a>
    <?php elseif(($action || $recordAction) && (! $isClickDisabled)): ?>
        <?php
            if ($action instanceof \Filament\Tables\Actions\Action) {
                $wireClickAction = "mountTableAction('{$action->getName()}', '{$recordKey}')";
            } elseif ($action) {
                $wireClickAction = "callTableColumnAction('{$name}', '{$recordKey}')";
            } else {
                if ($this->getCachedTableAction($recordAction)) {
                    $wireClickAction = "mountTableAction('{$recordAction}', '{$recordKey}')";
                } else {
                    $wireClickAction = "{$recordAction}('{$recordKey}')";
                }
            }
        ?>

        <button
            wire:click="<?php echo e($wireClickAction); ?>"
            wire:target="<?php echo e($wireClickAction); ?>"
            wire:loading.attr="disabled"
            wire:loading.class="cursor-wait opacity-70"
            type="button"
            class="<?php echo e($columnClasses); ?>"
        >
            <?php echo e($slot); ?>

        </button>
    <?php else: ?>
        <div class="<?php echo e($columnClasses); ?>">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\vendor\filament\tables\src\/../resources/views/components/columns/column.blade.php ENDPATH**/ ?>