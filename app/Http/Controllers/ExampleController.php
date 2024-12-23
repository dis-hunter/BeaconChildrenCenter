<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Example;
use App\Models\ExampleModel;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function fetch(Request $request){
        return view('example');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $example=new Example();
        $example->email = $request->input('email');
        $example->password = $request->input('password');
        $example->save();


        return redirect('/example')->with('success', 'User stored successfully!');
    }
}
