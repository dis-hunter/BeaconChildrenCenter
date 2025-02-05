<?php
    $affixLabelClasses = [
        'whitespace-nowrap group-focus-within:text-primary-500',
        'text-gray-400' => ! $errors->has($getStatePath()),
        'text-danger-400' => $errors->has($getStatePath()),
    ];
?>

<?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $getFieldWrapperView()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => $getId(),'label' => $getLabel(),'label-sr-only' => $isLabelHidden(),'has-nested-recursive-validation-rules' => true,'helper-text' => $getHelperText(),'hint' => $getHint(),'hint-action' => $getHintAction(),'hint-color' => $getHintColor(),'hint-icon' => $getHintIcon(),'required' => $isRequired(),'state-path' => $getStatePath()]); ?>
    <div
        <?php echo e($attributes->merge($getExtraAttributes())->class(['filament-forms-select-component group flex items-center space-x-1 rtl:space-x-reverse'])); ?>

    >
        <?php if(($prefixAction = $getPrefixAction()) && (! $prefixAction->isHidden())): ?>
            <?php echo e($prefixAction); ?>

        <?php endif; ?>

        <?php if($icon = $getPrefixIcon()): ?>
            <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if(filled($label = $getPrefixLabel())): ?>
            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses($affixLabelClasses) ?>">
                <?php echo e($label); ?>

            </span>
        <?php endif; ?>

        <div class="min-w-0 flex-1">
            <?php if (! ($isSearchable() || $isMultiple())): ?>
                <select
                    <?php echo $isAutofocused() ? 'autofocus' : null; ?>

                    <?php echo $isDisabled() ? 'disabled' : null; ?>

                    id="<?php echo e($getId()); ?>"
                    <?php echo e($applyStateBindingModifiers('wire:model')); ?>="<?php echo e($getStatePath()); ?>"
                    dusk="filament.forms.<?php echo e($getStatePath()); ?>"
                    <?php if(! $isConcealed()): ?>
                        <?php echo $isRequired() ? 'required' : null; ?>

                    <?php endif; ?>
                    <?php echo e($attributes->merge($getExtraInputAttributes())->merge($getExtraAttributes())->class([
                            'filament-forms-input block w-full rounded-lg text-gray-900 shadow-sm outline-none transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70',
                            'dark:bg-gray-700 dark:text-white dark:focus:border-primary-500' => config('forms.dark_mode'),
                            'border-gray-300' => ! $errors->has($getStatePath()),
                            'dark:border-gray-600' => (! $errors->has($getStatePath())) && config('forms.dark_mode'),
                            'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),
                            'dark:border-danger-400 dark:ring-danger-400' => $errors->has($getStatePath()) && config('forms.dark_mode'),
                        ])); ?>

                >
                    <?php if (! ($isPlaceholderSelectionDisabled())): ?>
                        <option value=""><?php echo e($getPlaceholder()); ?></option>
                    <?php endif; ?>

                    <?php $__currentLoopData = $getOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($value); ?>"
                            <?php echo $isOptionDisabled($value, $label) ? 'disabled' : null; ?>

                        >
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php else: ?>
                <div
                    x-data="selectFormComponent({
                                isHtmlAllowed: <?php echo \Illuminate\Support\Js::from($isHtmlAllowed())->toHtml() ?>,
                                getOptionLabelUsing: async () => {
                                    return await $wire.getSelectOptionLabel(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>)
                                },
                                getOptionLabelsUsing: async () => {
                                    return await $wire.getSelectOptionLabels(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>)
                                },
                                getOptionsUsing: async () => {
                                    return await $wire.getSelectOptions(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>)
                                },
                                getSearchResultsUsing: async (search) => {
                                    return await $wire.getSelectSearchResults(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>, search)
                                },
                                isAutofocused: <?php echo \Illuminate\Support\Js::from($isAutofocused())->toHtml() ?>,
                                isMultiple: <?php echo \Illuminate\Support\Js::from($isMultiple())->toHtml() ?>,
                                hasDynamicOptions: <?php echo \Illuminate\Support\Js::from($hasDynamicOptions())->toHtml() ?>,
                                hasDynamicSearchResults: <?php echo \Illuminate\Support\Js::from($hasDynamicSearchResults())->toHtml() ?>,
                                loadingMessage: <?php echo \Illuminate\Support\Js::from($getLoadingMessage())->toHtml() ?>,
                                maxItems: <?php echo \Illuminate\Support\Js::from($getMaxItems())->toHtml() ?>,
                                maxItemsMessage: <?php echo \Illuminate\Support\Js::from($getMaxItemsMessage())->toHtml() ?>,
                                noSearchResultsMessage: <?php echo \Illuminate\Support\Js::from($getNoSearchResultsMessage())->toHtml() ?>,
                                options: <?php echo \Illuminate\Support\Js::from($getOptionsForJs())->toHtml() ?>,
                                optionsLimit: <?php echo \Illuminate\Support\Js::from($getOptionsLimit())->toHtml() ?>,
                                placeholder: <?php echo \Illuminate\Support\Js::from($getPlaceholder())->toHtml() ?>,
                                position: <?php echo \Illuminate\Support\Js::from($getPosition())->toHtml() ?>,
                                isPlaceholderSelectionDisabled: <?php echo \Illuminate\Support\Js::from($isPlaceholderSelectionDisabled())->toHtml() ?>,
                                searchDebounce: <?php echo \Illuminate\Support\Js::from($getSearchDebounce())->toHtml() ?>,
                                searchingMessage: <?php echo \Illuminate\Support\Js::from($getSearchingMessage())->toHtml() ?>,
                                searchPrompt: <?php echo \Illuminate\Support\Js::from($getSearchPrompt())->toHtml() ?>,
                                searchableOptionFields: <?php echo \Illuminate\Support\Js::from($getSearchableOptionFields())->toHtml() ?>,
                                state: $wire.<?php echo e($applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')')); ?>,
                            })"
                    x-on:keydown.esc="select.dropdown.isActive && $event.stopPropagation()"
                    wire:ignore
                    <?php echo e($attributes
                            ->merge($getExtraAttributes())
                            ->merge($getExtraAlpineAttributes())
                            ->class(['filament-forms-input'])); ?>

                    x-bind:class="{
                        'choices--error': <?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?> in $wire.__instance.serverMemo.errors,
                    }"
                >
                    <select
                        x-ref="input"
                        id="<?php echo e($getId()); ?>"
                        <?php echo $isDisabled() ? 'disabled' : null; ?>

                        <?php echo $isMultiple() ? 'multiple' : null; ?>

                        <?php echo e($getExtraInputAttributeBag()); ?>

                    ></select>
                </div>
            <?php endif; ?>
        </div>

        <?php if(filled($label = $getSuffixLabel())): ?>
            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses($affixLabelClasses) ?>">
                <?php echo e($label); ?>

            </span>
        <?php endif; ?>

        <?php if($icon = $getSuffixIcon()): ?>
            <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php if(($suffixAction = $getSuffixAction()) && (! $suffixAction->isHidden())): ?>
            <?php echo e($suffixAction); ?>

        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
<?php /**PATH C:\Users\sharo\Downloads\Beacon's\BeaconChildrenCenter-2\vendor\filament\forms\src\/../resources/views/components/select.blade.php ENDPATH**/ ?>