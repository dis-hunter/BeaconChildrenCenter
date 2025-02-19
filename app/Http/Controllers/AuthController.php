<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Gender;
use App\Models\Role;
use App\Models\User;
use App\Services\RegistrationNumberManager;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $specializations = DoctorSpecialization::select('specialization')->get();
        return view('auth/register', compact('roles', 'genders', 'specializations'));
    }

    function registerPost(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'specialization' => 'string',
            'email' => 'required|email|unique:staff',
            'telephone' => 'required|unique:staff',
            'password' => [
                'required',
                Password::default()
            ],
            'confirmpassword' => 'required'
        ]);

        $reg = new RegistrationNumberManager('staff', 'staff_no');
        $staff_no = $reg->generateUniqueRegNumber();
        
        $data['fullname'] = [
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'last_name' => $request->lastname
        ];
        $data['gender_id'] = Gender::where('gender', $request->gender)->value('id');
        $data['telephone'] = $request->telephone;
        $data['staff_no'] = $staff_no;
        $data['role_id'] = Role::where('role', $request->role)->value('id');
        $data['specialization_id'] = DoctorSpecialization::where('specialization', $request->specialization)->value('id');
        $data['email'] = $request->email;
        if (strcmp($request->password, $request->confirmpassword) == 0) {
            $data['password'] = Hash::make($request->confirmpassword);
            $staff = User::create($data);
        }else{
            return redirect(route('register.post'))->with('error', 'Passwords do not match!')->withInput($request->except(['password','confirmpassword']));
        }
        
        if (!$staff) {
            return redirect(route('register.post'))->with('error', 'Registration Failed. Try again later!')->withInput($request->except(['password', 'confirmpassword']));
        }
        return redirect(route('login'));
    }

    function loginGet()
    {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('auth/login');
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

    public function authenticated()
{
    

        switch (Auth::user()->role_id) {
            case 1:
                return redirect()->route('triage.dashboard');
                break; // Add break to stop execution after redirect

            case 2:
                return redirect()->route('doctor.dashboard');
                break;

            case 3:
                return redirect()->route('reception.dashboard');
                break;

            case 4:
                // return redirect()->route('user.dashboard');
                // break;

            case 5:
                return  redirect()->route('therapistsDashboard');
                break;
            default:
                // return redirect()->route('home');
                // break;
        }
    }

    public function therapist_redirect()
    {
        switch (Auth::user()->specialization_id) {
            case 2:
                return redirect()->route('occupational_therapist');
                break;

            case 3:
                // return redirect()->route('reception.dashboard');
                // break;

            case 4:
                // return redirect()->route('user.dashboard');
                // break;

            case 5:
                //return redirect()->route('occupational_therapist');
                // break;
            case 6:
                // return redirect()->route('therapist.dashboard');
                // break;
            case 8:
                // return redirect()->route('therapist.dashboard');
                // break;
            case 9:
                // return redirect()->route('therapist.dashboard');
                // break;
            case 10:
                // return redirect()->route('therapist.dashboard');
                // break;
            default:
                // return redirect()->route('home');
                // break;
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

    public function bookedPatients(Request $request)
    {
        // Get the authenticated user's ID
        $userId = auth()->id(); // This will get the authenticated user's ID
    
        // Get today's date
        $today = Carbon::today()->toDateString(); // 'YYYY-MM-DD'
    
        // SQL query to join the 'appointments' and 'children' tables and retrieve the required data
        $appointments = DB::select(
            'SELECT 
                children.fullname->>\'first_name\' AS first_name,
                children.fullname->>\'middle_name\' AS middle_name,
                children.fullname->>\'last_name\' AS last_name,
                appointments.start_time,
                appointments.end_time,
                parents.email AS parent_email,
                parents.telephone AS parent_telephone
            FROM appointments
            JOIN children ON appointments.child_id = children.id
            LEFT JOIN child_parent ON children.id = child_parent.child_id
            LEFT JOIN parents ON child_parent.parent_id = parents.id
            WHERE appointments.staff_id = ? 
            AND appointments.appointment_date = ?
            AND (appointments.status IS NULL OR appointments.status != \'rejected\')',
            [$userId, $today]
        );
    
        // Optionally, combine the names in PHP
        foreach ($appointments as &$appointment) {
            $appointment->child_name = "{$appointment->first_name} {$appointment->middle_name} {$appointment->last_name}";
        }
    
        // Return as JSON
        return response()->json($appointments);
    }
    
    public function getUserSpecializationAndDoctor(Request $request)
{
    // Ensure the user is authenticated
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Get the authenticated user's ID
    $userId = Auth::id();

    // Fetch the specialization ID and specialist name of the logged-in user
    $userDetails = DB::table('staff')
        ->join('doctor_specializations', 'staff.specialization_id', '=', 'doctor_specializations.id')
        ->join('doctors', 'doctor_specializations.id', '=', 'doctors.specialization_id')
        ->where('staff.user_id', $userId)
        ->select('doctor_specializations.id AS specialization_id', 'doctor_specializations.specialization', 
                 'doctors.id AS doctor_id', 
                 DB::raw("CONCAT(doctors.fullname->>'first_name', ' ', doctors.fullname->>'middle_name', ' ', doctors.fullname->>'last_name') AS doctor_name"))
        ->first();

    if (!$userDetails) {
        return response()->json(['error' => 'Specialization or Doctor not found for user'], 400);
    }

    // Return the specialization and doctor details
    return response()->json($userDetails);
}

    

}