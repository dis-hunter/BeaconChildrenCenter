<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Profile')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.update-profile-information-form')->html();
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('y9OMkp3')) {
    $componentId = $_instance->getRenderedChildComponentId('y9OMkp3');
    $componentTag = $_instance->getRenderedChildComponentTagName('y9OMkp3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('y9OMkp3');
} else {
    $response = \Livewire\Livewire::mount('profile.update-profile-information-form');
    $html = $response->html();
    $_instance->logRenderedChild('y9OMkp3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
<<<<<<<< HEAD:storage/framework/views/6280cfa31a46d2aff575d861f67dce3ca6660baf.php
} elseif ($_instance->childHasBeenRendered('MkCqAPO')) {
    $componentId = $_instance->getRenderedChildComponentId('MkCqAPO');
    $componentTag = $_instance->getRenderedChildComponentTagName('MkCqAPO');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('MkCqAPO');
} else {
    $response = \Livewire\Livewire::mount('profile.update-profile-information-form');
    $html = $response->html();
    $_instance->logRenderedChild('MkCqAPO', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
========
} elseif ($_instance->childHasBeenRendered('6YS3aNj')) {
    $componentId = $_instance->getRenderedChildComponentId('6YS3aNj');
    $componentTag = $_instance->getRenderedChildComponentTagName('6YS3aNj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('6YS3aNj');
} else {
    $response = \Livewire\Livewire::mount('profile.update-profile-information-form');
    $html = $response->html();
    $_instance->logRenderedChild('6YS3aNj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef:storage/framework/views/9ae0d87fee7b86b650891080723e13861f61aa04.php
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
}
echo $html;
?>

                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-border','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('section-border'); ?>
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
            <?php endif; ?>

            <?php if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords())): ?>
                <div class="mt-10 sm:mt-0">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.update-password-form')->html();
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('UqpzX83')) {
    $componentId = $_instance->getRenderedChildComponentId('UqpzX83');
    $componentTag = $_instance->getRenderedChildComponentTagName('UqpzX83');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('UqpzX83');
} else {
    $response = \Livewire\Livewire::mount('profile.update-password-form');
    $html = $response->html();
    $_instance->logRenderedChild('UqpzX83', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
<<<<<<<< HEAD:storage/framework/views/6280cfa31a46d2aff575d861f67dce3ca6660baf.php
} elseif ($_instance->childHasBeenRendered('Qq2Wy0i')) {
    $componentId = $_instance->getRenderedChildComponentId('Qq2Wy0i');
    $componentTag = $_instance->getRenderedChildComponentTagName('Qq2Wy0i');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Qq2Wy0i');
} else {
    $response = \Livewire\Livewire::mount('profile.update-password-form');
    $html = $response->html();
    $_instance->logRenderedChild('Qq2Wy0i', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
========
} elseif ($_instance->childHasBeenRendered('uPty2yg')) {
    $componentId = $_instance->getRenderedChildComponentId('uPty2yg');
    $componentTag = $_instance->getRenderedChildComponentTagName('uPty2yg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('uPty2yg');
} else {
    $response = \Livewire\Livewire::mount('profile.update-password-form');
    $html = $response->html();
    $_instance->logRenderedChild('uPty2yg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef:storage/framework/views/9ae0d87fee7b86b650891080723e13861f61aa04.php
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
}
echo $html;
?>
                </div>

                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-border','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('section-border'); ?>
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
            <?php endif; ?>

            <?php if(Laravel\Fortify\Features::canManageTwoFactorAuthentication()): ?>
                <div class="mt-10 sm:mt-0">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.two-factor-authentication-form')->html();
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('Rz0MtE3')) {
    $componentId = $_instance->getRenderedChildComponentId('Rz0MtE3');
    $componentTag = $_instance->getRenderedChildComponentTagName('Rz0MtE3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Rz0MtE3');
} else {
    $response = \Livewire\Livewire::mount('profile.two-factor-authentication-form');
    $html = $response->html();
    $_instance->logRenderedChild('Rz0MtE3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
<<<<<<<< HEAD:storage/framework/views/6280cfa31a46d2aff575d861f67dce3ca6660baf.php
} elseif ($_instance->childHasBeenRendered('s7kZXD1')) {
    $componentId = $_instance->getRenderedChildComponentId('s7kZXD1');
    $componentTag = $_instance->getRenderedChildComponentTagName('s7kZXD1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('s7kZXD1');
} else {
    $response = \Livewire\Livewire::mount('profile.two-factor-authentication-form');
    $html = $response->html();
    $_instance->logRenderedChild('s7kZXD1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
========
} elseif ($_instance->childHasBeenRendered('nLECKJl')) {
    $componentId = $_instance->getRenderedChildComponentId('nLECKJl');
    $componentTag = $_instance->getRenderedChildComponentTagName('nLECKJl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('nLECKJl');
} else {
    $response = \Livewire\Livewire::mount('profile.two-factor-authentication-form');
    $html = $response->html();
    $_instance->logRenderedChild('nLECKJl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef:storage/framework/views/9ae0d87fee7b86b650891080723e13861f61aa04.php
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
}
echo $html;
?>
                </div>

                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-border','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('section-border'); ?>
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
            <?php endif; ?>

            <div class="mt-10 sm:mt-0">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.logout-other-browser-sessions-form')->html();
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('JEk8H5g')) {
    $componentId = $_instance->getRenderedChildComponentId('JEk8H5g');
    $componentTag = $_instance->getRenderedChildComponentTagName('JEk8H5g');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JEk8H5g');
} else {
    $response = \Livewire\Livewire::mount('profile.logout-other-browser-sessions-form');
    $html = $response->html();
    $_instance->logRenderedChild('JEk8H5g', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
<<<<<<<< HEAD:storage/framework/views/6280cfa31a46d2aff575d861f67dce3ca6660baf.php
} elseif ($_instance->childHasBeenRendered('kJGrUBu')) {
    $componentId = $_instance->getRenderedChildComponentId('kJGrUBu');
    $componentTag = $_instance->getRenderedChildComponentTagName('kJGrUBu');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kJGrUBu');
} else {
    $response = \Livewire\Livewire::mount('profile.logout-other-browser-sessions-form');
    $html = $response->html();
    $_instance->logRenderedChild('kJGrUBu', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
========
} elseif ($_instance->childHasBeenRendered('H7P5Ryu')) {
    $componentId = $_instance->getRenderedChildComponentId('H7P5Ryu');
    $componentTag = $_instance->getRenderedChildComponentTagName('H7P5Ryu');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('H7P5Ryu');
} else {
    $response = \Livewire\Livewire::mount('profile.logout-other-browser-sessions-form');
    $html = $response->html();
    $_instance->logRenderedChild('H7P5Ryu', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef:storage/framework/views/9ae0d87fee7b86b650891080723e13861f61aa04.php
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
}
echo $html;
?>
            </div>

            <?php if(Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures()): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-border','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('section-border'); ?>
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

                <div class="mt-10 sm:mt-0">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.delete-user-form')->html();
<<<<<<< HEAD
} elseif ($_instance->childHasBeenRendered('PVfzFJd')) {
    $componentId = $_instance->getRenderedChildComponentId('PVfzFJd');
    $componentTag = $_instance->getRenderedChildComponentTagName('PVfzFJd');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PVfzFJd');
} else {
    $response = \Livewire\Livewire::mount('profile.delete-user-form');
    $html = $response->html();
    $_instance->logRenderedChild('PVfzFJd', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
=======
<<<<<<<< HEAD:storage/framework/views/6280cfa31a46d2aff575d861f67dce3ca6660baf.php
} elseif ($_instance->childHasBeenRendered('PFJtsRE')) {
    $componentId = $_instance->getRenderedChildComponentId('PFJtsRE');
    $componentTag = $_instance->getRenderedChildComponentTagName('PFJtsRE');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PFJtsRE');
} else {
    $response = \Livewire\Livewire::mount('profile.delete-user-form');
    $html = $response->html();
    $_instance->logRenderedChild('PFJtsRE', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
========
} elseif ($_instance->childHasBeenRendered('PLtaq44')) {
    $componentId = $_instance->getRenderedChildComponentId('PLtaq44');
    $componentTag = $_instance->getRenderedChildComponentTagName('PLtaq44');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PLtaq44');
} else {
    $response = \Livewire\Livewire::mount('profile.delete-user-form');
    $html = $response->html();
    $_instance->logRenderedChild('PLtaq44', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
>>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef:storage/framework/views/9ae0d87fee7b86b650891080723e13861f61aa04.php
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
}
echo $html;
?>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/profile/show.blade.php ENDPATH**/ ?>