<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
    @livewireStyles
</head>
<body>
    <nav>
        <!-- Livewire actions for switching views -->
        <a href="#" wire:click.prevent="$emit('switchView', 'home')">Home</a>
<a href="#" wire:click.prevent="$emit('switchView', 'about')">About</a>

    </nav>

    <main>
        @livewire('content-switcher')
    </main>

    @livewireScripts
</body>
</html>
