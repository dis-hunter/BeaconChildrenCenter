<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerinatalHistoryController extends Controller
{
    /**
     * Fetch Perinatal History data for a child.
     */
    public function getPerinatalHistory($registrationNumber)
    {
        // Fetch the child ID using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the Perinatal History record for the child
        $perinatalHistory = DB::table('perinatal_history')
            ->where('child_id', $child->id)
            ->first();

        if ($perinatalHistory) {
            return response()->json(['data' => json_decode($perinatalHistory->data)], 200);
        } else {
            return response()->json(['data' => null, 'message' => 'No Perinatal History found'], 200);
        }
    }

    /**
     * Save or update Perinatal History data.
     */
    public function savePerinatalHistory(Request $request, $registrationNumber)
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
        $existingRecord = DB::table('perinatal_history')
                            ->where('child_id', $child->id)
                            ->where('doctor_id', $doctorId)
                            ->first();

        if ($existingRecord) {
            // Update the existing record
            DB::table('perinatal_history')
                ->where('id', $existingRecord->id)
                ->update([
                    'data' => json_encode($request->data),
                    'updated_at' => now(),
                ]);

            return response()->json(['message' => 'Perinatal History updated successfully!']);
        } else {
            // Create a new record
            DB::table('perinatal_history')->insert([
                'child_id' => $child->id,
                'data' => json_encode($request->data),
                'doctor_id' => $doctorId,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            return response()->json(['message' => 'Perinatal History saved successfully!']);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to save Perinatal History', 'error' => $e->getMessage()], 500);
    }
}
}
