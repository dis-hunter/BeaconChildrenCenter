<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerGet()
    {
        $roles = Role::select('role')->get();
        $genders = Gender::select('gender')->get();

        return view('register', compact('roles', 'genders'));
    }

    function registerPost(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:staff',
            'password' => 'required',
            'confirmpassword' => 'required'
        ]);
        $fullname = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname
        ];
        $data['gender'] = $request->gender;
        
        $data['role'] = $request->role;
        $data['email'] = $request->email;
        if (strcmp($request->password, $request->confirmpassword) === true) {
            $data['password'] = Hash::make($request->confirmpassword);
        }
        $staff = User::create($data);
        if(!$staff){
            return redirect(route('register'))->with('error','Registration Failed. Try again later!');
        }
        return redirect(route('register'))->with('success','Registration Successful');
    }

    function loginGet()
    {
        return view('login');
    }

    function loginPost(Request $request) {}
}
