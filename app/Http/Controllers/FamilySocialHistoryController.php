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

        // Fetch the Family and Social History record for the child
        $familySocialHistory = DB::table('family_social_history')
            ->where('child_id', $child->id)
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
    // ... other code ...

public function saveFamilySocialHistory(Request $request, $registrationNumber)
{
    // Validate the incoming request data
    $request->validate([
        'data' => 'required|array', 
    ]);

    try {
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $doctorId = auth()->user()->id; // Replace with your actual logic

        // Check if a record exists for the child and doctor
        $existingRecord = DB::table('family_social_history')
                            ->where('child_id', $child->id)
                            ->where('doctor_id', $doctorId) 
                            ->first();

        if ($existingRecord) {
            DB::table('family_social_history')
                ->where('id', $existingRecord->id) 
                ->update([
                    'visit_id' => $visit?->id, 
                    'data' => json_encode($request->data), 
                    'updated_at' => now(), 
                ]);

            return response()->json(['message' => 'Family and Social History updated successfully!']);

        } else {
            DB::table('family_social_history')->insert([
                'child_id' => $child->id, 
                'visit_id' => $visit?->id,
                'data' => json_encode($request->data),
                'doctor_id' => $doctorId, 
                'updated_at' => now(),
                'created_at' => now(), 
            ]);

            return response()->json(['message' => 'Family and Social History saved successfully!']);
        } 

    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to save Family and Social History', 'error' => $e->getMessage()], 500);
    }
}
}
