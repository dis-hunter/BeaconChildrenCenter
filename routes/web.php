<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\TriageController;
use App\Http\Controllers\DoctorsController;



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
// Route::get('/doctorDashboard', function () {
//     return view('doctorDash');
// });


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

Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);
Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);

Route::get('/triageDashboard', function () {
    return view('triageDash');
});
Route::post('/triage', [TriageController::class, 'store']);
Route::get('/triage', [TriageController::class, 'create'])->name('triage');
Route::get('/triage-data/{child_id}', [TriageController::class, 'getTriageData']);


use App\Http\Controllers\VisitsController;
use App\Models\Triage;

// Route for fetching all visits (for Blade view)
// Route::get('/visits', [VisitsController::class, 'index'])->name('visits.index');
// Route::get('/visits-page', function () {
//     return view('visits');
// })->name('visits.page');

Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);//->name('visits.untriaged');

// Route::get('/untriaged-visits', 'TriageController@getUntriagedVisits');
Route::post('/start-triage/{visitId}', 'TriageController@startTriage');
// In routes/web.php
Route::get('/get-untriaged-visits', 'TriageController@getUntriagedVisits');

Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
Route::get('/post-triage', function () {
    return view('postTriageQueue');
});
Route::get('/doctorDashboard', [TriageController::class, 'getPostTriageQueue']);
Route::get('/doctorDashboard', function () {
    return view('doctorDash');
});
Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);
