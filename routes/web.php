<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DevelopmentMilestonesController;
use App\Http\Controllers\DoctorsController; 
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FetchAppointments;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\BookedController;



// Import the controller class

use App\Http\Controllers\AuthController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return view('home');
})->name('home');

Route::post('/example', [ExampleController::class,'store'])->name('example.store');
Route::get('/example',[ExampleController::class,'fetch'])->name('example.fetch');

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
Route::get('/create',  [DiagnosisController::class,
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
        
    });

    //Admin
    Route::group(['middleware'=>'role:3'], function(){
        
    });

});

Route::get('/sign_in', function () {
    return view('sign_in');
});
Route::get('/calendar', function () {
    return view('calendar');
});

Route::get('/register_child', function(){
    return view('register_child');
})->name('register_child');

// routes/web.php


// Show the calendar page
//Route::get('/calendar', [AppointmentController::class, 'create'])->name('calendar');
//Route::get('/calendar', [CalendarController::class, 'index'])->middleware('web');


Route::get('/calendar', [CalendarController::class, 'create'])->name('calendar');






Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');




Route::get('/doctors/{specializationId}', [DoctorController::class, 'getDoctorsBySpecialization']);

Route::get('/api/specialists', function (Illuminate\Http\Request $request) {
    $service = $request->query('service');

    // Fetch specialists based on the service
    $specialists = Specialist::where('service', $service)->get(['id', 'name']);

    return response()->json($specialists);
});
Route::get('/get-doctors/{specializationId}', [AppointmentController::class, 'getDoctors']);

Route::get('/check-availability', [AppointmentController::class, 'checkAvailability']);


Route::get('/get-appointments', [FetchAppointments::class, 'getAppointments']);

Route::delete('/cancel-appointment/{id}', [RescheduleController::class, 'cancelAppointment']);
//Route::post('/reschedule-appointment/{id}', [RescheduleController::class, 'rescheduleAppointment']);

Route::post('/reschedule-appointment/{appointmentId}', [RescheduleController::class, 'rescheduleAppointment'])->name('appointments.rescheduleAppointment');

//Route::post('/api/reschedule', [RescheduleController::class, 'reschedule']);

Route::get('/booked-patients', [BookedController::class, 'getBookedPatients'])->name('booked.patients');








