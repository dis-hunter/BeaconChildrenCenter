<?php

namespace App\Http\Livewire;

use App\Models\children;
use App\Models\Parents;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query='';
    public $results=[];

    protected $updatesQueryString = [
        'query'=> [
            'except'=>'',
            'debounce'=>'500',
        ],
    ];

    public function updatedQuery(){
        if(strlen($this->query > 3)){
            $this->results = Cache::remember("search:{$this->query}",60,function (){
                return [
                    'Guardians'=>Parents::search($this->query)->get(),
                    'Patients'=>children::search($this->query)->get(),
                ];
            });
        }else{
            $this->results=[];
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
