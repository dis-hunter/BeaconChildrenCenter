<?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $getFieldWrapperView()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => $getId(),'label' => $getLabel(),'label-sr-only' => $isLabelHidden(),'helper-text' => $getHelperText(),'hint' => $getHint(),'hint-action' => $getHintAction(),'hint-color' => $getHintColor(),'hint-icon' => $getHintIcon(),'required' => $isRequired(),'state-path' => $getStatePath()]); ?>
    <div
        x-data="keyValueFormComponent({
                    state: $wire.<?php echo e($applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')')); ?>,
                })"
        <?php echo e($attributes->merge($getExtraAttributes())->class(['filament-forms-key-value-component'])); ?>

        <?php echo e($getExtraAlpineAttributeBag()); ?>

    >
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'divide-y overflow-hidden rounded-xl border border-gray-300 bg-white shadow-sm',
                'dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-700' => config('forms.dark_mode'),
            ]) ?>"
        >
            <table
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'w-full table-auto divide-y text-start',
                    'dark:divide-gray-700' => config('forms.dark_mode'),
                ]) ?>"
            >
                <thead>
                    <tr
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'bg-gray-50',
                            'dark:bg-gray-800/60' => config('forms.dark_mode'),
                        ]) ?>"
                    >
                        <th
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'whitespace-nowrap px-4 py-2 text-start text-sm font-medium text-gray-600',
                                'dark:text-gray-300' => config('forms.dark_mode'),
                            ]) ?>"
                            scope="col"
                        >
                            <?php echo e($getKeyLabel()); ?>

                        </th>

                        <th
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'whitespace-nowrap px-4 py-2 text-start text-sm font-medium text-gray-600',
                                'dark:text-gray-300' => config('forms.dark_mode'),
                            ]) ?>"
                            scope="col"
                        >
                            <?php echo e($getValueLabel()); ?>

                        </th>

                        <?php if(($canDeleteRows() || $isReorderable()) && $isEnabled()): ?>
                            <th
                                scope="col"
                                x-show="rows.length"
                                class="<?php echo e(($canDeleteRows() && $isReorderable()) ? 'w-16' : 'w-12'); ?>"
                            >
                                <span class="sr-only"></span>
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody
                    <?php if($isReorderable()): ?>
                        x-sortable
                        x-on:end="reorderRows($event)"
                    <?php endif; ?>
                    x-ref="tableBody"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'divide-y whitespace-nowrap',
                        'dark:divide-gray-600' => config('forms.dark_mode'),
                    ]) ?>"
                >
                    <template
                        x-for="(row, index) in rows"
                        x-bind:key="index"
                        x-ref="rowTemplate"
                    >
                        <tr
                            <?php if($isReorderable()): ?>
                                x-bind:x-sortable-item="row.key"
                            <?php endif; ?>
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'divide-x rtl:divide-x-reverse',
                                'dark:divide-gray-600' => config('forms.dark_mode'),
                            ]) ?>"
                        >
                            <td>
                                <input
                                    type="text"
                                    x-model="row.key"
                                    x-on:input.debounce.<?php echo e($getDebounce() ?? '500ms'); ?>="updateState"
                                    <?php echo ($placeholder = $getKeyPlaceholder()) ? "placeholder=\"{$placeholder}\"" : ''; ?>

                                    <?php if((! $canEditKeys()) || $isDisabled()): ?>
                                        disabled
                                    <?php endif; ?>
                                    class="w-full border-0 bg-transparent px-4 py-3 font-mono text-sm focus:ring-0"
                                />
                            </td>

                            <td class="whitespace-nowrap">
                                <input
                                    type="text"
                                    x-model="row.value"
                                    x-on:input.debounce.<?php echo e($getDebounce() ?? '500ms'); ?>="updateState"
                                    <?php echo ($placeholder = $getValuePlaceholder()) ? "placeholder=\"{$placeholder}\"" : ''; ?>

                                    <?php if((! $canEditValues()) || $isDisabled()): ?>
                                        disabled
                                    <?php endif; ?>
                                    class="w-full border-0 bg-transparent px-4 py-3 font-mono text-sm focus:ring-0"
                                />
                            </td>

                            <?php if(($canDeleteRows() || $isReorderable()) && $isEnabled()): ?>
                                <td class="whitespace-nowrap">
                                    <div
                                        class="flex items-center justify-center gap-2"
                                    >
                                        <?php if($isReorderable()): ?>
                                            <button
                                                x-sortable-handle
                                                type="button"
                                                class="text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                            >
                                                <?php if (isset($component)) { $__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e = $component; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-o-switch-vertical'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e)): ?>
<?php $component = $__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e; ?>
<?php unset($__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e); ?>
<?php endif; ?>

                                                <span class="sr-only">
                                                    <?php echo e($getReorderButtonLabel()); ?>

                                                </span>
                                            </button>
                                        <?php endif; ?>

                                        <?php if($canDeleteRows()): ?>
                                            <button
                                                x-on:click="deleteRow(index)"
                                                type="button"
                                                class="text-danger-600 hover:text-danger-700"
                                            >
                                                <?php if (isset($component)) { $__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e = $component; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-o-trash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e)): ?>
<?php $component = $__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e; ?>
<?php unset($__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e); ?>
<?php endif; ?>

                                                <span class="sr-only">
                                                    <?php echo e($getDeleteButtonLabel()); ?>

                                                </span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    </template>
                </tbody>
            </table>

            <?php if($canAddRows() && $isEnabled()): ?>
                <button
                    x-on:click="addRow"
                    type="button"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'flex w-full items-center space-x-1 px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:bg-gray-50 rtl:space-x-reverse',
                        'dark:bg-gray-800/60 dark:text-white dark:hover:bg-gray-800/30' => config('forms.dark_mode'),
                    ]) ?>"
                >
                    <?php if (isset($component)) { $__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e = $component; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('heroicon-s-plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e)): ?>
<?php $component = $__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e; ?>
<?php unset($__componentOriginalcd9972c8156dfa6e5fd36675ca7bf5f21b506e2e); ?>
<?php endif; ?>

                    <span>
                        <?php echo e($getAddButtonLabel()); ?>

                    </span>
                </button>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
<?php /**PATH D:\github\BeaconChildrenCenter\vendor\filament\forms\src\/../resources/views/components/key-value.blade.php ENDPATH**/ ?>