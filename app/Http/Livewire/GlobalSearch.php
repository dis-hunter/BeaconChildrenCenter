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
    public $history=[];
    public $isFocused=false;

    public function mount(){
        $this->history= session()->get('search_history',[]);
    }

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
            $this->updateHistory($this->results);
        }else{
            $this->results=[];
        }
    }

    public function updateHistory($results){
        $formattedResults= collect($results)->map(function ($records,$model){
            return $records->map(function($record) use ($model){
                return [
                    'model'=>$model,
                    'id'=>$record->id,
                    'name'=>(($record->fullname?->first_name ?? '').' '.($record->fullname?->middle_name ?? '').' '.($record->fullname?->last_name ?? '')),
                ];
            });
        });
        $this->history=$formattedResults->flatten(1)->take(10)->toArray();
        session()->put('search_history',$this->history);
    }

    public function clearHistory(){
        $this->history=[];
        session()->forget('search_history');
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
