<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorSpecialization;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Visits;
use App\Models\PaymentMode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; 

class VisitController extends Controller
{
    public function getVisitsLast7Days()
    {
        // Get the last 7 days from the current date
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Fetch visit data for the last 7 days
        $visits = Visits::where('visit_date', '>=', $sevenDaysAgo)
                       ->groupBy('visit_date')
                       ->selectRaw('visit_date, count(*) as visit_count')
                       ->orderBy('visit_date', 'asc')
                       ->get();

        return response()->json($visits);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'child_id' => 'required|exists:children,id',
            'visit_type' => 'required|integer',
            'visit_date' => 'required|date',
            'source_type' => 'required|string',
            'source_contact' => 'required|string|max:15',
            'staff_id' => 'required|integer|exists:staff,id',
            'doctor_id' => 'required|integer|exists:staff,id',
            'payment_mode_id' => 'required|integer|exists:payment_modes,id', // Validate payment mode
            'triage_pass' => 'required|boolean',
            'has_copay' => 'boolean',                          
        'copay_amount' => 'required_if:has_copay,true|numeric|nullable',
        ]);

        $appointment = Appointment::where('child_id',$validatedData['child_id'])
                                        ->whereDate('appointment_date',Carbon::today())
                                        ->first() ?? null;

        if($appointment){
            $appointment->update(['status' => 'ongoing']);
        }
                                        

        try {
            DB::table('visits')->insert([
                'child_id' => $validatedData['child_id'],
                'visit_type' => $validatedData['visit_type'],
                'visit_date' => $validatedData['visit_date'],
                'source_type' => $validatedData['source_type'],
                'source_contact' => $validatedData['source_contact'],
                'staff_id' => $validatedData['staff_id'],
                'doctor_id' => $validatedData['doctor_id'],
                'appointment_id' => $appointment->id ?? null,
                'payment_mode_id' => $validatedData['payment_mode_id'],
                'triage_pass' => $validatedData['triage_pass'],
                'has_copay' => $validatedData['has_copay'] ?? false,
            'copay_amount' => $validatedData['has_copay'] ? $validatedData['copay_amount'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Cache::forget('recent_visits_' . $validatedData['doctor_id']);
            return response()->json(['status' => 'success', 'data' => 'yes'], 201);
    
            return response()->json(['status' => 'success', 'message' => 'Appointment created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating appointment: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getVisitData(Request $request)
    {
        $period = $request->query('period', 'weekly');
        $startDate = match ($period) {
            'weekly' => Carbon::now()->subDays(7),
            'monthly' => Carbon::now()->subDays(30),
            'annually' => Carbon::now()->startOfYear(),
            default => Carbon::now()->subDays(7),
        };
    
        // Prepare a list of all months in the current year (for annual data)
        $allMonths = collect(range(1, 12))->map(fn($month) => Carbon::createFromDate(null, $month, 1)->format('Y-m'));
    
        // Adjust visits query based on the period
        if ($period === 'annually') {
            // Group by month (YYYY-MM) for annually
            $visits = DB::table('visits')
                ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"), DB::raw('COUNT(id) as total'))
                ->whereBetween('created_at', [$startDate, Carbon::now()])
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');
    
            // Merge all months and set missing months to 0
            $labels = $allMonths->toArray();
            $visitCounts = $allMonths->map(fn($month) => $visits->get($month, 0))->toArray();
        } else {
            // Group by day for weekly or monthly
            $visits = DB::table('visits')
                ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"), DB::raw('COUNT(id) as total'))
                ->whereBetween('created_at', [$startDate, Carbon::now()])
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');
    
            $labels = array_keys($visits->toArray());
            $visitCounts = array_values($visits->toArray());
        }
    
        return response()->json([
            'labels' => $labels,
            'visits' => $visitCounts,
        ]);
    }
    public function getVisitTypesData()
{
    // Join visits with visit_types and count occurrences of each visit_type
    $visitTypes = DB::table('visits')
        ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
        ->select('visit_type.visit_type', DB::raw('COUNT(visits.id) as visit_count'))
        ->groupBy('visit_type.visit_type')
        ->orderByDesc('visit_count')
        ->get();

    return response()->json($visitTypes);
}

    
    public function doctorNotes(Request $request)
    {
        $validatedData = $request->validate([
            'child_id' => 'required|exists:children,id',
            'notes' => 'nullable|string'
        ]);
    
        // Get authenticated user's ID
        $doctorId = auth()->id();
    
        try {
            $latestVisit = DB::table('visits')
                ->where('child_id', $validatedData['child_id'])
                ->latest()
                ->first();
    
            if (!$latestVisit) {
                return response()->json(['status' => 'error', 'message' => 'No visit found'], 404);
            }
            
            // Check if the requesting doctor is authorized
            if ($latestVisit->doctor_id != $doctorId) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Not authorized: Only the assigned doctor can update these notes'
                ], 403);
            }
    
            // Update notes and set completed to true
            DB::table('visits')
                ->where('id', $latestVisit->id)
                ->update([
                    'notes' => $validatedData['notes'],
                    'completed' => true,
                    'updated_at' => now()
                ]);
    
            return response()->json([
                'status' => 'success', 
                'message' => 'Notes updated successfully and visit marked as completed'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


// public function getPaymentModes()
// {
//     try {
//         $paymentModes = DB::table('payment_modes')->select('id', 'payment_mode')->get();

//         return response()->json(['status' => 'success', 'data' => $paymentModes]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
//     }
    
// }
// public function showForm()
// {
//     $paymentModes = PaymentMode::all(); // Assuming a PaymentMode model exists
//     return view('your-view', compact('paymentModes'));
// }


//new

public function getVisitTypesBySpecialization($specializationId)
{
    // Example: We'll use a switch statement to decide which visit_type IDs
    // belong to which specialization. Replace this logic with your own.
    
    switch ($specializationId) {
        case 1:  // Paediatrician
            $visitTypeIds = [1, 9, 11]; // e.g. "Paediatric Consultation", "General Consultation", "Review"
            break;
        case 2:  // Occupational Therapy
            $visitTypeIds = [ 2,4, 10,11]; // "Therapy Assessment", "Occupational Therapy", "Therapy Reports"
            break;
        case 3:  // Speech Therapy
            $visitTypeIds = [2,6, 10,11]; 
            break;
        case 4:  // Physiotherapy
            $visitTypeIds = [2,5, 10,11]; 
            break;
        case 5:  // Nutrition
            $visitTypeIds = [2, 8, 10, 11]; 
            break;
        case 6:  // ABA
            $visitTypeIds = [3, 17];
            break;
        case 8:  // Medical Officer
            $visitTypeIds = [2, 9, 11];
            break;
        case 9:  // Psychologist
            $visitTypeIds = [10, 7, 11];
            break;
        case 10: // Well Baby Clinic
            $visitTypeIds = [1, 2, 11];
            break;
        default: 
            // If we don't recognize the specialization, just return all or none
            $visitTypeIds = [];
            break;
    }

    // Now fetch those rows from the "visit_type" table
    // Adjust table/column names to match your schema
    $visitTypes = DB::table('visit_type')
        ->whereIn('id', $visitTypeIds)
        ->get();

    return response()->json([
        'status' => 'success',
        'data'   => $visitTypes
    ], 200);
}

public function getDoctorNotes($registrationNumber) {
    try {
        // Get child details
        $child = DB::table('children')
            ->where('registration_number', $registrationNumber)
            ->select('id', 'registration_number', 'fullname')
            ->first();

        if (!$child) {
            return response()->json([
                'status' => 'error',
                'message' => 'Child not found'
            ], 404);
        }

        // Decode the fullname JSON and construct the full name
        $fullname = json_decode($child->fullname);
        $firstName = $fullname->first_name ?? '';
        $middleName = $fullname->middle_name ?? '';
        $lastName = $fullname->last_name ?? '';
        $childName = trim("$firstName $middleName $lastName");

       


        // Get visits information
        $visits = DB::table('visits')
            ->join('staff', 'visits.doctor_id', '=', 'staff.id')
            ->where('visits.child_id', $child->id)
            ->orderBy('visits.visit_date', 'desc')
            ->select('visits.visit_date', 'visits.notes', 'staff.fullname as doctor_name')
            ->get();

        // Format the response
        $formattedResponse = [
            'status' => 'success',
            'data' => [
                'registration_number' => $child->registration_number,
                'child_name' => $childName,
                'visits' => $visits->map(function ($visit) {
                    // Decode doctor_name JSON string to an array
                    $doctor = json_decode(str_replace('Doctor: ', '', $visit->doctor_name), true);
                    
                    return [
                        'visit_date' => $visit->visit_date,
                        'notes' => $visit->notes,
                        'doctor_first_name' => $doctor['first_name'] ?? null, // Extract first name
                        'doctor_last_name' => $doctor['last_name'] ?? null,  // Extract last name
                    ];
                })
            ]
        ];
        

        return response()->json($formattedResponse);
    } catch (\Exception $e) {
        Log::error('Error in getDoctorNotes: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while retrieving the doctor notes'
        ], 500);
    }
}

public function showSpecializations()
{
    // Fetch distinct specializations
    $specializations = DoctorSpecialization::select('specialization_id', 'specialization')->distinct()->get();
    return view('Receiptionist/visit', compact('specializations'));
}

public function specializationSearch(Request $request)
{
    $validated = $request->validate([
        'specialization_id' => 'required|exists:doctor_specialization,specialization_id',
    ]);

    // Query for staff IDs with the selected specialization
    $staffIds = DoctorSpecialization::where('specialization_id', $validated['specialization_id'])
        ->pluck('staff_id');

    // Redirect to the staff controller with the list of staff IDs
    return redirect()->route('staff.fetch', ['staff_ids' => $staffIds->toArray()]);
}
public function getSpecializations()
{
    // Fetch distinct specializations
    $specializations = DoctorSpecialization::select('id', 'specialization')->distinct()->get();

    // Return the data as a JSON response
    return response()->json([
        'status' => 'success',
        'data' => $specializations,
    ]);
}

public function getDoctorsBySpecialization(Request $request)
{
    // Retrieve the specialization ID from the query parameters
    $specializationId = $request->query('specialization_id');

    // Fetch doctors with the matching specialization ID
    $doctors = User::where('specialization_id', $specializationId)->get();

    // Return the data as a JSON response
    return response()->json([
        'status' => 'success',
        'data' => $doctors,
    ]);
}




}
