<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\BehaviourAssesmentController;
use App\Http\Controllers\TriageController;
use App\Http\Controllers\StaffController;

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\FamilySocialHistoryController;
use App\Http\Controllers\PerinatalHistoryController;
use App\Http\Controllers\PastMedicalHistoryController;
use App\Http\Controllers\GeneralExamController;
use App\Http\Controllers\DevelopmentAssessmentController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\CarePlanController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AppointmentController;


// General Routes
Route::view('/', 'home')->name('home'); 

// Authentication Routes
Route::get('login', [AuthController::class, 'loginGet'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('register', [AuthController::class, 'registerGet'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Therapist Routes
Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
Route::post('/therapist/save', [TherapistController::class, 'saveTherapyNeeds'])->name('therapist.save');
Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');

// Therapist Views
Route::view('/occupational_therapist', 'therapists.occupationalTherapist');
Route::view('/speech_therapist', 'therapists.speechTherapist');
Route::view('/physical_therapist', 'therapists.physiotherapyTherapist');
Route::view('/psychotherapy_therapist', 'therapists.psychotherapyTherapist');
Route::view('/nutritionist', 'therapists.nutritionist');

// Parent Routes
Route::get('/parentform', [ParentsController::class, 'create'])->name('parents.create');
Route::post('/storeparents', [ParentsController::class, 'store'])->name('parents.store');
Route::post('/search-parent', [ParentsController::class, 'search'])->name('parents.search');
Route::post('/parent/get-children', [ParentsController::class, 'getChildren'])->name('parent.get-children'); 

// Child Routes
Route::get('/childform', [ChildrenController::class, 'create'])->name('children.create');
Route::post('/storechild', [ChildrenController::class, 'store'])->name('children.store');
Route::get('/children/search', [ChildrenController::class, 'search'])->name('children.search');
Route::get('/children/create', [ChildrenController::class, 'create'])->name('children.create');
Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store');

// Doctor Routes
Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form'); 
Route::get('/doctors/specialization-search', [DoctorController::class, 'showSpecializations'])->name('doctors.specializationSearch');
Route::get('/specializations', [DoctorController::class, 'getSpecializations']);
Route::get('/doctors', [DoctorController::class, 'getDoctorsBySpecialization']);

// Staff Routes
Route::get('/staff-dropdown', [StaffController::class, 'index']); 
Route::get('/staff/fetch', [StaffController::class, 'fetchStaff'])->name('staff.fetch');
Route::get('/staff/names', [StaffController::class, 'fetchStaff']); 

// Appointment Routes 
Route::get('/appointments', [AppointmentController::class, 'fetchStaff']); 

// Visit Routes
Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::view('/visits-page', 'visits')->name('visits.page'); 
Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
// Route::get('/payment-modes', [VisitController::class, 'getPaymentModes']);









// Fetch Behaviour Assessment for a child
Route::get('/get-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'getBehaviourAssessment']);

// Save or update Behaviour Assessment for a child
Route::post('/save-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'saveBehaviourAssessment']);








Route::get('/get-family-social-history/{visitId}', [FamilySocialHistoryController::class, 'getFamilySocialHistory']);
Route::post('/save-family-social-history/{visitId}', [FamilySocialHistoryController::class, 'saveFamilySocialHistory']);




Route::get('/perinatal-history/{registrationNumber}', [PerinatalHistoryController::class, 'getPerinatalHistory']);
Route::post('/perinatal-history/{registrationNumber}', [PerinatalHistoryController::class, 'savePerinatalHistory']);



Route::get('/past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'getPastMedicalHistory']);
Route::post('/save-past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'savePastMedicalHistory']);




Route::get('/general-exam/{registrationNumber}', [GeneralExamController::class, 'getGeneralExam']);
Route::post('/general-exam/{registrationNumber}', [GeneralExamController::class, 'saveGeneralExam']);



Route::get('/development-assessment/{registrationNumber}', [DevelopmentAssessmentController::class, 'getDevelopmentAssessment']);
Route::post('/development-assessment/{registrationNumber}', [DevelopmentAssessmentController::class, 'saveDevelopmentAssessment']);



Route::get('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'getDiagnosis']);
Route::post('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'saveDiagnosis']);


Route::post('/save-investigations/{registration_number}', [InvestigationController::class, 'saveInvestigations']);
Route::get('/recordResults/{registration_number}', [InvestigationController::class, 'recordResults'])->name('recordResults');
Route::post('/saveInvestigationResults/{registration_number}', [InvestigationController::class, 'saveInvestigationResults']);


Route::post('/save-careplan/{registration_number}', [CarePlanController::class, 'saveCarePlan']);



Route::get('/get-referral-data/{registration_number}', [ReferralController::class, 'getReferralData']);
Route::get('/get-child-data/{registration_number}', [ReferralController::class, 'getChildData']);
Route::post('/save-referral/{registration_number}', [ReferralController::class, 'saveReferral']);
Route::get('/getDoctorNotes/{registrationNumber}', [VisitController::class, 'getDoctorNotes']);


Route::post('/saveDoctorNotes', [VisitController::class, 'doctorNotes'])->name('doctorNotes.store');


Route::get('/visithandle', function () {
    return view('Receiptionist/visits');
});
Route::get('/staff-dropdown', [StaffController::class, 'index']);

Route::post('/parent/get-children', [ParentsController::class, 'getChildren'])->name('parent.get-children');
Route::get('/children/search', [ChildrenController::class, 'search'])->name('children.search');
Route::get('/children/create', [ChildrenController::class, 'create'])->name('children.create');
Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store');

Route::get('/doctors/specialization-search', [DoctorController::class, 'showSpecializations'])
    ->name('doctors.specializationSearch');
Route::get('/staff/fetch', [StaffController::class, 'fetchStaff'])->name('staff.fetch');
Route::get('/specializations', [DoctorController::class, 'getSpecializations']);
Route::get('/doctors', [DoctorController::class, 'getDoctorsBySpecialization']);
// Add this route to handle the POST request for fetching staff full names
Route::get('/staff/names', [StaffController::class, 'fetchStaff']);
Route::get('/appointments', [AppointmentController::class, 'fetchStaff']);



Route::post('/get-children', [ParentsController::class, 'getChildren'])->name('parent.get-children');


Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');

// Triage Routes (These should likely be within the Nurse's authenticated routes)
Route::view('/triageDashboard', 'triageDash')->name('triage.dashboard');; 
Route::post('/triage', [TriageController::class, 'store']);
Route::get('/triage', [TriageController::class, 'create'])->name('triage');
Route::get('/triage-data/{child_id}', [TriageController::class, 'getTriageData']);
Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
