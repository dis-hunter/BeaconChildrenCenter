<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Triage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Parents;

class TriageController extends Controller
{

    /**
     * Store triage examination data into the database.
     */

    public function create()
    {
        // Sample default triage data
        $triageData = [
            'temperature' => 37.0,
            'respiratory_rate' => 20,
            'pulse_rate' => 80,
            'blood_pressure' => '120/80',
            'weight' => 70.0,
            'height' => 1.75,
            'muac' => 11.5,
            'head_circumference' => 0.45,
        ];

        return view('triage', compact('triageData'));
        //  return response()->json(['triageData' => $triageData]);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'visit_id' => 'required|integer|exists:visits,id',
        'child_id' => 'required|integer|exists:children,id',
        'temperature' => 'required|numeric|between:32,42',
        'respiratory_rate' => 'required|integer|between:0,100',
        'pulse_rate' => 'required|integer|between:0,200',
        'blood_pressure' => 'required|string',
        'weight' => 'required|numeric|between:0,200',
        'height' => 'required|numeric|between:0,250',
        'muac' => 'required|numeric|between:0,50',
        'head_circumference' => 'required|numeric|between:0,60',
        'oxygen_saturation' => 'required|numeric|between:0,100',
        'triage_priority' => 'required|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    $staffId = auth()->user()->id;

    if (!$staffId) {
        Log::error('Authentication Error: Staff ID is missing');
        return response()->json([
            'status' => 'error',
            'message' => 'User not authenticated'
        ], 401);
    }

    try {
        // Create the triage record without assessment_id
        Triage::create([
            'visit_id' => $request->visit_id,
            'child_id' => $request->child_id,
            'staff_id' => $staffId,
            'data' => json_encode($request->except(['visit_id', 'child_id'])),
        ]);

        DB::table('visits')->where('id', $request->visit_id)->update(['triage_pass' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Triage data saved successfully',
        ], 201);
    } catch (\Exception $e) {
        Log::error('Failed to save triage data: ' . $e->getMessage());
        return response()->json([
            'status' => 'error', 
            'message' => 'Failed to save data: ' . $e->getMessage()
        ], 500);
    }
}


    public function getUntriagedVisits()
    {
        $date = now()->toDateString();

        try {
            $visits = DB::table('visits')
                ->join('children', 'visits.child_id', '=', 'children.id')
                ->select('visits.*', 'children.fullname')
                ->where('visits.triage_pass', false)
                ->whereDate('visits.visit_date', $date)
                ->get()
                ->map(function ($visit) {
                    try {
                        $fullname = json_decode($visit->fullname);

                        if ($fullname && isset($fullname->first_name, $fullname->middle_name, $fullname->last_name)) {
                            $visit->patient_name = trim(
                                "{$fullname->first_name} {$fullname->middle_name} {$fullname->last_name}"
                            );
                        } else {
                            $visit->patient_name = $visit->fullname ?? 'N/A';
                        }
                    } catch (\Exception $e) {
                        $visit->patient_name = 'N/A';
                    }

                    return $visit;
                });

            return response()->json([
                'status' => 'success',
                'data' => $visits,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch untriaged visits: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch visits',
            ], 500);
        }
    }
    // 'doctor_id' => auth()->user()->id,
    public function getPostTriageQueue()
    {
        try {
            $doctorId = auth()->user()->id;
            $date = now()->toDateString();
            $cacheKey = "post_triage_queue_{$doctorId}_{$date}";
    
            // Check if data exists in cache
            if (Cache::has($cacheKey)) {
                $cachedPatients = Cache::get($cacheKey);
    
                // Check if there are new records in the database
                $latestRecord = DB::table('visits')
                    ->where('triage_pass', true)
                    ->whereDate('visit_date', $date)
                    ->where('doctor_id', $doctorId)
                    ->latest('created_at')
                    ->first();
    
                // If the latest record in the database is not in the cache, refresh the cache
                if (!$latestRecord || !collect($cachedPatients)->contains('id', $latestRecord->id)) {
                    $patients = $this->fetchPatientsFromDatabase($doctorId, $date);
                    Cache::put($cacheKey, $patients, now()->addMinutes(60));
                    return response()->json([
                        'status' => 'success',
                        'data' => $patients
                    ]);
                }
    
                return response()->json([
                    'status' => 'success',
                    'data' => $cachedPatients
                ]);
            }
    
            // Fetch data from the database and store in cache
            $patients = $this->fetchPatientsFromDatabase($doctorId, $date);
            Cache::put($cacheKey, $patients, now()->addMinutes(60));
    
            return response()->json([
                'status' => 'success',
                'data' => $patients
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch post-triage queue',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    


    private function fetchPatientsFromDatabase($doctorId, $date)
    {
        Log::info("Fetching post-triage queue for Doctor ID: {$doctorId} on {$date}");
    
        try {
            // Fetch records from the database
            $patients = DB::table('visits')
                ->join('children', 'visits.child_id', '=', 'children.id')
                ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
                ->select(
                    'visits.*',
                    'children.fullname as child_fullname',
                    'children.registration_number',
                    'visit_type.visit_type as visit_type_name',
                    'visit_type.sponsored_price',
                    'visit_type.normal_price'
                )
                ->where('visits.triage_pass', true)
                ->whereDate('visits.visit_date', $date)
                ->where('visits.doctor_id', $doctorId)
                ->latest('visits.created_at')
                ->limit(20)
                ->get();
    
            Log::info("Fetched " . count($patients) . " patients for Doctor ID: {$doctorId}");
    
            // Map and process patient data
            $processedPatients = $patients->map(function ($visit) {
                try {
                    // Decode child's fullname
                    $fullname = json_decode($visit->child_fullname);
                    if ($fullname && isset($fullname->first_name, $fullname->middle_name, $fullname->last_name)) {
                        $visit->patient_name = trim("{$fullname->first_name} {$fullname->middle_name} {$fullname->last_name}");
                    } else {
                        $visit->patient_name = $visit->child_fullname ?? 'N/A';
                    }
                } catch (\Exception $e) {
                    Log::error("Error decoding child's fullname: " . $e->getMessage());
                    $visit->patient_name = 'N/A';
                }
    
                // Attach visit type info
                $visit->visit_type = $visit->visit_type_name ?? 'N/A';
                $visit->sponsored_price = $visit->sponsored_price ?? 0;
                $visit->normal_price = $visit->normal_price ?? 0;
    
                Log::debug("Processed Visit ID: {$visit->id} | Patient: {$visit->patient_name} | Visit Type: {$visit->visit_type}");
    
                return $visit;
            });
    
            return $processedPatients;
        } catch (\Exception $e) {
            Log::error("Failed to fetch post-triage queue for Doctor ID: {$doctorId}. Error: " . $e->getMessage());
            return collect(); // Return empty collection on failure
        }
    }
    
    public function getNurseName() {
        $nurse = auth()->user();

        if (is_object($nurse->fullname)) {
            $fullName = $nurse->fullname;
            Log::info('fullname is already an object:', (array)$fullName);
        } else {
            $fullName = json_decode($nurse->fullname, true);
            Log::info('fullname decoded from JSON:', $fullName);
        }
        return
        $fullName->firstname;
    
    }


    public function getTriageData($child_id)
    {
        // Fetch the triage record for the given child_id
        $triageRecord = Triage::where('child_id', $child_id)->first();

        if ($triageRecord) {
            return response()->json([
                'data' => $triageRecord,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No triage data found for the given child_id',
            ], 404);
        }
    }
}
