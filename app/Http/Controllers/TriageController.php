<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Triage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'temperature' => 'required|numeric',
            'respiratory_rate' => 'required|integer',
            'pulse_rate' => 'required|integer',
            'blood_pressure' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'muac' => 'required|numeric',
            'head_circumference' => 'required|numeric',
        ]);

        // Check validation
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // DB::table('triage')
            // Create Triage Examination Record
            Triage::create([
                'child_id' => $request->child_id, // Store child_id in the database
                'data' => json_encode([
                    'temperature' => $request->temperature,
                    'respiratory_rate' => $request->respiratory_rate,
                    'pulse_rate' => $request->pulse_rate,
                    'blood_pressure' => $request->blood_pressure,
                    'weight' => $request->weight,
                    'height' => $request->height,
                    'muac' => $request->muac,
                    'head_circumference' => $request->head_circumference,
                ]),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Triage examination data saved successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
 
    public function getUntriagedVisits()
{
    try {
        $visits = DB::table('visits')
            ->join('children', 'visits.child_id', '=', 'children.id') 
            ->select('visits.*', 'children.fullname')
            ->where('visits.triage_pass', false)
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
                    // Log::error('Failed to parse fullname: ' . $e->getMessage());
                    $visit->patient_name = 'N/A';
                }

                return $visit;
            });

        return response()->json([
            'status' => 'success',
            'data' => $visits
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to fetch untriaged visits: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch visits'
        ], 500);
    }
}
// 'doctor_id' => auth()->user()->id,
public function getPostTriageQueue()
{
    try {
        // Fetch authenticated user's ID
        $doctorId = auth()->user()->id;

        // Automatically fetch today's date in 'Y-m-d' format
        $date = now()->toDateString();

        $patients = DB::table('visits')
            ->join('children', 'visits.child_id', '=', 'children.id')
            ->select('visits.*', 'children.fullname', 'children.registration_number')
            ->where('visits.triage_pass', true)
            ->whereDate('visits.visit_date', $date)
            ->where('visits.staff_id', $doctorId) // Compare with authenticated user's ID
            ->get()
            ->map(function ($visit) {
                try {
                    // Decode and reformat fullname if it's in JSON format
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
