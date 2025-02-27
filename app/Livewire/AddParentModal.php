<?php

namespace App\Livewire;

use App\Models\ChildParent;
use App\Models\children;
use App\Models\Gender;
use App\Models\Parents;
use App\Models\Relationship;
use App\Services\RegistrationNumberManager;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddParentModal extends Component
{
    public $parent, $child;
    public $firstname, $middlename, $lastname, $dob, $telephone, $email,$national_id , $employer, $insurance, $referer, $relationship_id,$gender_id;
    public $genders, $relationships,$message;
    //protected $listeners = ['childUpdated' => 'handleChildUpdated'];

    public function mount(){
        $this->genders=Gender::all();
        $this->relationships=Relationship::all();
    }

    public function save(){
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

            $fullname=json_encode([
                'first_name' => $this->firstname,
                'middle_name' => $this->middlename,
                'last_name' => $this->lastname,
            ]);

            $validatedData=[
                'fullname'=>$fullname,
                'dob' => $this->dob,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'national_id'=> $this->national_id,
                'employer'=> $this->employer,
                'insurance'=> $this->insurance,
                'referer'=> $this->referer,
                'gender_id'=> $this->gender_id,
                'relationship_id' => $this->relationship_id,
            ];

            //dd($validatedData);

            DB::transaction(function () use ($validatedData,){
                $parent=Parents::create($validatedData);

                foreach($this->child as $child){
                    ChildParent::create([
                        'parent_id'=>$this->parent->id,
                        'child_id'=>$child->id,
                    ]);
                }

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
        return view('livewire.add-parent-modal');
    }
}
