<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarePlanController extends Controller
{
    public function saveCarePlan($registration_number, Request $request)
    {
        // Log the registration number for debugging
        Log::info("Registration number received: " . $registration_number);

        // Validate the incoming data
        $data = $request->validate([
            'occupationalTherapy' => 'boolean',
            'speechTherapy' => 'boolean',
            'physioTherapy' => 'boolean',
            'physcoTherapy' => 'boolean', 
            'abaTherapy' => 'boolean',
            'nutritionist' => 'boolean',
        ]);

        // Log the validated data for debugging
        Log::info("Validated data: ", $data);

        // Find the child by registration number
        $child = DB::table('children')->where('registration_number', $registration_number)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Assuming staff ID is 1 (replace with actual logic to get staff ID)
        $staffId = 1;

        try {
            // Check if a care plan already exists for the child
            $existingCarePlan = DB::table('careplan')->where('child_id', $child->id)->first();

            if ($existingCarePlan) {
                // Update the existing care plan
                DB::table('careplan')->where('child_id', $child->id)->update([
                    'staff_id' => $staffId,
                    'data' => json_encode($data), // Update care plan data
                    'updated_at' => now(),
                ]);

                return response()->json(['message' => 'Care plan updated successfully']);
            } else {
                // Insert a new care plan record
                DB::table('careplan')->insert([
                    'child_id' => $child->id,
                    'staff_id' => $staffId,
                    'data' => json_encode($data), // Store the care plan data as JSON
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json(['message' => 'Care plan saved successfully']);
            }
        } catch (\Exception $e) {
            Log::error('Error while saving/updating care plan: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to save care plan', 'error' => $e->getMessage()], 500);
        }
    }
}
