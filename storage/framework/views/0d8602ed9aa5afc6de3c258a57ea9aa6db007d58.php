<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>
<body>
    <nav>
        <!-- Livewire actions for switching views -->
        <a href="#" wire:click.prevent="$emit('switchView', 'home')">Home</a>
<a href="#" wire:click.prevent="$emit('switchView', 'about')">About</a>

    </nav>

    <main>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('content-switcher')->html();
} elseif ($_instance->childHasBeenRendered('EUFBie3')) {
    $componentId = $_instance->getRenderedChildComponentId('EUFBie3');
    $componentTag = $_instance->getRenderedChildComponentTagName('EUFBie3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('EUFBie3');
} else {
    $response = \Livewire\Livewire::mount('content-switcher');
    $html = $response->html();
    $_instance->logRenderedChild('EUFBie3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </main>

    <?php echo \Livewire\Livewire::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Users\giftg\beaconfolder\BeaconChildrenCenter\resources\views/livewire/app.blade.php ENDPATH**/ ?>