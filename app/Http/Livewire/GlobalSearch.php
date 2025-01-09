<?php

namespace App\Http\Livewire;

use App\Models\children;
use App\Models\Parents;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query='';
    public $results=[];

    public function updatedQuery(){
        if(strlen($this->query > 3)){
            $this->results = [
                'Guardians'=>Parents::search($this->query)->get(),
                'Patients'=>children::search($this->query)->get(),
            ];
        }else{
            $this->results=[];
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
