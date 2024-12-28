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

        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Use a placeholder doctor ID if actual logic for determining doctor_id isn't available
        $doctorId = 1; // Replace with logic to fetch the actual doctor ID if needed

        try {
            // Create or update the Perinatal History record
            DB::table('perinatal_history')->updateOrInsert(
                [
                    'child_id' => $child->id, // Ensure only one record per child
                ],
                [
                    'data' => json_encode($request->data), // Ensure data is JSON encoded
                    'doctor_id' => $doctorId,
                    'updated_at' => now(),
                    'created_at' => now(), // Required for insert operations
                ]
            );

            return response()->json(['message' => 'Perinatal History saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save Perinatal History', 'error' => $e->getMessage()], 500);
        }
    }
}
