<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DevelopmentAssessmentController extends Controller
{
    /**
     * Fetch Development Assessment data for the latest visit based on registration number.
     */
 

    
    public function getDevelopmentAssessment($registrationNumber)
    {
        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
    
        if (!$child) {
            Log::error("Child with registration number $registrationNumber not found.");
            return response()->json(['message' => 'Child not found'], 404);
        }
    
        // Logging the child's DOB
        Log::info("Child found: ID = {$child->id}, DOB = {$child->dob}");
    
        // Calculate the chronological age in months
        $dob = $child->dob; // Assuming 'dob' is in 'YYYY-MM-DD' format
        $birthDate = new \DateTime($dob);
        $currentDate = new \DateTime();
    
        // Logging the current date
        Log::info("Current Date: " . $currentDate->format('Y-m-d'));
    
        // Calculate the difference
        $interval = $birthDate->diff($currentDate);
    
        // Logging the difference in years and months
        Log::info("Age difference: {$interval->y} years, {$interval->m} months");
    
        // Convert age to months
        $chronologicalAgeMonths = ($interval->y * 12) + $interval->m; // Years to months + remaining months
    
        // Logging the final chronological age in months
        Log::info("Chronological Age (Months): $chronologicalAgeMonths");
    
        // Fetch the latest visit record for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();
    
        if (!$visit) {
            Log::error("No visits found for child ID: {$child->id}");
            return response()->json(['message' => 'No visits found for the child'], 404);
        }
    
        Log::info("Latest visit found: Visit ID = {$visit->id}, Created At = {$visit->created_at}");
    
        // Fetch the Development Assessment record for the visit
        $developmentAssessment = DB::table('development_assessment')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();
    
        if ($developmentAssessment) {
            Log::info("Development Assessment found for child ID: {$child->id}");
            return response()->json([
                'data' => json_decode($developmentAssessment->data),
                'chronologicalAgeMonths' => $chronologicalAgeMonths, // Added chronological age
            ], 200);
        } else {
            Log::warning("No Development Assessment found for child ID: {$child->id}");
            return response()->json([
                'data' => null,
                'message' => 'No Development Assessment found',
                'chronologicalAgeMonths' => $chronologicalAgeMonths, // Added chronological age
            ], 200);
        }
    }
    
    

    /**
     * Save or update Development Assessment data for the latest visit.
     */
    public function saveDevelopmentAssessment(Request $request, $registrationNumber)
    {
        // Validate the incoming request data
        $request->validate([
            'data' => 'required|array', // Ensure the data is an array
        ]);

        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest visit record for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visits found for the child'], 404);
        }

        $doctorId = auth()->user()->id; // Placeholder doctor ID (replace with dynamic logic if necessary)

        try {
            // Check if a Development Assessment record already exists
            $existingRecord = DB::table('development_assessment')->where('visit_id', $visit->id)->first();

            if ($existingRecord) {
                // Update existing record
                DB::table('development_assessment')
                    ->where('id', $existingRecord->id)
                    ->update([
                        'data' => json_encode($request->data),
                        'updated_at' => now(),
                    ]);

                return response()->json(['message' => 'Development Assessment updated successfully!']);
            } else {
                // Insert a new record
                DB::table('development_assessment')->insert([
                    'visit_id' => $visit->id,
                    'child_id' => $child->id,
                    'doctor_id' => $doctorId,
                    'data' => json_encode($request->data),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json(['message' => 'Development Assessment saved successfully!']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save Development Assessment', 'error' => $e->getMessage()], 500);
        }
    }
}
