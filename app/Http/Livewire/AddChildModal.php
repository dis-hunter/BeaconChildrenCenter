<?php

namespace App\Http\Livewire;

use App\Models\ChildParent;
use App\Models\children;
use App\Models\Gender;
use App\Models\Parents;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddChildModal extends Component
{
    public $parent;
    public $firstname, $middlename, $lastname, $dob, $birth_cert, $gender_id, $registration_number;
    public $genders, $message;
    //protected $listeners = ['childUpdated' => 'handleChildUpdated'];

    public function mount($parent){
        $this->parent=$parent;
        $this->genders=Gender::all();
    }

    public function save(){
        try{
            $this->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'dob' => 'required|date',
                'birth_cert' => 'required|string|max:15',
                'gender_id' => 'required',
                'registration_number'=>'required|string',
            ]);

            $fullname=json_encode([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
            ]);
            $validatedData=[
                'fullname'=>$fullname,
                'dob'=>$this->dob,
                'birth_cert'=>$this->birth_cert,
                'gender_id'=>$this->gender_id,
                'registration_number'=>$this->registration_number
            ];

            //dd($validatedData);

        DB::transaction(function () use ($validatedData,){
            $child=children::create($validatedData);

            ChildParent::create([
                'parent_id'=>$this->parent->id,
                'child_id'=>$child->id,
            ]);

        });

        $this->message = 'Success.';
        $this->emit('closeModal');
        $this->emit('childAdded', $this->message);
        
    }
    catch(\Exception $e){
        $this->message = 'Error:' . $e->getMessage();
    }
    }
    
    public function render()
    {
        return view('livewire.add-child-modal');
    }
}
