<?php
namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        // Fetch all children records
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

        // Log the age groups
        Log::info('Age Groups Data:', $ageGroups);

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

        // Log the gender distribution
        Log::info('Gender Distribution Data:', $genderDistribution);

        // Return data as JSON response
        return response()->json([
            'ageGroups' => $ageGroups,
            'genderDistribution' => $genderDistribution,
        ]);
    }
}
