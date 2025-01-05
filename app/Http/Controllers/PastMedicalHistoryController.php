<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PastMedicalHistoryController extends Controller
{
    /**
     * Fetch Past Medical History data for a child.
     */
    public function getPastMedicalHistory($registrationNumber)
    {
        // Fetch the child ID using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the Past Medical History record for the child
        $pastMedicalHistory = DB::table('past_medical_history')
            ->where('child_id', $child->id)->orderBy('created_at','desc')
            ->first();

        if ($pastMedicalHistory) {
            return response()->json(['data' => json_decode($pastMedicalHistory->data)], 200);
        } else {
            return response()->json(['data' => null, 'message' => 'No Past Medical History found'], 200);
        }
    }

    /**
     * Save or update Past Medical History data.
     */
    public function savePastMedicalHistory(Request $request, $registrationNumber)
{
    // Validate the incoming request data
    $request->validate([
        'data' => 'required|array', // Ensure the data is an array
    ]);

    try {
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        $doctorId = auth()->user()->id; // Replace with your actual logic

        // Check if a record exists for the child and doctor
        $existingRecord = DB::table('past_medical_history')
                            ->where('child_id', $child->id)
                            ->where('doctor_id', $doctorId)
                            ->first();

        if ($existingRecord) {
            // Update the existing record
            DB::table('past_medical_history')
                ->where('id', $existingRecord->id)
                ->update([
                    'data' => json_encode($request->data),
                    'updated_at' => now(),
                ]);

            return response()->json(['message' => 'Past Medical History updated successfully!']);
        } else {
            // Create a new record
            DB::table('past_medical_history')->insert([
                'child_id' => $child->id,
                'data' => json_encode($request->data),
                'doctor_id' => $doctorId,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            return response()->json(['message' => 'Past Medical History saved successfully!']);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to save Past Medical History', 'error' => $e->getMessage()], 500);
    }
}
}
