<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilySocialHistoryController extends Controller
{
    /**
     * Fetch Family and Social History data for a child.
     */
    public function getFamilySocialHistory($registrationNumber)
    {
        // Fetch the child ID using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest Family and Social History for the child
        $familySocialHistory = DB::table('family_social_history')
            ->where('child_id', $child->id)
            ->latest()
            ->first();

        if ($familySocialHistory) {
            return response()->json(['data' => json_decode($familySocialHistory->data)], 200);
        } else {
            return response()->json(['data' => null, 'message' => 'No Family and Social History found'], 200);
        }
    }

    /**
     * Save or update Family and Social History data.
     */
    public function saveFamilySocialHistory(Request $request, $registrationNumber)
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

        // Fetch the latest visit for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc') // Order by the latest visit
            ->first();

        if (!$visit) {
            return response()->json(['error' => 'No visit found for the child'], 404);
        }

        // Use a placeholder doctor ID if actual logic for determining doctor_id isn't available
        $doctorId = 1; // Replace with logic to fetch the actual doctor ID if needed

        try {
            // Create or update the Family and Social History record
            DB::table('family_social_history')->updateOrInsert(
                [
                    'visit_id' => $visit->id, // Associate with visit
                    'child_id' => $child->id,
                    'doctor_id' => $doctorId,
                ],
                [
                    'data' => json_encode($request->data), // Ensure data is JSON encoded
                    'updated_at' => now(),
                    'created_at' => now(), // Required for insert operations
                ]
            );

            return response()->json(['message' => 'Family and Social History saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save Family and Social History', 'error' => $e->getMessage()], 500);
        }
    }
}
