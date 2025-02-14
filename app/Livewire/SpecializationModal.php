<?php

namespace App\Livewire;

use App\Models\DoctorSpecialization;
use App\Models\Role;
use Livewire\Component;

class SpecializationModal extends Component
{
    public $roles='';
    public $role;
    public $showModal = false;
    public $specializations='';
    public $specialization;

    public function mount(){
        $this->roles=Role::select('role')->get();
    }

    public function updatedRole($value){
        if($value === 'Doctor'){
            $this->showModal=true;
            $this->specializations=DoctorSpecialization::select('specialization')->get();
        }else{
            $this->showModal=false;
            $this->specialization = null;
        }
    }

    public function closeModal(){
        $this->showModal=false;
    }

    public function save(){
        $this->showModal=false;
        $this->dispatch('modelSaved',role: $this->role,specialization: $this->specialization);
    }

    public function render()
    {
        return view('livewire.specialization-modal');
    }
}
