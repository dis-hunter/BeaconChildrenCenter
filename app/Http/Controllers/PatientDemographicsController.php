<?php
namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class PatientDemographicsController extends Controller
{
    /**
     * Fetch data for patient demographics pie charts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDemographicsData()
    {
        $cacheKey = 'patient_demographics_data'; // Set a cache key

        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
           
            return response()->json($cachedData);
        }

        // Use eager loading to prevent N+1 queries
        $children = Children::with('gender')->get(['id', 'dob', 'gender_id']);

        // Calculate age groups
        $ageGroups = [
            '0-5' => 0,
            '6-12' => 0,
            '13-18' => 0,
            '19+' => 0,
        ];

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

        // Use SQL aggregation instead of looping for gender distribution
        $genderDistribution = Children::selectRaw('gender_id, COUNT(*) as count')
            ->groupBy('gender_id')
            ->pluck('count', 'gender_id');

        // Convert gender IDs to labels
        $formattedGenderDistribution = [
            'Male' => $genderDistribution[1] ?? 0,
            'Female' => $genderDistribution[2] ?? 0,
            'Other' => $genderDistribution[3] ?? 0,
        ];

        // Prepare and cache data
        $dataToCache = [
            'ageGroups' => $ageGroups,
            'genderDistribution' => $formattedGenderDistribution,
        ];

       
        Cache::put($cacheKey, $dataToCache, now()->addMinutes(60));

        return response()->json($dataToCache);
    }
}

