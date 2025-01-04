<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade

class DoctorsController extends Controller
{ 
    public function show($registrationNumber)
     {
        $child = DB::table('children')
                    ->where('registration_number', $registrationNumber)
                    ->first();

        if (!$child) {
            abort(404);
        }

        // Decode the fullname JSON
        $fullname = json_decode($child->fullname);

        // Access the first_name, middle_name, and last_name
        $firstName = $fullname->first_name;
        $middleName = $fullname->middle_name;
        $lastName = $fullname->last_name;

        // Get the gender name from the gender table
        $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

        // Fetch triage data for the child
        $triage = DB::table('triage')->where('child_id', $child->id)->first();

        if ($triage) {
            // Decode the triage data JSON
            $triageData = json_decode($triage->data);

            // Access the individual data points
            $temperature = $triageData->temperature;
            $weight = $triageData->weight;
            $height = $triageData->height;
            $head_circumference = $triageData->head_circumference;
            $blood_pressure = $triageData->blood_pressure;
            $pulse_rate = $triageData->pulse_rate;
            $respiratory_rate = $triageData->respiratory_rate;
            $oxygen_saturation = $triageData->oxygen_saturation;
            $MUAC = $triageData->MUAC; 

            // Pass the decoded triage data to the view
            return view('doctor', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'triage' => $triage,
                'temperature' => $temperature,
                'weight' => $weight,
                'height' => $height,
                'head_circumference' => $head_circumference,
                'blood_pressure' => $blood_pressure,
                'pulse_rate' => $pulse_rate,
                'respiratory_rate' => $respiratory_rate,
                'oxygen_saturation' => $oxygen_saturation,
                'MUAC' => $MUAC
            ]);
        } else {
            // Handle case where no triage data is found
            return view('doctor', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'triage' => null, 
            ]);
        }
    }


    public function getTriageData($registrationNumber)
    {
        try {
            Log::info("getTriageData called with registration number: " . $registrationNumber);

            $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

            if (!$child) {
                Log::warning("Child not found for registration number: " . $registrationNumber);
                abort(404);
            }

            $triage = DB::table('triage')->where('child_id', $child->id)->first();

            if (!$triage) {
                Log::warning("Triage data not found for child with registration number: " . $registrationNumber);
                return response()->json(['error' => 'Triage data not found'], 404);
            }

            $triageData = json_decode($triage->data);

            Log::info("Triage data retrieved: ", (array)$triageData);

            return response()->json($triageData);
        } catch (\Exception $e) {
            Log::error("Error in getTriageData: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function saveCnsData(Request $request, $registrationNumber)
    {
        try {
            Log::info("saveCnsData called with registration number: " . $registrationNumber);
    
            // Start query logging
            DB::enableQueryLog();  // Enable query logging
    
            // Find child by registration number
            $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
            if (!$child) {
                return response()->json(['error' => 'Child not found'], 404);
            }
    
            // Get the latest visit for the child from the visits table
            $visit = DB::table('visits')
                ->where('child_id', $child->id)
                ->orderBy('created_at', 'desc') // Order by the latest visit
                ->first();
    
            if (!$visit) {
                return response()->json(['error' => 'No visit found for the child'], 404);
            }
    
            // Create or update the CNS data
            DB::table('cns')->updateOrInsert(
                [
                    'visit_id' => $visit->id, // Associate with visit
                    'child_id' => $child->id,
                    'doctor_id' => auth()->user()->id, // Replace with logic for the actual doctor ID
                ],
                ['data' => json_encode($request->all())] // Ensure data is JSON encoded
            );
    
            // Log all executed queries
            Log::info("Executed Queries: " . json_encode(DB::getQueryLog()));
    
            return response()->json(['message' => 'CNS data saved successfully'], 200);
    
        } catch (\Exception $e) {
            Log::error("Error in saveCnsData: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function getMilestones($registrationNumber)
    {
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        $milestone = DB::table('development_milestones')
            ->where('child_id', $child->id)
            ->latest()
            ->first();

        return response()->json(['data' => $milestone ? $milestone->data : null], 200);
    }

    public function saveMilestones(Request $request, $registrationNumber)
    {
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->latest()
            ->first();

        if (!$visit) {
            return response()->json(['error' => 'No visit found for the child'], 404);
        }

        DB::table('development_milestones')->updateOrInsert(
            [
                'visit_id' => $visit->id,
                'child_id' => $child->id,
                'doctor_id' => auth()->user()->id, // Replace with authenticated doctor ID
            ],
            ['data' => json_encode($request->data), 'updated_at' => now()]
        );

        return response()->json(['message' => 'Milestones saved successfully'], 200);
    }

}

