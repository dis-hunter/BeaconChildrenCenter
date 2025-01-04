<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function registerGet()
    {
        if (Auth::check()) {
            return $this->authenticated();
        }
        $roles = Role::select('role')->get();
        $genders = Gender::select('gender')->get();

        return view('register', compact('roles', 'genders'));
    }

    function registerPost(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:staff',
            'phone' => 'required',
            'password' => [
                'required',
                Password::default()
            ],
            'confirmpassword' => 'required'
        ]);
        $data['fullname'] = [
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname
        ];
        $data['gender_id'] = Gender::where('gender', $request->gender)->value('id');
        $data['telephone'] = $request->phone;
        $data['staff_no'] = Str::uuid();
        $data['role_id'] = Role::where('role', $request->role)->value('id');
        $data['email'] = $request->email;
        if (strcmp($request->password, $request->confirmpassword) == 0) {
            $data['password'] = Hash::make($request->confirmpassword);
        }
        $staff = User::create($data);
        if (!$staff) {
            return redirect(route('register.post'))->with('error', 'Registration Failed. Try again later!')->withInput($request->except(['password','confirmpassword']));
        }
        return redirect(route('login'));
    }

    function loginGet()
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('login');
    }

    function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return $this->authenticated();
            
        }
        return redirect(route('login.post'))->with('error', 'Credentials are not valid!')->withInput($request->except('password'));
    }

    public function authenticated(){
        switch(Auth::user()->role_id){
            case 1:
                //return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('doctor.dashboard');
            case 3:
                //return redirect()->route('user.dashboard');
            case 4:
                //return redirect()->route('user.dashboard');
            default:
                //return redirect()->route('home');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }

    public function profileGet()
    {
        $user = Auth::user();
        $role = $user->role ? $user->role->role : 'Unknown';
        $gender = $user->gender ? $user->gender->gender : 'Unknown';
        return view('profile', compact('user', 'role', 'gender'));
    }

    public function profilePost(Request $request) {}

}
