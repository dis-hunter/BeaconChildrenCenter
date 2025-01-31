<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'chart' => null,
    'chartColor' => null,
    'color' => null,
    'icon' => null,
    'description' => null,
    'descriptionColor' => null,
    'descriptionIcon' => null,
    'descriptionIconPosition' => 'after',
    'flat' => false,
    'label' => null,
    'tag' => 'div',
    'value' => null,
    'extraAttributes' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'chart' => null,
    'chartColor' => null,
    'color' => null,
    'icon' => null,
    'description' => null,
    'descriptionColor' => null,
    'descriptionIcon' => null,
    'descriptionIconPosition' => 'after',
    'flat' => false,
    'label' => null,
    'tag' => 'div',
    'value' => null,
    'extraAttributes' => [],
]); ?>
<?php foreach (array_filter(([
    'chart' => null,
    'chartColor' => null,
    'color' => null,
    'icon' => null,
    'description' => null,
    'descriptionColor' => null,
    'descriptionIcon' => null,
    'descriptionIconPosition' => 'after',
    'flat' => false,
    'label' => null,
    'tag' => 'div',
    'value' => null,
    'extraAttributes' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<<?php echo $tag; ?>

    <?php echo e($attributes->merge($extraAttributes)->class([
            'filament-stats-card relative rounded-2xl bg-white p-6 shadow',
            'dark:bg-gray-800' => config('filament.dark_mode'),
        ])); ?>

>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'space-y-2',
    ]) ?>">
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'flex items-center space-x-2 text-sm font-medium text-gray-500 rtl:space-x-reverse',
                'dark:text-gray-200' => config('filament.dark_mode'),
            ]) ?>"
        >
            <?php if($icon): ?>
                <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
            <?php endif; ?>

            <span><?php echo e($label); ?></span>
        </div>

        <div class="text-3xl">
            <?php echo e($value); ?>

        </div>

        <?php if($description): ?>
            <div
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'flex items-center space-x-1 text-sm font-medium rtl:space-x-reverse',
                    match ($descriptionColor) {
                        'danger' => 'text-danger-600',
                        'primary' => 'text-primary-600',
                        'success' => 'text-success-600',
                        'warning' => 'text-warning-600',
                        default => 'text-gray-600',
                    },
                ]) ?>"
            >
                <?php if($descriptionIcon && $descriptionIconPosition === 'before'): ?>
                    <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $descriptionIcon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
                <?php endif; ?>

                <span><?php echo e($description); ?></span>

                <?php if($descriptionIcon && $descriptionIconPosition === 'after'): ?>
                    <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $descriptionIcon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if($chart): ?>
        <div
            x-title="filament-stats-card-chart"
            x-data="{
                labels: <?php echo e(json_encode(array_keys($chart))); ?>,

                values: <?php echo e(json_encode(array_values($chart))); ?>,

                init: function () {
                    this.getChart() === undefined ? this.initChart() : this.updateChart()
                },

                initChart: function () {
                    return new Chart(this.$refs.canvas, {
                        type: 'line',
                        data: {
                            labels: this.labels,
                            datasets: [
                                {
                                    data: this.values,
                                    backgroundColor: getComputedStyle(
                                        $refs.backgroundColorElement,
                                    ).color,
                                    borderColor: getComputedStyle($refs.borderColorElement)
                                        .color,
                                    borderWidth: 2,
                                    fill: 'start',
                                    tension: 0.5,
                                },
                            ],
                        },
                        options: {
                            elements: {
                                point: {
                                    radius: 0,
                                },
                            },
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            },
                            scales: {
                                x: {
                                    display: false,
                                },
                                y: {
                                    display: false,
                                },
                            },
                            tooltips: {
                                enabled: false,
                            },
                        },
                    })
                },

                getChart: function () {
                    return Chart.getChart(this.$refs.canvas)
                },

                updateChart: function () {
                    chart = this.getChart()
                    chart.data.labels = this.labels
                    chart.data.datasets[0].data = this.values
                    chart.update()
                },

                updateChartColors: function () {
                    chart = this.getChart()
                    chart.data.datasets[0].backgroundColor = getComputedStyle(
                        $refs.backgroundColorElement,
                    ).color
                    chart.data.datasets[0].borderColor = getComputedStyle(
                        $refs.borderColorElement,
                    ).color
                    chart.update('none')
                },
            }"
            x-on:dark-mode-toggled.window="updateChartColors()"
            class="absolute inset-x-0 bottom-0 overflow-hidden rounded-b-2xl"
        >
            <canvas wire:ignore x-ref="canvas" class="h-6">
                <span
                    x-ref="backgroundColorElement"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        match ($chartColor) {
                            'danger' => \Illuminate\Support\Arr::toCssClasses(['text-danger-50', 'dark:text-danger-700' => config('filament.dark_mode')]),
                            'primary' => \Illuminate\Support\Arr::toCssClasses(['text-primary-50', 'dark:text-primary-700' => config('filament.dark_mode')]),
                            'success' => \Illuminate\Support\Arr::toCssClasses(['text-success-50', 'dark:text-success-700' => config('filament.dark_mode')]),
                            'warning' => \Illuminate\Support\Arr::toCssClasses(['text-warning-50', 'dark:text-warning-700' => config('filament.dark_mode')]),
                            default => \Illuminate\Support\Arr::toCssClasses(['text-gray-50', 'dark:text-gray-700' => config('filament.dark_mode')]),
                        },
                    ]) ?>"
                ></span>

                <span
                    x-ref="borderColorElement"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        match ($chartColor) {
                            'danger' => 'text-danger-400',
                            'primary' => 'text-primary-400',
                            'success' => 'text-success-400',
                            'warning' => 'text-warning-400',
                            default => 'text-gray-400',
                        },
                    ]) ?>"
                ></span>
            </canvas>
        </div>
    <?php endif; ?>
</<?php echo $tag; ?>>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\vendor\filament\filament\src\/../resources/views/components/stats/card.blade.php ENDPATH**/ ?>