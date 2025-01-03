<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use App\Models\Parents;
use App\Models\Relationship;
use Livewire\Component;

class EditParentModal extends Component
{
    public $parent;
    public $firstname, $middlename, $lastname, $dob, $telephone, $email,$national_id , $employer, $insurance, $referer, $relationship_id,$gender_id;
    public $genders, $relationships,$message;
    protected $listeners = ['parentUpdated' => 'handleParentUpdated'];

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
        $this->national_id= $parent->national_id;
        $this->employer= $parent->employer;
        $this->insurance= $parent->insurance;
        $this->referer= $parent->referer;
        $this->relationship_id = $parent->relationship_id;
        $this->gender_id=$parent->gender_id;
        $this->genders = Gender::all();
        $this->relationships = Relationship::all();
    }

    public function update()
    {
        try{
        $this->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'dob' => 'required|date',
            'telephone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'national_id'=>'required|min:8',
            'employer'=>'nullable|string|max:255',
            'insurance'=>'nullable|string|max:255',
            'referer'=>'nullable|string|max:255',
            'gender_id'=> 'required|exists:relationships,id',
            'relationship_id' => 'required|exists:relationships,id',
        ]);

        // Build the fullname JSON
        $fullname = json_encode([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
        ]);

        // Only update fields that have changed
        $this->parent->update(array_filter([
            'fullname' => $fullname !== $this->parent->fullname ? $fullname : null,
            'dob' => $this->dob !== $this->parent->dob ? $this->dob : null,
            'telephone' => $this->telephone !== $this->parent->telephone ? $this->telephone : null,
            'email' => $this->email !== $this->parent->email ? $this->email : null,
            'national_id'=> $this->national_id !== $this->parent->national_id ? $this->national_id : null,
            'employer'=> $this->employer !== $this->parent->employer ? $this->employer : null,
            'insurance'=> $this->insurance !== $this->parent->insurance ? $this->insurance : null,
            'referer'=> $this->referer !== $this->parent->referer ? $this->referer : null,
            'gender_id' => $this->gender_id !== $this->parent->gender_id ? $this->gender_id : null,
            'relationship_id' => $this->relationship_id !== $this->parent->relationship_id ? $this->relationship_id : null,
        ]));

        $this->message='Success.';
        $this->emit('parentUpdated',$this->message); // Optional: Emit event if needed for parent refresh
        $this->emit('closeModal');
    }
    catch(\Exception $e){
        $this->message='Error:'.$e->getMessage();
    }
    }

    public function handleParentUpdated($message){
        
        $this->message=session()->flash('message', $message);

    }



    
    public function render()
    {
        return view('livewire.edit-parent-modal');
    }
}
