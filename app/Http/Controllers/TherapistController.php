<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $visits = DB::table('visits')
            ->join('children', 'visits.child_id', '=', 'children.id')
            ->join('staff', 'visits.staff_id', '=', 'staff.id')
            ->select(
                'visits.id as visit_id',
                'visits.visit_date',
                'visits.created_at',
                'children.id as child_id',
                'children.registration_number',
                'children.fullname',
                'children.dob',
                'staff.id as staff_id',
                'staff.specialization_id'
            )
            ->whereDate('visits.created_at', '=', now()->toDateString())  // Filter by today's date
            ->orderBy('visits.created_at')
            ->get();
    
        return view('therapists.therapistsDashboard', compact('visits'));
    }
}    
