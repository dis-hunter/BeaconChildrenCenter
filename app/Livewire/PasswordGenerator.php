<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PasswordPart;
use Faker\Factory;

class PasswordGenerator extends Component
{
    public $password = '';
    public $confirmpassword='';

    public function render()
    {
        return view('livewire.password-generator');
    }

    public function generatePassword()
    {

        $characters = PasswordPart::Lowercase->value;
        $characters .= PasswordPart::Uppercase->value;
        $characters .= PasswordPart::Numbers->value;
        $characters .= PasswordPart::Symbols->value;

        $this->password = $this->generateRandomString(10, $characters);
        //$this->password = $this->generateDistortedPassword();
        $this->confirmpassword=$this->password;
        
        $this->dispatch('passwordGenerated',['password'=> $this->password]);
    }


    private function generateRandomString($length, $characters)
    {
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    private function generateDistortedPassword()
    {
        $faker= Factory::create();
        $word = $faker->word();
        $rules = [
            'a'=>'4',
            'e'=>'3',
            'o'=>'0',
        ];
        $distorted_word='';
        foreach(str_split($word) as $char){
            $distorted_word .= $rules[strtolower($char)] ?? $char;
        }

        $complexity = rand(0,9) . rand(0,1) ? '!':'';
        $distorted_word .= $complexity;

        return $distorted_word;
    }

}