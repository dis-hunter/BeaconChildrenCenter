<?php

namespace App\Livewire;

use Livewire\Component;

class ContentSwitcher extends Component
{
    public $currentView = 'home';

    public function mount()
    {
        // Log initial state
        logger("Component mounted with view: " . $this->currentView);
    }

    protected $listeners = ['switchView'];

    public function switchView($view)
{
    logger("Switching view to: " . $view); // Log the switch
    $this->currentView = $view;
}


    public function render()
    {
        logger("Rendering with view: " . $this->currentView);
        return view('livewire.content-switcher');
    }
}
