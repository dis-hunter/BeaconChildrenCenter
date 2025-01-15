<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
    public function saveDiagnosis(Request $request, $registrationNumber)
    {
        Log::info("Registration number received: " . $registrationNumber);

        try {
            // 1. Access diagnoses directly from the request
            $diagnoses = $request->input('diagnoses');

            // Log the received diagnoses data
            Log::info('Diagnoses received:', ['data' => $diagnoses]);

            // 2. Validate that diagnoses is an array
            if (!is_array($diagnoses)) {
                return response()->json(['message' => 'The diagnoses must be an array.'], 400);
            }

            // Find the child by registration number
            $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

            if (!$child) {
                return response()->json(['message' => 'Child not found'], 404);
            }

            Log::info("Child found with ID: " . $child->id);

            // Find the latest visit for the child
            $visit = DB::table('visits')
                ->where('child_id', $child->id)
                ->latest()
                ->first();

            if (!$visit) {
                Log::error("No visit found for child ID: " . $child->id);
                return response()->json(['message' => 'No visit found for this child'], 404);
            }

            Log::info("Visit found with ID: " . $visit->id);

            // Prepare the data to be saved (only diagnoses)
            $diagnosisData = [
                'diagnoses' => $diagnoses, 
            ];

            // Insert the data into the diagnoses table (make sure you have this table)
            DB::table('diagnosis')->insert([ 
                'visit_id' => $visit->id,
                'child_id' => $child->id,
                'doctor_id' => 1, // Replace with actual staff ID logic
                'data' => json_encode($diagnosisData),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Diagnoses saved successfully'], 201);

        } catch (\Exception $e) {
            Log::error("Error saving diagnoses: {$e->getMessage()}");
            return response()->json(['error' => 'Failed to save diagnoses'], 500);
        }
    }
}