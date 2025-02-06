<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\BehaviourAssesmentController;
use App\Http\Controllers\TriageController;
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
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ExpensesController;


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
//Route::get('/childform', [ChildrenController::class, 'create'])->name('children.create');
//Route::post('/storechild', [ChildrenController::class, 'store'])->name('children.store');
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



// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('profile', [AuthController::class, 'profileGet'])->name('profile');
    Route::post('profile', [AuthController::class, 'profilePost'])->name('profile.post');

    // Nurse Routes
    Route::group(['middleware' => 'role:1'], function () {
        Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
        Route::post('/start-triage/{visitId}', [TriageController::class, 'startTriage']);
        // Route::get('/get-untriaged-visits', [TriageController::class, 'getUntriagedVisits']); 
        Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
        Route::view('/post-triage', 'postTriageQueue');
        Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);
    });

    // Doctor Routes
    Route::group(['middleware' => 'role:2'], function () {
        Route::get('/doctorDashboard', [DoctorsController::class, 'dashboard'])->name('doctor.dashboard');
        Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'getChildDetails'])->name('doctor.show'); 
        Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
        Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);
        Route::post('/save-cns-data/{registrationNumber}', [DoctorsController::class, 'saveCnsData']);
        Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);
        Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);
        Route::get('/create', [DiagnosisController::class, 'create']);
        Route::get('/get-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'getBehaviourAssessment']);
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
        Route::get('/get-prescriptions/{registrationNumber}', [PrescriptionController::class, 'show']);
        Route::post('/prescriptions/{registrationNumber}', [PrescriptionController::class, 'store']); 
    });

    // Receptionist Routes
    Route::group(['middleware' => 'role:3'], function () {
        Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('reception.dashboard');
        Route::get('/patients/{id?}', [ChildrenController::class, 'patientGet'])->name('patients.search');
        Route::get('/guardians', [ChildrenController::class, 'get']);
        Route::post('/guardians', [ChildrenController::class, 'create']);
        Route::get('/guardians/{id?}', [ChildrenController::class, 'childGet'])->name('guardians.search');
        Route::get('/visithandle/{id?}', [ReceptionController::class,'search'])->name('search.visit');
    });

    // Admin Routes
    Route::group(['middleware' => 'role:4'], function () {
        // Add admin-specific routes here

    });
});


// Triage Routes (These should likely be within the Nurse's authenticated routes)
Route::view('/triageDashboard', 'triageDash')->name('triage.dashboard');; 
Route::post('/triage', [TriageController::class, 'store']);
Route::get('/triage', [TriageController::class, 'create'])->name('triage');
Route::get('/triage-data/{child_id}', [TriageController::class, 'getTriageData']);
Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);



use App\Http\Controllers\InvoiceController;

Route::get('/invoice/{registrationNumber}', [InvoiceController::class, 'countVisitsForToday']);




//Temporary Admin route
Route::get('/admin1', function () {
    return view('beaconAdmin');
});



use App\Http\Controllers\PatientDemographicsController;

// Route to fetch data for the pie charts
Route::get('/patient-demographics', [PatientDemographicsController::class, 'getDemographicsData'])->name('demographics.data');

Route::post('/AddExpense', [ExpensesController::class, 'saveExpenses']);

Route::get('/disease-statistics', [DiagnosisController::class, 'getDiseaseStatistics'])->name('disease.statistics');


use App\Http\Controllers\ReportController;
use App\Http\Controllers\RevenueReportController;

Route::post('/generate-encounter-summary', [ReportController::class, 'generateEncounterSummary']);
Route::post('/generate-staff-performance', [ReportController::class, 'generateStaffPerformance']);

Route::post('/revenue-breakdown', [ReportController::class, 'revenueBreakdown'])
    ->name('revenue.breakdown');



Route::post('/generate-report', [RevenueReportController::class, 'generate'])->name('generate.report');
Route::post('/generate-revenue-report', [RevenueReportController::class, 'generateRevenueReport'])->name('generate.revenue.report');
Route::get('/analytics', [RevenueReportController::class, 'showAnalytics'])->name('analytics');


use App\Http\Controllers\ExpenseController;
Route::post('/expenses', [ExpenseController::class, 'getExpensesByDateRange'])->name('expenses');
