<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChildSearchBar extends Component
{
    public $search = ""; // The search term entered by the user
    public $results = []; // The search results
    public $selectedItems = []; // Array to store selected item IDs
    public $selectedChildId = null; // To hold the selected child ID


    public function render()
{
    if (strlen($this->search) >= 1) {
        $this->results = DB::table('children')
            ->select(
                'children.fullname',
                'children.id',
                'children.dob',
                'parents.id as parent_id',
                // Concatenate parent's full name
                'parents.fullname as parent_fullname',
                'parents.email',
                'parents.telephone'
            )
            ->join('child_parent', 'children.id', '=', 'child_parent.child_id')
            ->join('parents', 'child_parent.parent_id', '=', 'parents.id')
            ->where('children.fullname', 'like', "%{$this->search}%")
            ->orWhere('parents.fullname', 'like', "%{$this->search}%")
            ->get();
    }

    if (!empty($this->selectedItems)) {
        $this->results = $this->results->filter(function ($item) {
            return in_array($item->parent_id, $this->selectedItems);
        });
    }

    return view('livewire.child-search-bar', [
        'selectedChildId' => $this->selectedChildId, // Pass selected child ID to the view
    ]);
}

};
