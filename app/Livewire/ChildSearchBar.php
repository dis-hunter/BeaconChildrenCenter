<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class ChildSearchBar extends Component
{
    public $search = ""; // The search term entered by the user
    public $results = []; // The search results
    public $selectedItems = []; // Array to store selected item IDs
    public $selectedChildId = null; // To hold the selected child ID

    public function render()
    {
        if (strlen($this->search) < 1) {
            $this->results = []; // Clear results if search term is empty
        } else {
            $cacheKey = 'search_' . md5($this->search);
            $this->results = Cache::remember($cacheKey, 30, function () { // Cache for a shorter duration (30 seconds)
                return DB::table('children')
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
                    ->whereRaw("CONCAT(children.fullname->>'first_name', ' ', children.fullname->>'middle_name', ' ', children.fullname->>'last_name') ILIKE ?", ["%{$this->search}%"])
                    ->get();
            });
        }

        if (!empty($this->selectedItems)) {
            $this->results = $this->results->filter(function ($item) {
                return in_array($item->parent_id, $this->selectedItems);
            });
        }

        return view('livewire.child-search-bar', [
            'selectedChildId' => $this->selectedChildId,
        ]);
    }
}
