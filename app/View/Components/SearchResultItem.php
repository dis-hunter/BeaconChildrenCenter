<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchResultItem extends Component
{
    public array $item;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $item)
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search-result-item');
    }
}
