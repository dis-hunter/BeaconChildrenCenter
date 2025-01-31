<?php
namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PatientDemographicsController extends Controller
{
    /**
     * Fetch data for patient demographics pie charts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDemographicsData()
    {
        // Check if the demographics data is already cached
        $cacheKey = 'patient_demographics_data'; // Set a cache key
        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            // If data is found in the cache, log it
            Log::info('Cached Data Retrieved:', $cachedData);
            
            // Return cached data
            return response()->json($cachedData);
        }

        // If no cached data, fetch from database and calculate the demographics
        $children = Children::all();

        // Initialize age groups
        $ageGroups = [
            '0-5' => 0,
            '6-12' => 0,
            '13-18' => 0,
            '19+' => 0,
        ];

        // Calculate age groups
        foreach ($children as $child) {
            $age = Carbon::parse($child->dob)->age;

            if ($age <= 5) {
                $ageGroups['0-5']++;
            } elseif ($age <= 12) {
                $ageGroups['6-12']++;
            } elseif ($age <= 18) {
                $ageGroups['13-18']++;
            } else {
                $ageGroups['19+']++;
            }
        }

        // Initialize gender distribution
        $genderDistribution = [
            'Male' => 0,
            'Female' => 0,
            'Other' => 0,
        ];

        // Calculate gender distribution
        foreach ($children as $child) {
            $genderId = $child->gender->id;
            switch ($genderId) {
                case 1:
                    $genderDistribution['Male']++;
                    break;
                case 2:
                    $genderDistribution['Female']++;
                    break;
                case 3:
                    $genderDistribution['Other']++;
                    break;
                default:
                    break;
            }
        }

        // Prepare data to be cached
        $dataToCache = [
            'ageGroups' => $ageGroups,
            'genderDistribution' => $genderDistribution,
        ];

        // Log the data before caching
        Log::info('Data Before Caching:', $dataToCache);

        // Cache the data for 60 minutes (you can adjust the time as needed)
        Cache::put($cacheKey, $dataToCache, now()->addMinutes(60));

        // Return the demographics data
        return response()->json($dataToCache);
    }
}
