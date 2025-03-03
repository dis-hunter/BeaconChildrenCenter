<?php

namespace App\Livewire;

use App\Models\ChildParent;
use App\Models\children;
use App\Models\Gender;
use App\Models\Parents;
use App\Services\RegistrationNumberManager;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddChildModal extends Component
{
    public $parent;
    public $firstname, $middlename, $lastname, $dob, $birth_cert, $gender_id;
    public $genders, $message;
    public $registration_number;
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
            ]);

            $reg=new RegistrationNumberManager('children','registration_number');
            $this->registration_number=$reg->generateUniqueRegNumber();

            $fullname=[
                'first_name' => $this->firstname,
                'middle_name' => $this->middlename,
                'last_name' => $this->lastname,
            ];

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
        $this->dispatch('closeModal');
        $this->dispatch('childAdded', message: $this->message);

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
