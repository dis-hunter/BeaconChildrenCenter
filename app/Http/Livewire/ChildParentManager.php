<?php

namespace App\Http\Livewire;

use App\Models\children;
use App\Models\Parents;
use Livewire\Component;

class ChildParentManager extends Component
{
    public $query;
    public $parents;
    public $searchColumns=[
        'telephone'=>'Telephone',
        'email'=>'Email'
    ];
    public $selectedColumn;

    public function mount(){
        $this->query='';
        $this->parents=[];
        $this->searchColumns;
        $this->selectedColumn='';
    }
    public function updatedQuery(){
        $this->validate([
            'query' => 'required',
            'selectedColumn' => 'required',
        ]);
        //dd($this->selectedColumn);
        $this->parents = Parents::where($this->selectedColumn,'like','%'.$this->query.'%')->get();
    }

    public function render()
    {
        return view('livewire.child-parent-manager');
    }
}
