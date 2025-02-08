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
use App\Http\Controllers\DoctorsDisplayController;
use App\Http\Controllers\appointmentsController;
use App\Http\Controllers\TherapyController;
use App\Models\Invoice;




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

Route::get('/', function () {
    return view('home');
})->name('home');
//therapist routes


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
Route::get('/nutritionist/{registrationNumber}', [TherapyController::class, 'NutritionalTherapy']);
Route::get('/speech_therapist/{registrationNumber}', [TherapyController::class, 'SpeechTherapy']);
Route::get('/physiotherapist/{registrationNumber}', [TherapyController::class, 'PhysioTherapy']);
Route::get('/psychotherapist/{registrationNumber}', [TherapyController::class, 'PsychoTherapy']);






Route::get('/physical_therapist', function () {
    return view('therapists.physiotherapyTherapist');
});
// Route::get('/psychotherapy_therapist', function () {
//     return view('therapists.psychotherapyTherapist');
// });
// Route::get('/physiotherapy_therapist', function () {
//     return view('therapists.physiotherapyTherapist');
// });

Route::get('/nutritionist', function () {
    return view('therapists.nutritionist');
});
//therapist routes end above

Route::get('/receiptionist_dashboard', function () {
    return view('Receiptionist\Receiptionist_dashboard');
});
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

use App\Http\Controllers\BookedController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FetchAppointments;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\FinanceController;

//Route::get('/admin', function () {
   // return view('beaconAdmin');
//});
use App\Http\Controllers\IcdSearchController;


Route::get('/admin', function () {
    return view('beaconAdmin');
});

// General Routes
// General Routes
Route::view('/', 'home')->name('home');



Route::get('/api/visit-data', [VisitController::class, 'getVisitData']);
Route::get('/api/finance-data', [FinanceController::class, 'getFinanceData']);
Route::get('/get-gender-distribution', [ChildrenController::class, 'getGenderDistribution']);
Route::get('/get-visit-types', [VisitController::class, 'getVisitTypesData']);


Route::get('/visits/last7days', [VisitController::class, 'getVisitsLast7Days']);

Route::get('/get-appointments', [FetchAppointments::class, 'getAppointments']);

Route::delete('/cancel-appointment/{id}', [RescheduleController::class, 'cancelAppointment']);

Route::post('/reschedule-appointment/{appointmentId}', [RescheduleController::class, 'rescheduleAppointment'])->name('appointments.rescheduleAppointment');

// Authentication Routes
Route::get('login', [AuthController::class, 'loginGet'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('register', [AuthController::class, 'registerGet'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/calendar', [CalendarController::class, 'create'])->name('calendar');

Route::get('/doctor/calendar', [CalendarController::class, 'showDoctorDashboard'])->name('doctor.calendar');
Route::get('/therapist/calendar', [CalendarController::class, 'showTherapistDashboard'])->name('therapist.calendar');

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
Route::get('/doctors/specialization-search', [VisitController::class, 'showSpecializations'])->name('doctors.specializationSearch');
Route::get('/specializations', [VisitController::class, 'getSpecializations']);
Route::get('/doctors', [VisitController::class, 'getDoctorsBySpecialization']);

// Staff Routes
Route::get('/staff-dropdown', [StaffController::class, 'index']);
Route::get('/staff/fetch', [StaffController::class, 'fetchStaff'])->name('staff.fetch');
Route::get('/staff/names', [StaffController::class, 'fetchStaff']);

// Appointment Routes 
Route::get('/appointments', [AppointmentController::class, 'fetchStaff']);

// Visit Routes
Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::view('/visits-page', 'visits')->name('visits.page');
// Route::get('/payment-modes', [VisitController::class, 'getPaymentModes']);



// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {

    // Nurse Routes
    Route::group(['middleware' => 'role:1'], function () {
        Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
        Route::post('/start-triage/{visitId}', [TriageController::class, 'startTriage']);
        // Route::get('/get-untriaged-visits', [TriageController::class, 'getUntriagedVisits']); 
        Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
        Route::view('/post-triage', 'postTriageQueue');
        Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);
        Route::view('/triageDashboard', 'triageDash')->name('triage.dashboard');;
        Route::post('/triage', [TriageController::class, 'store']);
        Route::get('/triage', [TriageController::class, 'create'])->name('triage');
        Route::get('/triage-data/{child_id}', [TriageController::class, 'getTriageData']);
        Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
    });

    // Doctor Routes
    Route::group(['middleware' => ['role:2','track_user_activity']], function () {
        Route::get('/doctorDashboard', [DoctorsController::class, 'dashboard'])->name('doctor.dashboard');
        //Route::get('/doctorDashboard/profile', [DoctorsController::class, 'profile'])->name('doctor.profile');
        // Update Profile Route
        Route::post('/doctorDashboard/profile/update', [DoctorsController::class, 'updateProfile'])->name('doctor.profile.update');
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
        Route::get('/get-user-specialization-and-doctor', [AuthController::class, 'getUserSpecializationAndDoctor'])->name('get.user.specialization.doctor');
        Route::post('/search', [IcdSearchController::class, 'search']);
        Route::post('/save-diagnosis/{registrationNumber}', [DiagnosisController::class, 'saveDiagnosis']);
    });

    // Receptionist Routes
    Route::group(['middleware' => 'role:3'], function () {
        Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('reception.dashboard');
        Route::get('/patients/{id?}', [ChildrenController::class, 'patientGet'])->name('patients.search');
        Route::get('/guardians', [ChildrenController::class, 'get']);
        Route::post('/guardians', [ChildrenController::class, 'create']);
        Route::get('/guardians/{id?}', [ChildrenController::class, 'childGet'])->name('guardians.search');
        Route::post('/finish-appointment/{id}',[ReceptionController::class, 'finishAppointment'])->name('finish');
        Route::get('/visithandle/{id?}', [ReceptionController::class, 'search'])->name('search.visit');
        Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
        //Joy's Routes
        Route::get('/reception/calendar', [ReceptionController::class, 'calendar'])->name('reception.calendar');
        Route::get('/get-invoices', [InvoiceController::class, 'getInvoices'])->name('invoices');
        Route::get('/invoices/{invoiceId}', [InvoiceController::class, 'getInvoiceContent'])->name('invoice.content');
        Route::get('/invoice/{registrationNumber}', [InvoiceController::class, 'countVisitsForToday'])->where('registrationNumber', '.*');
    });

    // Admin Routes
    Route::group(['middleware' => 'role:4'], function () {
        // Add admin-specific routes here
    });

    Route::group(['middleware' => 'role:5'], function (){

        Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
        Route::post('/therapist/save', [TherapistController::class, 'saveTherapyNeeds'])->name('therapist.save');
        Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');
        Route::view('/occupational_therapist', 'therapists.occupationalTherapist')->name('therapists.occupationalTherapist');
        Route::view('/speech_therapist', 'therapists.speechTherapist');
        Route::view('/physical_therapist', 'therapists.physiotherapyTherapist');
        Route::view('/psychotherapy_therapist', 'therapists.psychotherapyTherapist');
        Route::view('/nutritionist', 'therapists.nutritionist');

    });
    
    Route::get('/admin', [ChildrenController::class, 'showChildren2']);
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    Route::get('/get-doctors/{specializationId}', [AppointmentController::class, 'getDoctors']);

    Route::get('/check-availability', [AppointmentController::class, 'checkAvailability']);

    
    Route::get('/get-invoice-dates/{childId}', [InvoiceController::class, 'getInvoiceDates']);
    Route::get('/get-invoice-details/{childId}', [InvoiceController::class, 'getInvoiceDetails']);
    Route::get('/invoices', [InvoiceController::class, 'getInvoices'])->name('invoices.index');

    Route::get('/payment-methods', function () {
        // Fetch payment data from database, assuming 'payments' table has payment_mode_id
        return \App\Models\Payment::select('payment_mode_id')->get();
    });
    
    

    

    Route::get('/payment-methods', [PaymentController::class, 'getPaymentMethods']);


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
Route::get('/nutritionist/{registrationNumber}', [TherapyController::class, 'NutritionalTherapy']);
Route::get('/speech_therapist/{registrationNumber}', [TherapyController::class, 'SpeechTherapy']);
Route::get('/physiotherapist/{registrationNumber}', [TherapyController::class, 'PhysioTherapy']);
Route::get('/psychotherapist/{registrationNumber}', [TherapyController::class, 'PsychoTherapy']);



Route::get('/key-metrics', [MetricsController::class, 'keyMetrics'])->name('key.metrics');
Route::get('/age-distribution', [MetricsController::class, 'ageDistribution'])->name('age.distribution');




Route::get('/physical_therapist', function () {
    return view('therapists.physiotherapyTherapist');
});
// Route::get('/psychotherapy_therapist', function () {
//     return view('therapists.psychotherapyTherapist');
// });
// Route::get('/physiotherapy_therapist', function () {
//     return view('therapists.physiotherapyTherapist');
// });

Route::get('/get-invoice-dates/{childId}', [InvoiceController::class, 'getInvoiceDates']);
Route::get('/get-invoice-details/{childId}', [InvoiceController::class, 'getInvoiceDetails']);

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
Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);




Route::get('/invoice/{registrationNumber}', [InvoiceController::class, 'countVisitsForToday']) ->where('registrationNumber', '.*');

Route::get('/specialists', [DoctorDashboardController::class, 'getSpecialists'])->name('specialists.get');



Route::get('/api/specialists', function (Illuminate\Http\Request $request) {
    $service = $request->query('service');

    // Fetch specialists based on the service
    $specialists = Specialist::where('service', $service)->get(['id', 'name']);

    return response()->json($specialists);
});
Route::get('/get-doctors/{specializationId}', [AppointmentController::class, 'getDoctors']);

Route::get('/check-availability', [AppointmentController::class, 'checkAvailability']);



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





Route::get('/invoice/{registrationNumber}', [InvoiceController::class, 'countVisitsForToday']);




//Temporary Admin route
Route::get('/admin1', function () {
    return view('beaconAdmin');
});



use App\Http\Controllers\PatientDemographicsController;

// Route to fetch data for the pie charts
Route::get('/patient-demographics', [PatientDemographicsController::class, 'getDemographicsData'])->name('demographics.data');


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
Route::get('/get-invoices', [InvoiceController::class, 'getInvoices'])->name('invoices');
Route::get('/invoices/{invoiceId}', [InvoiceController::class, 'getInvoiceContent'])->name('invoice.content');






use App\Http\Controllers\MpesaController;

Route::post('mpesa/stkpush', [MpesaController::class, 'stkPush'])->name('mpesa.stkpush');


Route::get('/check-payment-status/{invoiceId}', function ($invoiceId) {
    $invoice = Invoice::find($invoiceId);
    return response()->json(['paid' => $invoice ? (bool) $invoice->invoice_status : false]);
});



