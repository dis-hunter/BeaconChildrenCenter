<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChildSearchBar extends Component
{
    public $search = '';
    public $results = [];
    public $selectedItems = [];
    public $selectedChildId;
    public $minSearchLength = 2;
    public $debounce = 300;

    protected $queryString = ['search'];

    public function updatedSearch()
    {
        if (strlen($this->search) < $this->minSearchLength) {
            $this->results = [];
            return;
        }

        // Normalize search input
        $searchTerm = trim($this->search);
        
        // Use more precise LIKE matching with word boundaries
        $this->results = DB::table('children')
            ->select(
                'children.fullname as child_name',
                'children.id',
                'children.dob',
                'parents.id as parent_id',
                'parents.fullname as parent_name',
                'parents.email',
                'parents.telephone'
            )
            ->join('child_parent', 'children.id', '=', 'child_parent.child_id')
            ->join('parents', 'child_parent.parent_id', '=', 'parents.id')
            ->where(function($query) use ($searchTerm) {
                // Split search term into words for more precise matching
                $words = explode(' ', $searchTerm);
                foreach ($words as $word) {
                    $query->where('children.fullname', 'ILIKE', "%$word%");
                }
            })
            ->orderByRaw('CASE 
                WHEN children.fullname ILIKE ? THEN 1
                WHEN children.fullname ILIKE ? THEN 2
                WHEN children.fullname ILIKE ? THEN 3
                ELSE 4
            END', [
                $searchTerm,                    // Exact match
                $searchTerm . '%',              // Starts with
                '%' . $searchTerm . '%',        // Contains
            ])
            ->limit(10)
            ->get();

        if (!empty($this->selectedItems)) {
            $this->results = collect($this->results)->filter(function ($item) {
                return in_array($item->parent_id, $this->selectedItems);
            })->values();
        }
    }

    public function render()
    {
        return view('livewire.child-search-bar', [
            'selectedChildId' => $this->selectedChildId,
        ]);
    }
}