<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DiagnosisController extends Controller
{
    /**
     * Fetch the most recent Diagnosis data for a child.
     */
    public function getDiagnosis($registrationNumber)
    {
        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the most recent diagnosis for the child
        $diagnosis = DB::table('diagnosis')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc') // Fetch the most recent diagnosis
            ->first();

        if ($diagnosis) {
            return response()->json([
                'data' => json_decode($diagnosis->data),
                'visit_id' => $diagnosis->visit_id, // Include visit ID for context
            ], 200);
        } else {
            return response()->json([
                'data' => null,
                'message' => 'No Diagnosis found for this child',
            ], 200);
        }
    }

    /**
     * Save or update Diagnosis data for the latest visit.
     */
    public function saveDiagnosis(Request $request, $registrationNumber)
    {
        // Validate the incoming request data
        $request->validate([
            'primaryDiagnosis' => 'required|string', // Ensure primary diagnosis is provided
            'secondaryDiagnosis' => 'nullable|string', // Secondary diagnosis is optional
            'otherDiagnosis' => 'nullable|string', // Other diagnosis is optional
        ]);

        // Fetch the child record using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the latest visit for the child
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc') // Get the latest visit
            ->first();

        if (!$visit) {
            return response()->json(['message' => 'No visit found for this child'], 404);
        }

        // Placeholder doctor ID (replace this logic with actual doctor determination)
        $doctorId = auth()->user()->id; // Replace with actual logic for determining doctor ID

        try {
            // Prepare the data to be saved
            $data = [
                'primaryDiagnosis' => $request->primaryDiagnosis,
                'secondaryDiagnosis' => $request->secondaryDiagnosis,
                'otherDiagnosis' => $request->primaryDiagnosis === 'Other' ? $request->otherDiagnosis : null,
            ];

            $existingDiagnosis = DB::table('diagnosis')
            ->where('visit_id', $visit->id)
            ->first();

            if (!$existingDiagnosis) { // Create a new record only if none exists for the visit
                DB::table('diagnosis')->insert([
                    'child_id' => $child->id,
                    'visit_id' => $visit->id,
                    'data' => json_encode($data),
                    'doctor_id' => $doctorId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        return response()->json(['message' => 'Diagnosis saved successfully!']);
    } else {
        DB::table('diagnosis')
            ->where('id', $existingDiagnosis->id)
            ->update([
                'data' => json_encode($data),
                'updated_at' => now(),
            ]);
    }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save Diagnosis', 'error' => $e->getMessage()], 500);
        }
    }
    public function getDiseaseStatistics()
{
    // Cache key for disease statistics
    $cacheKey = 'disease_statistics'; 
    $cachedData = Cache::get($cacheKey);
    
    if ($cachedData) {
        // If cached data exists, log it and return
        Log::info('Cached Disease Statistics Retrieved:', $cachedData);
        return response()->json($cachedData);
    }

    // Define target diseases (we keep 'ADHD' as a special case)
    $targetDiseases = [
        'Autism' => 'Autism', 
        'Attention deficit' => 'ADHD',  // Changed ADHD to Attention deficit
        'Learning disorder' => 'Learning disorder', 
        'Intellectual development' => 'Intellectual development',
    ];
    
    // Initialize disease counts
    $diseaseCounts = array_fill_keys(array_values($targetDiseases), 0);
    $diseaseCounts['Other'] = 0;

    // Efficiently query diagnoses and filter relevant records
    $diagnoses = Diagnosis::select('data')->get();

    foreach ($diagnoses as $diagnosis) {
        $data = $diagnosis->data['diagnoses'] ?? [];

        // Use a set to prevent counting a disease multiple times
        $foundDiseases = [];

        foreach ($data as $entry) {
            // Optimize the search by only checking each entry once
            foreach ($targetDiseases as $keyword => $disease) {
                // Check for substring match (case insensitive)
                if (stripos($entry, $keyword) !== false && !isset($foundDiseases[$disease])) {
                    $foundDiseases[$disease] = true;

                    // Increase count for the matched disease
                    $diseaseCounts[$disease]++;
                    break;  // No need to check further diseases for this entry
                }
            }
        }

        // If no target disease found, classify as "Other"
        if (empty($foundDiseases)) {
            $diseaseCounts['Other']++;
        }
    }

    // Log the data before caching
    Log::info('Disease Statistics Before Caching:', $diseaseCounts);

    // Cache the disease statistics data for 60 minutes
    Cache::put($cacheKey, $diseaseCounts, now()->addMinutes(60));

    // Return the disease statistics
    return response()->json($diseaseCounts);
}

    
}