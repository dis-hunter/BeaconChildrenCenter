<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Enums\PasswordPart;

class PasswordGenerate extends Component
{
    public $password = '';
    public $confirmpassword='';


    public function generatePassword()
    {

        $characters = PasswordPart::Lowercase->value;
        $characters .= $this->uppercase ? PasswordPart::Uppercase->value : '';
        $characters .= $this->numbers ? PasswordPart::Numbers->value : '';
        $characters .= $this->symbols ? PasswordPart::Symbols->value : '';

        $this->password = '';

        $this->password = $this->generateRandomString(10, $characters);
        $this->confirmpassword=$this->password;
    
    }


    private function generateRandomString($length, $characters)
    {
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function render()
    {
        return view('register');
    }
}