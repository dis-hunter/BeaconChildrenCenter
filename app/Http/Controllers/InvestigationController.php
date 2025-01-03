<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvestigationController extends Controller
{
    /**
     * Save or update investigations for a specific child based on registration number.
     */
    public function saveInvestigations($registration_number, Request $request)
    {
        // Log the registration number for debugging
        Log::info("Registration number received: " . $registration_number);

        // Validate the incoming data (adjusted for the new format)
        $data = $request->validate([
            'haematology' => 'array',
            'biochemistry' => 'array',
            'urine' => 'array',
            'stool' => 'array',
            'xray' => 'array',
            'mri' => 'array',
            'ct' => 'array',
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
            'otherHaematology' => 'nullable|string',
            'otherBiochemistry' => 'nullable|string',
            'otherUrine' => 'nullable|string',
            'otherStool' => 'nullable|string',
            'other_functional_tests' => 'nullable|string', 
        ]);

        // Log the validated data for debugging
        Log::info("Validated data: ", $data);

        // Find the child by registration number
        $child = DB::table('children')->where('registration_number', $registration_number)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Find the latest visit for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visit found for this child'], 404);
        }

        // Collect the data into an array (store as JSON) - Adjusted for the new format
        $investigationData = [
            'haematology' => $data['haematology'] ?? [],
            'biochemistry' => $data['biochemistry'] ?? [],
            'urine' => $data['urine'] ?? [],
            'stool' => $data['stool'] ?? [],
            'xray' => $data['xray'] ?? [],
            'mri' => $data['mri'] ?? [],
            'ct' => $data['ct'] ?? [],
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
            'otherHaematology' => $data['otherHaematology'] ?? null,
            'otherBiochemistry' => $data['otherBiochemistry'] ?? null,
            'otherUrine' => $data['otherUrine'] ?? null,
            'otherStool' => $data['otherStool'] ?? null,
            'other_functional_tests' => $data['other_functional_tests'] ?? null, 
        ];

        // Log the final data to be saved
        Log::info("Investigation data to be saved: ", $investigationData);

        // Check if an investigation record already exists for the current visit
        $existingInvestigation = DB::table('investigations')
            ->where('visit_id', $visit->id)
            ->first();

        if ($existingInvestigation) {
            // Update the existing investigation record
            DB::table('investigations')
                ->where('id', $existingInvestigation->id)
                ->update([
                    'data' => json_encode($investigationData), // Update the data as JSON
                    'updated_at' => now(),
                ]);

            // Return a success response
            return response()->json(['message' => 'Investigation updated successfully', 'investigation_id' => $existingInvestigation->id]);
        } else {
            // Insert a new investigation record
            $investigationId = DB::table('investigations')->insertGetId([
                'visit_id' => $visit->id,
                'child_id' => $child->id,
                'staff_id' => 1, // Assuming the staff ID is 1, you can modify this to use the logged-in user's ID
                'data' => json_encode($investigationData), // Store the investigation data as JSON
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Return a success response
            return response()->json(['message' => 'Investigations saved successfully', 'investigation_id' => $investigationId]);
        }
    }

    public function recordResults($registration_number)
    {
        // Fetch child details using the registration number
        $child = DB::table('children')->where('registration_number', $registration_number)->first();
    
        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }
    
        // Fetch the latest investigation data for the child based on child_id (not visit_id)
        $investigation = DB::table('investigations')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc') // Order by creation date to get the most recent
            ->first();
    
        if (!$investigation) {
            return response()->json(['message' => 'No investigations found for this child'], 404);
        }
    
        // Decode the JSON data from the investigation table
        $investigationData = json_decode($investigation->data, true);
    
        // Ensure `created_at` is included in the response
        $investigationData['created_at'] = $investigation->created_at;
    
        // Return the data as JSON for use in the frontend
        return response()->json([
            'child' => $child,
            'investigationData' => $investigationData
        ]);
    }

    public function saveInvestigationResults($registration_number, Request $request)
    {
        // Fetch child details using the registration number
        $child = DB::table('children')->where('registration_number', $registration_number)->first();
    
        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }
    
        // Fetch the latest investigation for the child
        $investigation = DB::table('investigations')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();
    
        if (!$investigation) {
            return response()->json(['message' => 'No investigations found for this child'], 404);
        }
    
        // Validate the incoming data
        $validatedData = $request->validate([
            'results.*.name' => 'required|string',
            'results.*.value' => 'nullable|string',
            'results.*.comments' => 'nullable|string',
            'overall_impression' => 'nullable|string',
        ]);
    
        // Prepare results data
        $investigationResults = json_decode($investigation->data, true);
        $investigationResults['results'] = $validatedData['results'];
        $investigationResults['overall_impression'] = $validatedData['overall_impression'] ?? null;
    
        // Update the investigation record with the results
        DB::table('investigations')->where('id', $investigation->id)->update([
            'data' => json_encode($investigationResults),
            'updated_at' => now(),
        ]);
    
        return response()->json(['message' => 'Investigation results saved successfully']);
    }
}