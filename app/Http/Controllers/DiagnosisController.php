<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosisController extends Controller
{
    /**
     * Fetch the most recent Diagnosis data for a child.
     */
    public function getDiagnosis($registrationNumber)
    {
        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the most recent diagnosis for the child
        $diagnosis = DB::table('diagnosis')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc') // Fetch the most recent diagnosis
            ->first();

        if ($diagnosis) {
            return response()->json([
                'data' => json_decode($diagnosis->data),
                'visit_id' => $diagnosis->visit_id, // Include visit ID for context
            ], 200);
        } else {
            return response()->json([
                'data' => null,
                'message' => 'No Diagnosis found for this child',
            ], 200);
        }
    }

    /**
     * Save or update Diagnosis data for the latest visit.
     */
    public function saveDiagnosis(Request $request, $registrationNumber)
    {
        // Validate the incoming request data
        $request->validate([
            'primaryDiagnosis' => 'required|string', // Ensure primary diagnosis is provided
            'secondaryDiagnosis' => 'nullable|string', // Secondary diagnosis is optional
            'otherDiagnosis' => 'nullable|string', // Other diagnosis is optional
        ]);

        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest visit for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc') // Get the latest visit
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visit found for this child'], 404);
        }

        // Placeholder doctor ID (replace this logic with actual doctor determination)
        $doctorId = 1; // Replace with actual logic for determining doctor ID

        try {
            // Prepare the data to be saved
            $data = [
                'primaryDiagnosis' => $request->primaryDiagnosis,
                'secondaryDiagnosis' => $request->secondaryDiagnosis,
                'otherDiagnosis' => $request->primaryDiagnosis === 'Other' ? $request->otherDiagnosis : null,
            ];

            // Create a new Diagnosis record for the latest visit
            DB::table('diagnosis')->insert([
                'child_id' => $child->id,
                'visit_id' => $visit->id,
                'data' => json_encode($data), // Ensure data is JSON encoded
                'doctor_id' => $doctorId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Diagnosis saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save Diagnosis', 'error' => $e->getMessage()], 500);
        }
    }
}
