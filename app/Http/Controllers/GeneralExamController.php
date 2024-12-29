<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralExamController extends Controller
{
    /**
     * Fetch General Exam data for the latest visit based on registration number.
     */
    public function getGeneralExam($registrationNumber)
    {
        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest visit record for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visits found for the child'], 404);
        }

        // Fetch the General Exam record for the visit
        $generalExam = DB::table('general_exam')->where('visit_id', $visit->id)->first();

        if ($generalExam) {
            return response()->json(['data' => json_decode($generalExam->data)], 200);
        } else {
            return response()->json(['data' => null, 'message' => 'No General Exam found'], 200);
        }
    }

    /**
     * Save or update General Exam data for the latest visit.
     */
    public function saveGeneralExam(Request $request, $registrationNumber)
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

        // Fetch the latest visit record for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visits found for the child'], 404);
        }

        $doctorId = 1; // Placeholder doctor ID (replace with dynamic logic if necessary)

        try {
            // Create or update the General Exam record for the visit
            DB::table('general_exam')->updateOrInsert(
                ['visit_id' => $visit->id], // Match on visit_id
                [
                    'child_id' => $child->id,
                    'doctor_id' => $doctorId,
                    'data' => json_encode($request->data), // Ensure data is JSON encoded
                    'updated_at' => now(),
                    'created_at' => now(), // Used only when inserting
                ]
            );

            return response()->json(['message' => 'General Examination saved or updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save or update General Examination', 'error' => $e->getMessage()], 500);
        }
    }
}
