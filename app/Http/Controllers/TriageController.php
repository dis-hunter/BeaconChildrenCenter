<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Triage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            // 'temperature' => 'required|numeric|between:35,42',
            // 'respiratory_rate' => 'required|integer|between:0,100',
            // 'pulse_rate' => 'required|integer|between:0,200',
            // 'blood_pressure' => 'required|string',
            // 'weight' => 'required|numeric|between:0,200',
            // 'height' => 'required|numeric|between:0,250',
            // 'muac' => 'required|numeric|between:0,50',
            // 'head_circumference' => 'required|numeric|between:0,60',
            // 'oxygen_saturation' => 'required|numeric|between:0,100',
            // 'triage_priority' => 'required|string',
            // 'triage_sorting' => 'required|array|min:1',
            // 'triage_sorting.*' => 'required|string',
            // // Validate each array item
        ]);


        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Validation failed',
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }
        $staffId = auth()->user()->id;


        if (!$staffId) {
            Log::error('Authentication Error: Staff ID is missing');
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }else{
            return $staffId;
        }
        
        try {
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
            return response()->json(['status' => 'error', 'message' => 'Failed to save data'], 500);
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
