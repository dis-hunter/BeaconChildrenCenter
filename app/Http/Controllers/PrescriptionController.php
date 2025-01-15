<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    public function store(Request $request, $registrationNumber)
    {
        Log::info("Registration number received: " . $registrationNumber);

        try {
            // 1. Access prescribed_drugs directly from the request
            $prescribedDrugs = $request->input('prescribed_drugs');

        // Log the received prescribed drugs data
        Log::info('Prescribed drugs received:', ['data' => $prescribedDrugs]);

        // 1. Decode the JSON string into an array
        $prescribedDrugs = json_decode($prescribedDrugs, true); 

        // 2. Validate that prescribed_drugs is an array
        if (!is_array($prescribedDrugs)) {
            return response()->json(['message' => 'The prescribed drugs must be an array.'], 400);
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

            // Prepare the data to be saved (only prescribed_drugs)
            $prescriptionData = [
                'prescribed_drugs' => $prescribedDrugs, // No need for json_decode
            ];

            // Insert the data into the prescriptions table
            DB::table('prescriptions')->insert([
                'visit_id' => $visit->id,
                'child_id' => $child->id,
                'staff_id' => 1,
                'data' => json_encode($prescriptionData),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Prescription saved successfully'], 201);

        } catch (\Exception $e) {
            Log::error("Error saving prescription: {$e->getMessage()}");
            return response()->json(['error' => 'Failed to save prescription'], 500);
        }
    }
}