<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class GeneralExamController extends Controller
{
    /**
     * Fetch General Exam data for the latest visit based on registration number.
     */
    public function getGeneralExam($registrationNumber)
    {
        Log::info("Fetching general exam for registration number: {$registrationNumber}");

        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            Log::warning("Child not found for registration number: {$registrationNumber}");
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest visit record for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            Log::warning("No visits found for child ID: {$child->id}");
            return response()->json(['message' => 'No visits found for the child'], 404);
        }
        $doctorId = auth()->user()->id; // Placeholder doctor ID (replace with dynamic logic if necessary)
        Log::info("Doctor ID retrieved from auth: " . $doctorId);

        // Fetch the General Exam record for the visit
        $generalExam = DB::table('general_exam')->where('visit_id', $visit->id)->first();

        if ($generalExam) {
            Log::info("General exam data found for visit ID: {$visit->id}");
            return response()->json(['data' => json_decode($generalExam->data)], 200);
        } else {
            Log::info("No general exam data found for visit ID: {$visit->id}");
            return response()->json(['data' => null, 'message' => 'No General Exam found'], 200);
        }
    }

    /**
     * Save or update General Exam data for the latest visit.
     */
    public function saveGeneralExam(Request $request, $registrationNumber)
    {
        Log::info("Saving general exam for registration number: {$registrationNumber}", ['data' => $request->all()]);

        // Validate the incoming request data
        $validated = $request->validate([
            'data' => 'required|array',
        ]);

        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            Log::warning("Child not found for registration number: {$registrationNumber}");
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest visit record for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            Log::warning("No visits found for child ID: {$child->id}");
            return response()->json(['message' => 'No visits found for the child'], 404);
        }

        $staffId = 1; // Placeholder doctor ID (replace with dynamic logic if necessary)

        try {
            // Create or update the General Exam record for the visit
            DB::table('general_exam')->updateOrInsert(
                ['visit_id' => $visit->id], // Match on visit_id
                [
                    'child_id' => $child->id,
                    'staff_id' => $staffId,
                    'data' => json_encode($validated['data']), // Ensure data is JSON encoded
                    'updated_at' => now(),
                    'created_at' => now(), // Used only when inserting
                ]
            );

            Log::info("General exam saved successfully for visit ID: {$visit->id}");

            return response()->json(['message' => 'General Examination saved or updated successfully!']);
        } catch (\Exception $e) {
            Log::error("Failed to save general exam", ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to save or update General Examination',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
