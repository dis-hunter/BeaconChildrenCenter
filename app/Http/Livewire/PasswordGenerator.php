<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Enums\PasswordPart;

class PasswordGenerator extends Component
{
    public function render()
    {
        return view('livewire.password-generator');
    }

    public $password = '';
    public $confirmpassword='';



    public function generatePassword()
    {

        $characters = PasswordPart::Lowercase->value;
        $characters .= PasswordPart::Uppercase->value;
        $characters .= PasswordPart::Numbers->value;
        $characters .= PasswordPart::Symbols->value;

        $this->password = $this->generateRandomString(10, $characters);
        $this->confirmpassword=$this->password;
        $this->dispatchBrowserEvent('passwordGenerated',['password'=> $this->password]);
        //test
        // dd('Triggered');
    
    }


    private function generateRandomString($length, $characters)
    {
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
