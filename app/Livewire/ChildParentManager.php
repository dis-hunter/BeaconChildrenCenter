<?php

namespace App\Livewire;

use App\Models\children;
use App\Models\Parents;
use Livewire\Component;

class ChildParentManager extends Component
{
    public $query;
    public $parents;

    public function mount(){
        $this->query='';
        $this->parents=[];
    }
    public function updatedQuery(){
        $this->validate([
            'query' => 'required|min:3',
        ]);
        
        $this->parents = Parents::search($this->query)->get();
    }

    public function render()
    {
        return view('livewire.child-parent-manager');
    }
}
