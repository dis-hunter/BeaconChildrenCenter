<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarePlanController extends Controller
{
    public function saveCarePlan($registrationNumber, Request $request)
    {
        // Log the registration number for debugging
        Log::info("Registration number received: " . $registrationNumber);
    
        // Validate the incoming data (including the new fields)
        $request->validate([
            'occupationalTherapy' => 'required|boolean',
            'occupationalTherapyNotes' => 'nullable|string',
            'speechTherapy' => 'required|boolean',
            'speechTherapyNotes' => 'nullable|string',
            'sensoryIntegration' => 'required|boolean',
            'sensoryIntegrationNotes' => 'nullable|string',
            'physioTherapy' => 'required|boolean',
            'physioTherapyNotes' => 'nullable|string',
            'psychotherapy' => 'required|boolean',
            'psychotherapyNotes' => 'nullable|string',
            'abaTherapy' => 'required|boolean',
            'abaTherapyNotes' => 'nullable|string',
            'nutritionist' => 'required|boolean',
            'nutritionistNotes' => 'nullable|string',
            'medicalReport' => 'required|boolean',
            'medicalReportNotes' => 'nullable|string',
            'educationAssessment' => 'required|boolean',
            'educationAssessmentNotes' => 'nullable|string',
            'referral' => 'required|boolean',
            'referralNotes' => 'nullable|string',
            'assistiveDevices' => 'required|boolean',
            'assistiveDevicesNotes' => 'nullable|string',
            'orthotics' => 'required|boolean',
            'orthoticsNotes' => 'nullable|string',
            'otherNotes' => 'nullable|string',
            'returnDate' => 'nullable|date',
        ]);
    
        // Log the validated data for debugging
        Log::info("Validated data: ", $request->all());
    
        try {
            // Find the child by registration number
            $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
    
            if (!$child) {
                return response()->json(['message' => 'Child not found'], 404);
            }
    
            // Assuming staff ID is 1 (replace with actual logic to get staff ID)
            $staffId = auth()->user()->id;
        
    
            // Prepare the data to be stored as JSON
            $carePlanData = [
                'occupationalTherapy' => $request->occupationalTherapy,
                'occupationalTherapyNotes' => $request->occupationalTherapyNotes,
                'speechTherapy' => $request->speechTherapy,
                'speechTherapyNotes' => $request->speechTherapyNotes,
                'sensoryIntegration' => $request->sensoryIntegration,
                'sensoryIntegrationNotes' => $request->sensoryIntegrationNotes,
                'physioTherapy' => $request->physioTherapy,
                'physioTherapyNotes' => $request->physioTherapyNotes,
                'psychotherapy' => $request->psychotherapy,
                'psychotherapyNotes' => $request->psychotherapyNotes,
                'abaTherapy' => $request->abaTherapy,
                'abaTherapyNotes' => $request->abaTherapyNotes,
                'nutritionist' => $request->nutritionist,
                'nutritionistNotes' => $request->nutritionistNotes,
                'medicalReport' => $request->medicalReport,
                'medicalReportNotes' => $request->medicalReportNotes,
                'educationAssessment' => $request->educationAssessment,
                'educationAssessmentNotes' => $request->educationAssessmentNotes,
                'referral' => $request->referral,
                'referralNotes' => $request->referralNotes,
                'assistiveDevices' => $request->assistiveDevices,
                'assistiveDevicesNotes' => $request->assistiveDevicesNotes,
                'orthotics' => $request->orthotics,
                'orthoticsNotes' => $request->orthoticsNotes,
                'otherNotes' => $request->otherNotes,
                'returnDate' => $request->returnDate,
            ];
    
            // Check if a care plan already exists for the child and staff member
            $existingCarePlan = DB::table('careplan')
                                ->where('child_id', $child->id)
                                ->where('staff_id', $staffId)
                                ->first();
    
            if ($existingCarePlan) {
                // Update the existing care plan with the new JSON data
                DB::table('careplan')
                    ->where('child_id', $child->id)
                    ->where('staff_id', $staffId)
                    ->update([
                        'data' => json_encode($carePlanData),
                        'updated_at' => now(),
                    ]);
    
                return response()->json(['message' => 'Care plan updated successfully']);
            } else {
                // Insert a new care plan record with the JSON data
                DB::table('careplan')->insert([
                    'child_id' => $child->id,
                    'staff_id' => $staffId,
                    'data' => json_encode($carePlanData),
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
