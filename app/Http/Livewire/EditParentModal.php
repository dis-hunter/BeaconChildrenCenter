<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use App\Models\Parents;
use App\Models\Relationship;
use Livewire\Component;

class EditParentModal extends Component
{
    public $parent;
    public $firstname, $middlename, $lastname, $dob, $telephone, $email, $relationship_id;
    public $genders, $relationships;

    public function mount($parent)
    {
        $this->parent = $parent;
        $p_fullname=json_decode($parent->fullname,true);
        $this->firstname = $p_fullname['firstname'];
        $this->middlename = $p_fullname['middlename'];
        $this->lastname = $p_fullname['lastname'];
        $this->dob = $parent->dob;
        $this->telephone = $parent->telephone;
        $this->email = $parent->email;
        $this->relationship_id = $parent->relationship_id;
        $this->genders = Gender::all();  // Or any other method to get gender data
        $this->relationships = Relationship::all();  // Or any other method to get relationship data
    }

    
    public function render()
    {
        return view('livewire.edit-parent-modal');
    }
}
