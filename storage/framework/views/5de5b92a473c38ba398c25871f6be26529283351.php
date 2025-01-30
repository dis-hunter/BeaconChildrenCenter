<?php
    $isAside = $isAside();
    $isCollapsed = $isCollapsed();
    $isCollapsible = $isCollapsible() && (! $isAside);
    $isCompact = $isCompact();
    $isFormBefore = $isFormBefore();
?>

<div
    <?php if($isCollapsible): ?>
        x-data="{
            isCollapsed: <?php echo \Illuminate\Support\Js::from($isCollapsed)->toHtml() ?>,
        }"
        x-on:open-form-section.window="if ($event.detail.id == $el.id) isCollapsed = false"
        x-on:collapse-form-section.window="if ($event.detail.id == $el.id) isCollapsed = true"
        x-on:toggle-form-section.window="if ($event.detail.id == $el.id) isCollapsed = ! isCollapsed"
        x-on:expand-concealing-component.window="
            error = $el.querySelector('[data-validation-error]')

            if (! error) {
                return
            }

            isCollapsed = false

            if (document.body.querySelector('[data-validation-error]') !== error) {
                return
            }

            setTimeout(
                () =>
                    $el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                        inline: 'start',
                    }),
                200,
            )
        "
    <?php endif; ?>
    id="<?php echo e($getId()); ?>"
    <?php echo e($attributes
            ->merge($getExtraAttributes())
            ->class([
                'filament-forms-section-component',
                'rounded-xl border border-gray-300 bg-white' => ! $isAside,
                'grid grid-cols-1' => $isAside,
                'md:grid-cols-2' => $isAside && ! $isCompact,
                'md:grid-cols-3' => $isAside && $isCompact,
                'md:order-last' => $isFormBefore,
                'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode') && ! $isAside,
            ])); ?>

    <?php echo e($getExtraAlpineAttributeBag()); ?>

>
    <div
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'filament-forms-section-header-wrapper flex overflow-hidden rounded-t-xl rtl:space-x-reverse',
            'min-h-[40px]' => $isCompact,
            'min-h-[56px]' => ! $isCompact,
            'pb-4' => $isAside,
            'pr-6' => $isAside && ! $isFormBefore,
            'pl-6' => $isAside && $isFormBefore,
            'items-center bg-gray-100 px-4 py-2' => ! $isAside,
            'dark:bg-gray-900' => config('forms.dark_mode') && (! $isAside),
        ]) ?>"
        <?php if($isCollapsible): ?>
            x-bind:class="{ 'rounded-b-xl': isCollapsed }"
            x-on:click="isCollapsed = ! isCollapsed"
        <?php endif; ?>
    >
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'filament-forms-section-header flex-1 space-y-1',
                'cursor-pointer' => $isCollapsible,
            ]) ?>"
        >
            <h3
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'pointer-events-none flex flex-row items-center font-bold tracking-tight',
                    'text-xl' => ! $isCompact || $isAside,
                ]) ?>"
            >
                <?php if($icon = $getIcon()): ?>
                    <?php if (isset($component)) { $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9 = $component; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\Support\Arr::toCssClasses([
                            'mr-1',
                            'h-4 w-4' => $isCompact && ! $isAside,
                            'h-6 w-6' => ! $isCompact || $isAside,
                        ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9)): ?>
<?php $component = $__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9; ?>
<?php unset($__componentOriginal3bf0a20793be3eca9a779778cf74145887b021b9); ?>
<?php endif; ?>
                <?php endif; ?>

                <?php echo e($getHeading()); ?>

            </h3>

            <?php if($description = $getDescription()): ?>
                <p
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'text-gray-500',
                        'text-sm' => $isCompact && ! $isAside,
                        'text-base' => ! $isCompact || $isAside,
                    ]) ?>"
                >
                    <?php echo e($description); ?>

                </p>
            <?php endif; ?>
        </div>

        <?php if($isCollapsible): ?>
            <button
                x-on:click.stop="isCollapsed = ! isCollapsed"
                x-bind:class="{
                    '-rotate-180': ! isCollapsed,
                }"
                type="button"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'flex transform items-center justify-center rounded-full text-primary-500 outline-none hover:bg-gray-500/5 focus:bg-primary-500/10',
                    'h-10 w-10' => ! $isCompact,
                    '-my-1 h-8 w-8' => $isCompact,
                    '-rotate-180' => ! $isCollapsed,
                ]) ?>"
            >
                <svg
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'h-7 w-7' => ! $isCompact,
                        'h-5 w-5' => $isCompact,
                    ]) ?>"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>
        <?php endif; ?>
    </div>

    <div
        <?php if($isCollapsible): ?>
            x-bind:class="{ 'invisible h-0 !m-0 overflow-y-hidden': isCollapsed }"
            x-bind:aria-expanded="(! isCollapsed).toString()"
        <?php if($isCollapsed): ?> x-cloak <?php endif; ?>
        <?php endif; ?>
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'filament-forms-section-content-wrapper',
            'col-span-2' => $isAside && $isCompact,
            'md:order-first' => $isFormBefore,
        ]) ?>"
    >
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'filament-forms-section-content',
                'rounded-xl border border-gray-300 bg-white' => $isAside,
                'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode') && $isAside,
                'p-6' => ! $isCompact || $isAside,
                'p-4' => $isCompact && ! $isAside,
            ]) ?>"
        >
            <?php echo e($getChildComponentContainer()); ?>

        </div>
    </div>
</div>
<?php /**PATH D:\github\BeaconChildrenCenter\vendor\filament\forms\src\/../resources/views/components/section.blade.php ENDPATH**/ ?>