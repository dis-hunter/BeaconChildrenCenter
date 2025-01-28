<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MetricsController extends Controller
{
    public function keyMetrics()
    {
        // Count total patients
        $totalPatients = DB::table('children')->count();

        // Count today's registrations
        $today = Carbon::today()->toDateString();
        $newRegistrations = DB::table('children')
            ->whereDate('created_at', $today)
            ->count();

        // Return data to the view
        return view('beaconAdmin', [
            'totalPatients' => $totalPatients,
            'newRegistrations' => $newRegistrations,
        ]);
        
    }

    public function ageDistribution()
    {
        // Calculate age distribution
        $ageDistribution = DB::table('children')
            ->selectRaw('EXTRACT(YEAR FROM AGE(dob)) AS age, COUNT(*) AS count')
            ->groupBy('age')
            ->orderBy('age')
            ->get();

        return response()->json($ageDistribution);
    }
}
