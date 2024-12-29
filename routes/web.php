<?php

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

Route::get('/', function () {
    return view('example');
});

use App\Http\Controllers\DoctorsController; // Import the controller class
Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'show'])->name('doctor.show');
Route::get('/doctorDashboard', function () {
    return view('doctorDash');
});
Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);
// routes/web.php

Route::post('/save-cns-data/{registrationNumber}', [DoctorsController::class, 'saveCnsData']);
use App\Http\Controllers\DevelopmentMilestonesController;

Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);





use App\Http\Controllers\BehaviourAssesmentController;

// Fetch Behaviour Assessment for a child
Route::get('/get-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'getBehaviourAssessment']);

// Save or update Behaviour Assessment for a child
Route::post('/save-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'saveBehaviourAssessment']);






use App\Http\Controllers\FamilySocialHistoryController;

Route::get('/get-family-social-history/{visitId}', [FamilySocialHistoryController::class, 'getFamilySocialHistory']);
Route::post('/save-family-social-history/{visitId}', [FamilySocialHistoryController::class, 'saveFamilySocialHistory']);



use App\Http\Controllers\PerinatalHistoryController;

Route::get('/perinatal-history/{registrationNumber}', [PerinatalHistoryController::class, 'getPerinatalHistory']);
Route::post('/perinatal-history/{registrationNumber}', [PerinatalHistoryController::class, 'savePerinatalHistory']);



use App\Http\Controllers\PastMedicalHistoryController;

Route::get('/past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'getPastMedicalHistory']);
Route::post('/save-past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'savePastMedicalHistory']);




use App\Http\Controllers\GeneralExamController;

Route::get('/general-exam/{registrationNumber}', [GeneralExamController::class, 'getGeneralExam']);
Route::post('/general-exam/{registrationNumber}', [GeneralExamController::class, 'saveGeneralExam']);






