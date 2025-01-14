<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\BehaviourAssesmentController;
use App\Http\Controllers\DevelopmentMilestonesController;

use App\Http\Controllers\VisitController; 

// Import the controller class
use App\Http\Controllers\TriageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TherapyController;


use App\Http\Controllers\AuthController;
use App\Models\Role;
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
use App\Http\Controllers\CalendarController;
use Custom\Namespace\FetchAppointments;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\VisitsController;




// General Routes
Route::view('/', 'home')->name('home'); 

// Authentication Routes
Route::get('login', [AuthController::class, 'loginGet'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('register', [AuthController::class, 'registerGet'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Therapist Routes
Route::get('/reception/appointments', [AppointmentController::class, 'index'])->name('appointments.index');






//Doctor Form Routes

Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form'); // Display the form

//Therapist Routes
Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
Route::post('/therapist/save', [TherapistController::class, 'saveAssessment']);
Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');

// Therapist Views
Route::view('/occupational_therapist', 'therapists.occupationalTherapist');
Route::view('/speech_therapist', 'therapists.speechTherapist');
Route::view('/physical_therapist', 'therapists.physiotherapyTherapist');
Route::view('/psychotherapy_therapist', 'therapists.psychotherapyTherapist');
Route::view('/nutritionist', 'therapists.nutritionist');

// Parent Routes
Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form'); // Display the doctor form once the add doctor button is clicked


use App\Http\Controllers\DoctorsDisplayController;
use App\Http\Controllers\appointmentsController;



//Doctor Form Routes

Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form'); // Display the form

//Therapist Routes

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

Route::get('/', function () {return view('home');})->name('home');


Route::get('/patients', [ChildrenController::class, 'get']);
Route::post('/patients', [ChildrenController::class, 'create']);
Route::get('/patients/search', [ChildrenController::class, 'searchGet']);
Route::get('/patients/search/{id?}', [ChildrenController::class, 'childGet']);

    

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/register_child', function(){
    return view('register_child');
})->name('register_child');


Route::get('/calendar', [CalendarController::class, 'create'])->name('calendar');

Route::get('/doctor/calendar', [CalendarController::class, 'showDoctorDashboard'])->name('doctor.calendar');
Route::get('/therapist/calendar', [CalendarController::class, 'showTherapistDashboard'])->name('therapist.calendar');



Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'getChildDetails'])->name('doctor.show');
Route::get('/doctorDashboard', function () {
    return view('doctorDash');
});


//this handles parent related activity
Route::get('/parentform', [ParentsController::class, 'create'])->name('parents.create');
// Handle form submission to store a new parent
Route::post('/storeparents', [ParentsController::class, 'store'])->name('parents.store');
//search for parent
Route::post('/search-parent', [ParentsController::class, 'search'])->name('parents.search');

Route::get('/create',  [DiagnosisController::class,
'create']
);

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
    
    Route::get('profile',[AuthController::class, 'profileGet'])->name('profile');
    Route::post('profile',[AuthController::class, 'profilePost'])->name('profile.post');

    //routes accessible based on role_id
    //Nurse
    Route::group(['middleware'=>'role:1'], function(){
        // e.g. Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);
        

    });

    //Doctor
    Route::group(['middleware'=>'role:2'], function(){
        
    });

    //Admin
    Route::group(['middleware'=>'role:3'], function(){
        
    });
    
    Route::group(['middleware'=>'role:5'], function(){
        Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
Route::post('/therapist/save', [TherapistController::class, 'saveAssessment']);
Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');
    });
    Route::get('/therapist_dashboard', [TherapistController::class, 'showDashboard']);
Route::get('/psychotherapy_dashboard', function () {
    return view('therapists.psychotherapyDashboard');
});
Route::get('/physiotherapy_dashboard', function () {
    return view('therapists.physiotherapyDashboard');
});
Route::get('/physiotherapy_dashboard', function () {
    return view('therapists.physiotherapyDashboard');
});

Route::get('/occupationaltherapy_dashboard/{registrationNumber}', [TherapyController::class, 'getChildDetails']);


Route::get('/speechtherapy_dashboard', function () {
    return view('therapists.speechtherapyDashboard');
});
Route::get('/nutritionist_dashboard', function () {
    return view('therapists.nutritionistDashboard');
});
Route::get('/occupational_therapist/{registrationNumber}', [TherapyController::class, 'OccupationTherapy']);
Route::get('/nutritionist_therapist/{registrationNumber}', [TherapyController::class, 'NutritionalTherapy']);
Route::get('/speech_therapist/{registrationNumber}', [TherapyController::class, 'SpeechTherapy']);
Route::get('/physiotherapist/{registrationNumber}', [TherapyController::class, 'PhysioTherapy']);






Route::get('/physical_therapist', function () {
    return view('therapists.physiotherapyTherapist');
});
Route::get('/psychotherapy_therapist', function () {
    return view('therapists.psychotherapyTherapist');
});
Route::get('/physiotherapy_therapist', function () {
    return view('therapists.physiotherapyTherapist');
});

Route::get('/nutritionist', function () {
    return view('therapists.nutritionist');
});
//therapist routes end above

Route::get('/receiptionist_dashboard', function () {
    return view('Receiptionist\Receiptionist_dashboard');
});


Route::get('/layout',function(){
    return view('reception\layout');
});

Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'show'])->name('doctor.show');
Route::get('/doctorDashboard', function () {
    return view('doctorDash');
});


//this handles parent related activity
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
        Route::get('/reception/calendar', [ReceptionController::class, 'calendar'])->name('reception.calendar');

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
    //Receptionist
    Route::group(['middleware' => 'role:3'], function () {});

    //Admin
    Route::group(['middleware' => 'role:4'], function () {});




// Route for fetching all visits (for Blade view)
// Route::get('/visits', [VisitsController::class, 'index'])->name('visits.index');
// Route::get('/visits-page', function () {
//     return view('visits');
// })->name('visits.page');

Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);//->name('visits.untriaged');
Route::get('/therapist_dashboard', [TherapistController::class, 'showDashboard'])->name('occupational_therapist');

Route::post('/saveTherapyGoal', [TherapyController::class, 'saveTherapyGoal'])->name('savetherapy.store');
Route::post('/completedVisit', [TherapyController::class, 'completedVisit'])->name('completedVisit.store');


Route::post('/saveAssessment', [TherapyController::class, 'saveAssessment'])->name('saveAssessment.store');
Route::post('/saveSession', [TherapyController::class, 'saveSession'])->name('saveSession.store');
Route::post('/saveIndividualized', [TherapyController::class, 'saveIndividualized'])->name('saveIndividualized.store');
Route::post('/saveFollowup', [TherapyController::class, 'saveFollowup'])->name('saveFollowup.store');


});





// Fetch Behaviour Assessment for a child
Route::get('/get-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'getBehaviourAssessment']);

// Save or update Behaviour Assessment for a child
Route::post('/save-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'saveBehaviourAssessment']);







Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
Route::post('/start-triage/{visitId}', [TriageController::class, 'startTriage']);
// // In routes/web.php
Route::get('/get-untriaged-visits', [TriageController::class,' getUntriagedVisits']);

Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
Route::get('/post-triage', function () {
    return view('postTriageQueue');
});
Route::get('/doctorDashboard', [TriageController::class, 'getPostTriageQueue']);

Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);

Route::get('/doctorDashboard',[DoctorsController::class, 'dashboard'])->name('doctor.dashboard');

Route::get('/past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'getPastMedicalHistory']);
Route::post('/save-past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'savePastMedicalHistory']);





Route::get('/general-exam/{registrationNumber}', [GeneralExamController::class, 'getGeneralExam']);
Route::post('/general-exam/{registrationNumber}', [GeneralExamController::class, 'saveGeneralExam']);




Route::get('/development-assessment/{registrationNumber}', [DevelopmentAssessmentController::class, 'getDevelopmentAssessment']);
Route::post('/development-assessment/{registrationNumber}', [DevelopmentAssessmentController::class, 'saveDevelopmentAssessment']);



Route::get('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'getDiagnosis']);
Route::post('/save-diagnosis/{registrationNumber}', [DiagnosisController::class, 'saveDiagnosis']);



Route::get('/sign_in', function () {
    return view('sign_in');
});

Route::get('/appointments/booked-patients', [AuthController::class, 'bookedPatients'])->name('appointments.booked');


Route::get('/get-user-specialization-and-doctor', [AuthController::class, 'getUserSpecializationAndDoctor'])->name('get.user.specialization.doctor');



// routes/web.php


// Show the calendar page
//Route::get('/calendar', [AppointmentController::class, 'create'])->name('calendar');
//Route::get('/calendar', [CalendarController::class, 'index'])->middleware('web');






Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');




Route::get('/doctors/{specializationId}', [docSpecController::class, 'getDoctorsBySpecialization']);



//Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dash');

Route::get('/specialists', [DoctorDashboardController::class, 'getSpecialists'])->name('specialists.get');



Route::get('/api/specialists', function (Illuminate\Http\Request $request) {
    $service = $request->query('service');

    // Fetch specialists based on the service
    $specialists = Specialist::where('service', $service)->get(['id', 'name']);

    return response()->json($specialists);
});
Route::get('/get-doctors/{specializationId}', [AppointmentController::class, 'getDoctors']);

Route::get('/check-availability', [AppointmentController::class, 'checkAvailability']);


Route::get('/get-appointments', [App\Http\Controllers\FetchAppointments::class, 'getAppointments']);

Route::delete('/cancel-appointment/{id}', [RescheduleController::class, 'cancelAppointment']);
//Route::post('/reschedule-appointment/{id}', [RescheduleController::class, 'rescheduleAppointment']);

Route::post('/reschedule-appointment/{appointmentId}', [RescheduleController::class, 'rescheduleAppointment'])->name('appointments.rescheduleAppointment');

//Route::post('/api/reschedule', [RescheduleController::class, 'reschedule']);

Route::get('/booked-patients', [BookedController::class, 'getBookedPatients'])->name('booked.patients');

Route::get('/calendar-content', [CalendarController::class, 'create'])->name('calendar.content');

Route::get('/appointments/therapists', [AppointmentController::class, 'therapistAppointments'])->name('appointments.therapists');
Route::get('/get-referral-data/{registration_number}', [ReferralController::class, 'getReferralData']);
Route::get('/get-child-data/{registration_number}', [ReferralController::class, 'getChildData']);
Route::post('/save-referral/{registration_number}', [ReferralController::class, 'saveReferral']);
Route::get('/getDoctorNotes/{registrationNumber}', [VisitController::class, 'getDoctorNotes']);


Route::post('/saveDoctorNotes', [VisitController::class, 'doctorNotes'])->name('doctorNotes.store');


Route::get('/visithandle', function () {
    return view('Receiptionist/visits');
});
Route::get('/staff-dropdown', [StaffController::class, 'index']);

Route::get('/get-prescriptions/{registrationNumber}', [PrescriptionController::class, 'show']);
Route::post('/prescriptions/{registrationNumber}', [PrescriptionController::class, 'store']);


use App\Http\Controllers\IcdSearchController;

Route::post('/search', [IcdSearchController::class, 'search']);










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

Route::get('/therapists.therapist_dashboard', [TherapistController::class, 'showDashboard']);

Route::post('/saveTherapyGoal', [TherapyController::class, 'saveTherapyGoal'])->name('savetherapy.store');
Route::post('/completedVisit', [TherapyController::class, 'completedVisit'])->name('completedVisit.store');


Route::post('/saveAssessment', [TherapyController::class, 'saveAssessment'])->name('saveAssessment.store');
Route::post('/saveSession', [TherapyController::class, 'saveSession'])->name('saveSession.store');
Route::post('/saveIndividualized', [TherapyController::class, 'saveIndividualized'])->name('saveIndividualized.store');
Route::post('/saveFollowup', [TherapyController::class, 'saveFollowup'])->name('saveFollowup.store');

Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);