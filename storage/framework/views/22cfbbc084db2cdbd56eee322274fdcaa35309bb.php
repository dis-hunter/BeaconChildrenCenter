<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'breadcrumbs' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'breadcrumbs' => [],
]); ?>
<?php foreach (array_filter(([
    'breadcrumbs' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<header
    <?php echo e($attributes->class([
            'filament-main-topbar sticky top-0 z-10 flex h-16 w-full shrink-0 items-center border-b bg-white',
            'dark:border-gray-700 dark:bg-gray-800' => config('filament.dark_mode'),
        ])); ?>

>
    <div class="flex w-full items-center px-2 sm:px-4 md:px-6 lg:px-8">
        <button
            x-cloak
            x-data="{}"
            x-bind:aria-label="
                $store.sidebar.isOpen
                    ? '<?php echo e(__('filament::layout.buttons.sidebar.collapse.label')); ?>'
                    : '<?php echo e(__('filament::layout.buttons.sidebar.expand.label')); ?>'
            "
            x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'filament-sidebar-open-button flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-primary-500 outline-none hover:bg-gray-500/5 focus:bg-primary-500/10',
                'lg:mr-4 rtl:lg:ml-4 rtl:lg:mr-0' => config('filament.layout.sidebar.is_collapsible_on_desktop'),
                'lg:hidden' => ! (config('filament.layout.sidebar.is_collapsible_on_desktop') && (config('filament.layout.sidebar.collapsed_width') === 0)),
            ]) ?>"
        >
            <svg
                class="h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
            </svg>
        </button>

        <div class="flex flex-1 items-center justify-between">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.layouts.app.topbar.breadcrumbs','data' => ['breadcrumbs' => $breadcrumbs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::layouts.app.topbar.breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('filament.core.global-search')->html();
<<<<<<< HEAD:storage/framework/views/a3057cb900b4b61c9ab2c41158401038892f3ef4.php
} elseif ($_instance->childHasBeenRendered('HDgSAMc')) {
    $componentId = $_instance->getRenderedChildComponentId('HDgSAMc');
    $componentTag = $_instance->getRenderedChildComponentTagName('HDgSAMc');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('HDgSAMc');
} else {
    $response = \Livewire\Livewire::mount('filament.core.global-search');
    $html = $response->html();
    $_instance->logRenderedChild('HDgSAMc', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
} elseif ($_instance->childHasBeenRendered('DDymliU')) {
    $componentId = $_instance->getRenderedChildComponentId('DDymliU');
    $componentTag = $_instance->getRenderedChildComponentTagName('DDymliU');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DDymliU');
} else {
    $response = \Livewire\Livewire::mount('filament.core.global-search');
    $html = $response->html();
    $_instance->logRenderedChild('DDymliU', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>> 0c5dcb4b7e20e8e98ae33e49ff334f869c681582:storage/framework/views/22cfbbc084db2cdbd56eee322274fdcaa35309bb.php
}
echo $html;
?>

            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('filament.core.notifications')->html();
<<<<<<< HEAD:storage/framework/views/a3057cb900b4b61c9ab2c41158401038892f3ef4.php
} elseif ($_instance->childHasBeenRendered('M8W70Uz')) {
    $componentId = $_instance->getRenderedChildComponentId('M8W70Uz');
    $componentTag = $_instance->getRenderedChildComponentTagName('M8W70Uz');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('M8W70Uz');
} else {
    $response = \Livewire\Livewire::mount('filament.core.notifications');
    $html = $response->html();
    $_instance->logRenderedChild('M8W70Uz', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
} elseif ($_instance->childHasBeenRendered('gfvZoI2')) {
    $componentId = $_instance->getRenderedChildComponentId('gfvZoI2');
    $componentTag = $_instance->getRenderedChildComponentTagName('gfvZoI2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('gfvZoI2');
} else {
    $response = \Livewire\Livewire::mount('filament.core.notifications');
    $html = $response->html();
    $_instance->logRenderedChild('gfvZoI2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>> 0c5dcb4b7e20e8e98ae33e49ff334f869c681582:storage/framework/views/22cfbbc084db2cdbd56eee322274fdcaa35309bb.php
}
echo $html;
?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.layouts.app.topbar.user-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::layouts.app.topbar.user-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\Users\User\Downloads\Beacon\BeaconChildrenCenter\vendor\filament\filament\src\/../resources/views/components/topbar.blade.php ENDPATH**/ ?>