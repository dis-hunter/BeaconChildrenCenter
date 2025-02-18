<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DiagnosisController extends Controller
{
    public function saveDiagnosis(Request $request, $registrationNumber)
    {
        Log::info("Registration number received: " . $registrationNumber);

        try {
            // 1. Access diagnoses directly from the request
            $diagnoses = $request->input('diagnoses');

            // Log the received diagnoses data
            Log::info('Diagnoses received:', ['data' => $diagnoses]);

            // 2. Validate that diagnoses is an array
            if (!is_array($diagnoses)) {
                return response()->json(['message' => 'The diagnoses must be an array.'], 400);
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

            // Prepare the data to be saved (only diagnoses)
            $diagnosisData = [
                'diagnoses' => $diagnoses, 
            ];

            // Insert the data into the diagnoses table (make sure you have this table)
            DB::table('diagnosis')->insert([ 
                'visit_id' => $visit->id,
                'child_id' => $child->id,
                'doctor_id' => 1, // Replace with actual staff ID logic
                'data' => json_encode($diagnosisData),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Diagnoses saved successfully'], 201);

        } catch (\Exception $e) {
            Log::error("Error saving diagnoses: {$e->getMessage()}");
            return response()->json(['error' => 'Failed to save diagnoses'], 500);
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