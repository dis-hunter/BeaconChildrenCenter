<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'actions',
    'fullWidth' => false,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'actions',
    'fullWidth' => false,
]); ?>
<?php foreach (array_filter(([
    'actions',
    'fullWidth' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    <?php if(config('filament.layout.forms.actions.are_sticky')): ?>
        x-data="{
            isSticky: false,

            evaluatePageScrollPosition: function () {
                this.isSticky =
                    window.scrollY + window.innerHeight * 2 <=
                    document.body.scrollHeight
            },
        }"
        x-init="evaluatePageScrollPosition"
        x-on:scroll.window="evaluatePageScrollPosition"
        x-bind:class="{
            'filament-form-actions-sticky-panel sticky bottom-0 -mx-4 transform md:-translate-y-4 bg-white p-4 shadow-lg transition ring-1 ring-black/5 md:rounded-xl':
                isSticky,
            'dark:bg-gray-800': <?php echo \Illuminate\Support\Js::from(config('filament.dark_mode'))->toHtml() ?> && isSticky,
        }"
    <?php endif; ?>
>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.pages.actions.index','data' => ['actions' => $actions,'alignment' => config('filament.layout.forms.actions.alignment'),'fullWidth' => $fullWidth,'class' => 'filament-form-actions']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::pages.actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'alignment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(config('filament.layout.forms.actions.alignment')),'full-width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fullWidth),'class' => 'filament-form-actions']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\vendor\filament\filament\src\/../resources/views/components/form/actions.blade.php ENDPATH**/ ?>