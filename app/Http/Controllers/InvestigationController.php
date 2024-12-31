<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvestigationController extends Controller
{
    /**
     * Save investigations for a specific child based on registration number.
     */
    public function saveInvestigations($registration_number, Request $request)
    {
        // Log the registration number for debugging
        Log::info("Registration number received: " . $registration_number);

        // Validate the incoming data
        $data = $request->validate([
            'imaging' => 'array',
            'lab_requests' => 'array',
            'genetic_tests' => 'array',
            'electrophysiology' => 'array',
            'functional_tests' => 'array',
            'functional_tests.vanderbilt' => 'nullable|string',
            'functional_tests.mchat' => 'nullable|string',
            'functional_tests.ados' => 'nullable|string',
            'functional_tests.molten' => 'nullable|string',
            'functional_tests.grifiths' => 'nullable|string',
            'functional_tests.senzeny' => 'nullable|string',
            'functional_tests.learning' => 'nullable|string',
            'functional_tests.sleep' => 'nullable|string',
            'functional_tests.education' => 'nullable|string',
            'functional_tests.other' => 'nullable|string',
            'functional_tests.other_tests' => 'nullable|string',
            'other_lab_tests' => 'nullable|string'
        ]);

        // Log the validated data for debugging
        Log::info("Validated data: ", $data);

        // Find the child by registration number
        $child = DB::table('children')->where('registration_number', $registration_number)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Find the latest visit for the child using the query builder
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visit found for this child'], 404);
        }

        // Collect the data into an array (store as JSON)
        $investigationData = [
            'imaging' => $data['imaging'] ?? [],
            'lab_requests' => $data['lab_requests'] ?? [],
            'genetic_tests' => $data['genetic_tests'] ?? [],
            'electrophysiology' => $data['electrophysiology'] ?? [],
            'functional_tests' => [
                'vanderbilt' => $data['functional_tests']['vanderbilt'] ?? null,
                'mchat' => $data['functional_tests']['mchat'] ?? null,
                'ados' => $data['functional_tests']['ados'] ?? null,
                'molten' => $data['functional_tests']['molten'] ?? null,
                'grifiths' => $data['functional_tests']['grifiths'] ?? null,
                'senzeny' => $data['functional_tests']['senzeny'] ?? null,
                'learning' => $data['functional_tests']['learning'] ?? null,
                'sleep' => $data['functional_tests']['sleep'] ?? null,
                'education' => $data['functional_tests']['education'] ?? null,
                'other' => $data['functional_tests']['other'] ?? null,
                'other_tests' => $data['functional_tests']['other_tests'] ?? null
            ],
            'other_lab_tests' => $data['other_lab_tests'] ?? null
        ];

        // Log the final data to be saved
        Log::info("Investigation data to be saved: ", $investigationData);

        // Insert the investigation record into the database
        $investigationId = DB::table('investigations')->insertGetId([
            'visit_id' => $visit->id,
            'child_id' => $child->id,
            'staff_id' => 1, // Assuming the staff ID is 1 for now, you can modify this to use the logged-in user's ID
            'data' => json_encode($investigationData), // Store the investigation data as JSON
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Return a success response
        return response()->json(['message' => 'Investigations saved successfully', 'investigation_id' => $investigationId]);
    }
}

