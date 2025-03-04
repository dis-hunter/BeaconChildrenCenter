<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BehaviourAssesmentController;
use App\Http\Controllers\BookedController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DoctorDashboardController;

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CarePlanController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DevelopmentAssessmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\docSpecController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\TherapyController;
use App\Models\Invoice;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\FetchAppointments;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\FamilySocialHistoryController;
use App\Http\Controllers\PerinatalHistoryController;
use App\Http\Controllers\PastMedicalHistoryController;
use App\Http\Controllers\GeneralExamController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PatientDemographicsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\TriageController;
use App\Http\Controllers\IcdSearchController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\RevenueReportController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\ExpenseController;


//Doctor Form Routes
Route::get('/search-children', [AppointmentController::class, 'search']);

Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form'); // Display the form


Route::get('/staff/leave-request', [LeaveController::class, 'create'])->name('leave.request');
Route::get('/doc/requests', [LeaveController::class, 'docleave'])->name('doctor.leave');

Route::post('/leave/store', [LeaveController::class, 'store'])->name('leave.store');
Route::get('/leave-form-data', [LeaveController::class, 'getLeaveFormData']);
Route::get('/admin/leave-requests', [LeaveController::class, 'adminLeaveRequests'])->name('admin.leaveRequests');
Route::post('/admin/leave-requests/{id}/update', [LeaveController::class, 'updateLeaveStatus'])->name('admin.updateLeaveStatus');
Route::get('/leave/requests', [LeaveController::class, 'showUserLeaves'])->name('leave.requests');
Route::get('/reception/requests', [LeaveController::class, 'create2'])->name('leave2.request');


Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form');// Display the doctor form once the add doctor button is clicked

// Home Route
Route::get('/', function () {
    return view('home');
})->name('home');

// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/search', [SearchController::class, 'search'])->name('global.search');
    Route::get('/EditablegetDoctorNotes/{registrationNumber}', [VisitController::class, 'EditablegetDoctorNotes']);
    Route::post('/editDoctorNotes', [VisitController::class, 'EditdoctorNotes']);
    Route::get('/patientEncounterSummary/{registrationNumber}', [VisitController::class,'getEncounterSummary']);

    //NURSE
    Route::group(['middleware' => 'role:1'], function () {
        Route::controller(TriageController::class)->group(function () {
            Route::get('/untriaged-visits', 'getUntriagedVisits');
            Route::post('/start-triage/{visitId}', 'startTriage');
            Route::get('/post-triage-queue', 'getPostTriageQueue');
            Route::post('/triage', 'store');
            Route::get('/triage', 'create')->name('triage');
            Route::get('/triage-data/{child_id}', 'getTriageData');
        });
        Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);
        Route::view('/post-triage', 'postTriageQueue');
        Route::view('/triageDashboard', 'triageDash')->name('triage.dashboard');
    });

    //THERAPIST
    Route::group(['middleware' => 'role:5'], function () {
        Route::controller(TherapistController::class)->group(function () {
            Route::get('/therapist', 'index')->name('therapist.index');
            Route::post('/therapist/save', 'saveAssessment');
            Route::get('/therapist/progress', 'getProgress')->name('therapist.progress');
            Route::get('/therapist_dashboard', 'showDashboard')->name('therapistsDashboard');
            Route::get('/therapist/calendar', 'showTherapistDashboard')->name('therapist.calendar');
        });
        Route::controller(TherapyController::class)->group(function () {
            Route::get('/occupationaltherapy_dashboard/{registrationNumber}', 'getChildDetails');
            Route::get('/occupational_therapist/{registrationNumber}', 'OccupationTherapy');
            Route::get('/nutritionist/{registrationNumber}', 'NutritionalTherapy');
            Route::get('/speech_therapist/{registrationNumber}', 'SpeechTherapy');
            Route::get('/physiotherapist/{registrationNumber}', 'PhysioTherapy');
            Route::get('/psychotherapist/{registrationNumber}', 'PsychoTherapy');
            Route::post('/saveTherapyGoal', 'saveTherapyGoal')->name('savetherapy.store');
            Route::post('/completedVisit', 'completedVisit')->name('completedVisit.store');
            Route::post('/saveAssessment', 'saveAssessment')->name('saveAssessment.store');
            Route::post('/saveSession', 'saveSession')->name('saveSession.store');
            Route::post('/saveIndividualized', 'saveIndividualized')->name('saveIndividualized.store');
            Route::post('/saveFollowup', 'saveFollowup')->name('saveFollowup.store');
        });
        Route::view('/psychotherapy_dashboard', 'therapists.psychotherapyDashboard');
        Route::view('/physiotherapy_dashboard', 'therapists.physiotherapyDashboard');
        Route::view('/occupational_therapist', 'therapists.occupationalTherapist')->name('occupational_therapist');
        Route::view('/speech_therapist', 'therapists.speechTherapist')->name('speech_therapist');
        Route::view('/physical_therapist', 'therapists.physiotherapyTherapist')->name('physical_therapist');
        Route::view('/psychotherapy_therapist', 'therapists.psychotherapyTherapist')->name('psychotherapy_therapist');
        Route::view('/nutritionist', 'therapists.nutritionist')->name('nutritionist');
        Route::view('/speechtherapy_dashboard', 'therapists.speechtherapyDashboard');
        Route::view('/nutritionist_dashboard', 'therapists.nutritionistDashboard');
        Route::view('/physical_therapist', 'therapists.physiotherapyTherapist');
        Route::view('/nutritionist', 'therapists.nutritionist');
    });

    //DOCTOR
    Route::group(['middleware' => ['role:2', 'track_user_activity']], function () {
        Route::controller(DoctorsController::class)->group(function () {
            Route::get('/doctorDashboard', 'dashboard')->name('doctor.dashboard');
            Route::post('/doctorDashboard/profile/update', 'updateProfile')->name('doctor.profile.update');
            Route::get('/doctor/{registrationNumber}', 'getChildDetails')->name('doctor.show');
            Route::get('/get-triage-data/{registrationNumber}', 'getTriageData');
            Route::post('/save-cns-data/{registrationNumber}', 'saveCnsData');
            Route::get('/get-development-milestones/{registrationNumber}', 'getMilestones');
            Route::post('/save-development-milestones/{registrationNumber}', 'saveMilestones');
            Route::get('/diagnosis/{registrationNumber}', 'getDiagnosis');
            Route::post('/diagnosis/{registrationNumber}', 'saveDiagnosis');
            Route::get('/get-triage-data/{registrationNumber}', 'getTriageData');
        });

        Route::controller(GeneralExamController::class)->group(function () {
            Route::get('/general-exam/{registrationNumber}', 'getGeneralExam');
            Route::post('/general-exam/{registrationNumber}', 'saveGeneralExam');
        });
        Route::controller(TriageController::class)->group(function () {
            Route::get('/post-triage-queue', 'getPostTriageQueue');
        });
        Route::controller(BehaviourAssesmentController::class)->group(function () {
            Route::get('/get-behaviour-assessment/{registrationNumber}', 'getBehaviourAssessment');
            Route::post('/save-behaviour-assessment/{registrationNumber}', 'saveBehaviourAssessment');
        });
        Route::controller(FamilySocialHistoryController::class)->group(function () {
            Route::get('/get-family-social-history/{visitId}', 'getFamilySocialHistory');
            Route::post('/save-family-social-history/{visitId}', 'saveFamilySocialHistory');
        });
        Route::controller(PerinatalHistoryController::class)->group(function () {
            Route::get('/perinatal-history/{registrationNumber}', 'getPerinatalHistory');
            Route::post('/perinatal-history/{registrationNumber}', 'savePerinatalHistory');
        });
        Route::controller(PastMedicalHistoryController::class)->group(function () {
            Route::get('/past-medical-history/{registrationNumber}', 'getPastMedicalHistory');
            Route::post('/save-past-medical-history/{registrationNumber}', 'savePastMedicalHistory');
        });
        Route::controller(DevelopmentAssessmentController::class)->group(function () {
            Route::get('/development-assessment/{registrationNumber}', 'getDevelopmentAssessment');
            Route::post('/development-assessment/{registrationNumber}', 'saveDevelopmentAssessment');
        });
        Route::controller(InvestigationController::class)->group(function () {
            Route::post('/save-investigations/{registration_number}', 'saveInvestigations');
            Route::get('/recordResults/{registration_number}', 'recordResults')->name('recordResults');
            Route::post('/saveInvestigationResults/{registration_number}', 'saveInvestigationResults');
        });
        Route::controller(DiagnosisController::class)->group(function () {
            Route::post('/save-diagnosis/{registration_number}', 'saveDiagnosis');
        });
        Route::controller(CarePlanController::class)->group(function () {
            Route::post('/save-careplan/{registration_number}', 'saveCarePlan');
        });
        Route::controller(ReferralController::class)->group(function () {
            Route::get('/get-referral-data/{registration_number}', 'getReferralData');
            Route::get('/get-child-data/{registration_number}', 'getChildData');
            Route::post('/save-referral/{registration_number}', 'saveReferral');
        });
        Route::controller(PrescriptionController::class)->group(function () {
            Route::get('/get-prescriptions/{registrationNumber}', 'show');
            Route::post('/prescriptions/{registrationNumber}', 'store');
        });
        Route::controller(AuthController::class)->group(function () {
            Route::get('/get-user-specialization-and-doctor', 'getUserSpecializationAndDoctor')->name('get.user.specialization.doctor');
        });
        Route::controller(IcdSearchController::class)->group(function () {
            Route::post('/search', 'search');
        });
        Route::controller(DoctorController::class)->group(function () {
            Route::get('/doctorslist', 'index')->name('doctors');
            Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form');
        });
        Route::controller(VisitController::class)->group(function () {
            Route::get('/doctors/specialization-search', 'showSpecializations')->name('doctors.specializationSearch');
            Route::get('/specializations', 'getSpecializations');
            Route::get('/doctors', 'getDoctorsBySpecialization');
        });
        Route::controller(CalendarController::class)->group(function () {
            Route::get('/doctor/calendar', 'showDoctorDashboard')->name('doctor.calendar');
        });
    });

    //RECEPTIONIST
    Route::group(['middleware' => 'role:3'], function () {
        Route::get('/receiptionist_dashboard', function () {
            return view('Receiptionist\Receiptionist_dashboard');
        });
        Route::prefix('/dashboard')->group(function () {
            Route::get('/', [ReceptionController::class, 'dashboard'])->name('reception.dashboard');
            Route::get('/stats', [ReceptionController::class, 'getAppointmentStats'])->name('reception.dashboard.stats');
            Route::get('/appointments', [ReceptionController::class, 'getTodayAppointments'])->name('reception.dashboard.appointments');
            Route::get('/active-users', [ReceptionController::class, 'getActiveUsers'])->name('reception.dashboard.users');
        });
        Route::controller(ReceptionController::class)->group(function () {
            Route::post('/finish-appointment/{id}', 'finishAppointment')->name('finish');
            Route::get('/visithandle/{id?}', 'search')->name('search.visit');
            Route::get('/reception/calendar', 'calendar')->name('reception.calendar');
        });

        Route::controller(ChildrenController::class)->group(function () {
            Route::get('/patients/{id?}', 'patientGet')->name('patients.search');
            Route::get('/guardians', 'get');
            Route::post('/guardians', 'create');
            Route::get('/guardians/{id?}', 'childGet')->name('guardians.search');
        });

        Route::controller(VisitController::class)->group(function () {
            Route::post('/visits', 'store')->name('visits.store');
        });
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('/get-invoices', 'getInvoices')->name('invoices');
            Route::get('/invoices/{invoiceId}', 'getInvoiceContent')->name('invoice.content');
            Route::get('/invoice/{registrationNumber}', 'countVisitsForToday')->where('registrationNumber', '.*');
        });
    });

    //ADMIN
    Route::group(['middleware' => 'role:4'], function () {
        // Route::controller(PatientDemographicsController::class)->group(function () {
        //     Route::get('/patient-demographics', 'getDemographicsData')->name('demographics.data');
        // });
        // Route::controller(ExpensesController::class)->group(function () {
        //     Route::post('/AddExpense', 'saveExpenses');
        // });
        // Route::controller(DiagnosisController::class)->group(function () {
        //     Route::get('/disease-statistics', 'getDiseaseStatistics')->name('disease.statistics');
        // });
        // Route::controller(ReportController::class)->group(function () {
        //     Route::post('/generate-encounter-summary', 'generateEncounterSummary');
        //     Route::post('/generate-staff-performance', 'generateStaffPerformance');
        //     Route::post('/revenue-breakdown', 'revenueBreakdown')->name('revenue.breakdown');
        // });
        // Route::controller(RevenueReportController::class)->group(function () {
        //     Route::post('/generate-report', 'generate')->name('generate.report');
        //     Route::post('/generate-revenue-report', 'generateRevenueReport')->name('generate.revenue.report');
        //     Route::get('/analytics', 'showAnalytics')->name('analytics');
        // });
        // Route::controller(MetricsController::class)->group(function () {
        //     Route::get('/key-metrics', 'keyMetrics')->name('key.metrics');
        //     Route::get('/age-distribution', 'ageDistribution')->name('age.distribution');
        // });
    });
});


//This is temporary before admin auth is implemented
Route::controller(PatientDemographicsController::class)->group(function () {
    Route::get('/patient-demographics', 'getDemographicsData')->name('demographics.data');
});
Route::controller(ExpensesController::class)->group(function () {
    Route::post('/AddExpense', 'saveExpenses');
});
Route::controller(DiagnosisController::class)->group(function () {
    Route::get('/disease-statistics', 'getDiseaseStatistics')->name('disease.statistics');
});
Route::controller(ReportController::class)->group(function () {
    Route::post('/generate-encounter-summary', 'generateEncounterSummary');
    Route::post('/generate-staff-performance', 'generateStaffPerformance');
    Route::post('/revenue-breakdown', 'revenueBreakdown')->name('revenue.breakdown');
});
Route::controller(ExpenseController::class)->group(function () {
    Route::post('/expenses', 'getExpensesByDateRange');
});
Route::controller(RevenueReportController::class)->group(function () {
    Route::post('/generate-report', 'generate')->name('generate.report');
    Route::post('/generate-revenue-report', 'generateRevenueReport')->name('generate.revenue.report');
    Route::get('/analytics', 'showAnalytics')->name('analytics');
});
Route::controller(MetricsController::class)->group(function () {
    Route::get('/key-metrics', 'keyMetrics')->name('key.metrics');
    Route::get('/age-distribution', 'ageDistribution')->name('age.distribution');
});


// Authentication Routes
Route::controller(AuthController::class)->group(function () {

    Route::get('/appointments/booked-patients', 'bookedPatients')->name('appointments.booked');

});

// Parent Routes
Route::controller(ParentsController::class)->group(function () {
    Route::get('/parentform', 'create')->name('parents.create');
    Route::post('/storeparents', 'store')->name('parents.store');
    Route::post('/search-parent', 'search')->name('parents.search');
    Route::post('/parent/get-children', 'getChildren')->name('parent.get-children');
});

// Child Routes
Route::controller(ChildrenController::class)->group(function () {
    Route::get('/childform', 'create')->name('children.create');
    Route::post('/storechild', 'store')->name('children.store');
    Route::get('/children/search', 'search')->name('children.search');
    Route::get('/get-gender-distribution', 'getGenderDistribution');
});

// Doctor Routes
Route::controller(DoctorController::class)->group(function () {
    Route::get('/doctorslist', 'index')->name('doctors');
    Route::get('/doctors/specialization-search', 'showSpecializations')->name('doctors.specializationSearch');
    Route::get('/specializations', 'getSpecializations');
    Route::get('/doctors', 'getDoctorsBySpecialization');
});

Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'getChildDetails'])->name('doctor.show');

// Appointment Routes
Route::controller(AppointmentController::class)->group(function () {
    Route::post('/appointments', 'store')->name('appointments.store');
    Route::get('/get-doctors/{specializationId}', 'getDoctors');
    Route::get('/check-availability', 'checkAvailability');
    Route::get('/appointments/therapists', 'therapistAppointments')->name('appointments.therapists');
});

// Visit Routes
Route::controller(VisitController::class)->group(function () {
    Route::get('/visits', 'index')->name('visits.index');
    Route::view('/visits-page', 'visits')->name('visits.page');
    Route::get('/api/visit-data', 'getVisitData');
    Route::get('/get-visit-types', 'getVisitTypesData');
    Route::get('/visits/last7days', 'getVisitsLast7Days');
    Route::post('/saveDoctorNotes', 'doctorNotes')->name('doctorNotes.store');
    Route::get('/getDoctorNotes/{registrationNumber}', 'getDoctorNotes');


    Route::get('/visit-types-by-specialization/{specializationId}',
        [VisitController::class, 'getVisitTypesBySpecialization']
    )->name('visit.types.by.specialization');
});

// Invoice Routes
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/get-invoice-dates/{childId}', 'getInvoiceDates');
    Route::get('/get-invoice-details/{childId}', 'getInvoiceDetails');
    Route::get('/invoices', 'getInvoices')->name('invoices.index');
    Route::get('/invoices/{invoiceId}', 'getInvoiceContent')->name('invoice.content');
});

// Payment Routes
Route::controller(PaymentController::class)->group(function () {
    Route::get('/payment-methods', 'getPaymentMethods');
});

Route::get('/check-payment-status/{invoiceId}', function ($invoiceId) {
    $invoice = Invoice::find($invoiceId);
    return response()->json(['paid' => $invoice ? (bool)$invoice->invoice_status : false]);
});

// Reschedule Routes
Route::controller(RescheduleController::class)->group(function () {
    Route::delete('/cancel-appointment/{id}', 'cancelAppointment');
    Route::post('/reschedule-appointment/{appointmentId}', 'rescheduleAppointment')->name('appointments.rescheduleAppointment');
});

// Staff Routes
Route::controller(StaffController::class)->group(function () {
    Route::get('/staff-dropdown', 'index');
    Route::get('/staff/fetch', 'fetchStaff')->name('staff.fetch');
    Route::get('/staff/names', 'fetchStaff');
});

// Calendar Route
Route::get('/calendar', [CalendarController::class, 'create'])->name('calendar');

// Mpesa Route
Route::post('mpesa/stkpush', [MpesaController::class, 'stkPush'])->name('mpesa.stkpush');

// Diagnosis Route
Route::get('/create', [DiagnosisController::class, 'create']);

// Doctor Dashboard Routes
Route::controller(DoctorDashboardController::class)->group(function () {
    Route::get('/specialists', 'getSpecialists')->name('specialists.get');
    Route::get('/booked-patients', 'getBookedPatients')->name('booked.patients');
});

// Fetch Appointments Route
Route::get('/get-appointments', [FetchAppointments::class, 'getAppointments']);

Route::get('/debug-session', function () {
    dd(session()->all());
});

