<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TherapistController extends Controller
{
    public function index()
    {
        // Fetch necessary data for the page
        return view('therapist_dashboard.therapist_dashboard');
    }

    public function saveTherapyNeeds(Request $request)
    {
        // Validate and save therapy needs
        $validated = $request->validate([
            'patientName' => 'required|string|max:255',
            'therapyNeeds' => 'required|string',
            'therapyGoals' => 'required|string',
            'numSessions' => 'required|integer|min:1',
        ]);

        // Save to the database (pseudo-code)
        // TherapyNeeds::create($validated);

        return response()->json(['message' => 'Therapy needs saved successfully!']);
    }

    public function getProgress()
    {
        // Fetch progress data for a specific patient (pseudo-code)
        // $progress = TherapyProgress::all();

        // Return as JSON for dynamic rendering
        return response()->json($progress);
    }

    // Add the showDashboard method here
    public function showDashboard()
    {
        $staff_id = auth()->user()->id;
        $fullname = auth()->user()->fullname; // Fetch the fullname attribute

        // Check if fullname is already an object
        if (is_object($fullname)) {
            $fullnameArray = (array) $fullname;
        } else {
            $fullnameArray = json_decode($fullname, true); // Decode the JSON string
        }

        // Concatenate the full name
        $doctorName = trim($fullnameArray['first_name'] . ' ' . ($fullnameArray['middle_name'] ?? '') . ' ' . $fullnameArray['last_name']);

        $cacheKey = 'recent_visits_' . $staff_id; // Make cache key unique per doctor

        // Attempt to retrieve visits from cache
        $visits = Cache::get($cacheKey);

        if (!$visits) {
            // Fetch last 20 visits from the database
            $visits = DB::table('visits')
                ->join('children', 'visits.child_id', '=', 'children.id')
                ->join('staff', 'visits.doctor_id', '=', 'staff.id')
                ->select(
                    'visits.created_at',
                    'children.registration_number',
                    'children.fullname',
                    'visits.completed'
                )
                ->where('visits.doctor_id', $staff_id) // Add this line to filter by logged-in doctor
                ->whereDate('visits.created_at', '=', now()->toDateString())
                ->where('visits.triage_pass', true)
                ->orderBy('visits.created_at', 'desc')
                ->limit(20)
                ->get();

            // Store in cache for 60 minutes
            Cache::put($cacheKey, $visits, now()->addMinutes(60));
        }

        return view('therapists.therapistsDashboard', compact('visits', 'doctorName'));
    }
}
