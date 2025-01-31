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

        // Define target diseases and initialize disease counts
        $targetDiseases = ['Autism', 'ADHD', 'Learning disorder', 'Intellectual development'];
        $diseaseCounts = [
            'Autism' => 0,
            'ADHD' => 0,
            'Learning disorder' => 0,
            'Intellectual development' => 0,
            'Other' => 0,
        ];

        // Fetch all diagnoses records
        $diagnoses = Diagnosis::all();

        foreach ($diagnoses as $diagnosis) {
            $data = $diagnosis->data['diagnoses'] ?? [];
            $foundDiseases = [];

            // Loop through diagnoses data to match diseases
            foreach ($data as $entry) {
                foreach ($targetDiseases as $disease) {
                    if (stripos($entry, $disease) !== false && !in_array($disease, $foundDiseases)) {
                        $diseaseCounts[$disease]++;
                        $foundDiseases[] = $disease;
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

