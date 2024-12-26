<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;



use App\Http\Controllers\AuthController;
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

Route::post('/example', [ExampleController::class,'store'])->name('example.store');
Route::get('/example',[ExampleController::class,'fetch'])->name('example.fetch');

use App\Http\Controllers\DoctorsController; // Import the controller class
Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'show'])->name('doctor.show');
Route::get('/doctorDashboard', function () {
    return view('doctorDash');
});
Route::get('/create',  [DiagnosisController::class,
'create']
);

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
Route::get('login', [AuthController::class, 'loginGet']);
Route::get('register', [AuthController::class,'registerGet']);
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);
// routes/web.php

Route::post('/save-cns-data/{registrationNumber}', [DoctorsController::class, 'saveCnsData']);
use App\Http\Controllers\DevelopmentMilestonesController;

Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);



