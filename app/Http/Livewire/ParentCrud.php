<?php

namespace App\Http\Livewire;

use App\Models\Children;
use App\Models\Gender;
use App\Models\Parents;
use App\Models\Relationship;
use Livewire\Component;

class ParentCrud extends Component
{
    public ?Parents $parent = null; // Nullable parent model
    public $children = []; // Store children dynamically
    public $newChildName = ''; // For adding a new child
    public $childToEdit = null; // Store the child being edited

    public ?int $parentId = null; // Allow null value
    public $genders='';
    public $relationships='';

    public function mount($parentId = null)
    {
        $this->parentId = $parentId;

        $this->genders = Gender::select('id', 'gender')->get();
        $this->relationships = Relationship::select('id', 'relationship')->get();
        if ($parentId) {
            $this->loadParentAndChildren();
        }
    }

    public function loadParentAndChildren()
    {
        $this->parent = Parents::with('children')->find($this->parentId);

        if ($this->parent) {
            $this->children = $this->parent->children;
        } else {
            $this->children = [];
        }
    }

    public function addChild()
    {
        $this->validate([
            'newChildName' => 'required|string|max:255',
        ]);

        if ($this->parent) {
            $this->parent->children()->create(['name' => $this->newChildName]);

            $this->newChildName = '';
            $this->loadParentAndChildren();
        }
    }

    public function editChild($childId)
    {
        $this->childToEdit = Children::find($childId);

        if (!$this->childToEdit) {
            session()->flash('error', 'Child not found.');
        }
    }

    public function updateChild()
    {
        $this->validate([
            'childToEdit.name' => 'required|string|max:255',
        ]);

        if ($this->childToEdit) {
            $this->childToEdit->save();
            $this->loadParentAndChildren();
            $this->childToEdit = null;
        }
    }

    public function render()
    {
        return view('livewire.parent-crud', [
            'parent' => $this->parent,
            'children' => $this->children,
        ]);
    }
}
