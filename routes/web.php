<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DevelopmentMilestonesController; 
// Import the controller class
use App\Http\Controllers\TriageController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\StaffController;

use App\Http\Controllers\AuthController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\DoctorsDisplayController;

//Doctor Form Routes

Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form'); // Display the form

//Therapist Routes
Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
Route::post('/therapist/save', [TherapistController::class, 'saveTherapyNeeds'])->name('therapist.save');
Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');
Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form');// Display the doctor form once the add doctor button is clicked


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('reception.dashboard');
});

Route::get('/patients', [ChildrenController::class, 'get']);
Route::post('/patients', [ChildrenController::class, 'create']);
Route::get('/patients/search', [ChildrenController::class, 'searchGet']);

Route::get('/occupational_therapist', function () {
    return view('therapists.occupationalTherapist');
});
Route::get('/receiptionist_dashboard', function () {
    return view('Receiptionist\Receiptionist_dashboard');
});

Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'show'])->name('doctor.show');
Route::get('/doctorDashboard', function () {
    return view('doctorDash');
});


//this handles parent related activity
Route::get('/parentform', [ParentsController::class, 'create'])->name('parents.create');
// Handle form submission to store a new parent
Route::post('/storeparents', [ParentsController::class, 'store'])->name('parents.store');
//search for parent
Route::post('/search-parent', [ParentsController::class, 'search'])->name('parents.search');



//Handles child related operations
Route::get('/childform', [ChildrenController::class, 'create'])->name('children.create');
// Handle form submission to store a new child
Route::post('/storechild', [ChildrenController::class, 'store'])->name('children.store');
Route::get('/parents',  [ParentsController::class,
'create']
);

Route::get('login', [AuthController::class, 'loginGet'])->name('login');
Route::get('register', [AuthController::class,'registerGet'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('logout',[AuthController::class, 'logout'])->name('logout');

Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);

Route::post('/save-cns-data/{registrationNumber}', [DoctorsController::class, 'saveCnsData']);


Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);

Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);

//routes accessible when logged in only
Route::group(['middleware'=>'auth'], function(){
    //routes accessible based on role_id
    Route::get('profile',[AuthController::class, 'profileGet'])->name('profile');
    Route::post('profile',[AuthController::class, 'profilePost'])->name('profile.post');

    //Nurse
    Route::group(['middleware'=>'role:1'], function(){
        //Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);
        

    });

    //Doctor
    Route::group(['middleware'=>'role:2'], function(){
        Route::get('/create',  [DiagnosisController::class,
        'create']
        );
    });

    //Admin
    Route::group(['middleware'=>'role:3'], function(){
        
    });

});

