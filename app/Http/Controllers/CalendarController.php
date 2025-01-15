<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Ensure this line is at the top
use App\Models\DoctorSpecialization;  // Ensure this is correctly imported

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Child; // Assuming you have a Child model
use App\Models\Staff; // Assuming you have a Staff model

class CalendarController extends Controller
{

    // Show the form to create a new appointment
    public function create()
    {
        // Fetch doctor specializations from the database
        $doctorSpecializations = DoctorSpecialization::all();

        // Pass the specializations to the view
        return view('calendar', ['doctorSpecializations' => $doctorSpecializations]);

    }

    public function showDoctorDashboard()
{
    $doctorSpecializations = DoctorSpecialization::all();
    return view('doctorDash', ['doctorSpecializations' => $doctorSpecializations]);
}

public function showTherapistDashboard()
{
    $doctorSpecializations = DoctorSpecialization::all();
    return view('/therapist/therapistDashboard', ['doctorSpecializations' => $doctorSpecializations]);
}
    




    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'event_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'event_time_from' => 'required|date_format:H:i',
            'event_time_end' => 'required|date_format:H:i|after:event_time_from',
            'service' => 'required|string|max:255',
            'specialist' => 'required|string|max:255',
        ]);

        // Retrieve child_id based on patient details
        $child = children::where('name', $request->input('patient_name'))
            ->where('contact', $request->input('patient_contact'))
            ->where('email', $request->input('patient_email'))
            ->first();

        if (!$child) {
            return back()->withErrors(['error' => 'Child not found in the database.']);
        }

        // Retrieve staff_id based on specialist
        $staff = staff::where('name', $request->input('specialist'))->first();

        if (!$staff) {
            return back()->withErrors(['error' => 'Staff not found in the database.']);
        }

        // Check for overlapping appointments for the same staff_id
        $overlappingAppointment = appointments::where('staff_id', $staff->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->event_time_from, $request->event_time_end])
                      ->orWhereBetween('end_time', [$request->event_time_from, $request->event_time_end])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_time', '<=', $request->event_time_from)
                                ->where('end_time', '>=', $request->event_time_end);
                      });
            })
            ->exists();

        if ($overlappingAppointment) {
            return back()->withErrors(['error' => 'This time slot is already booked for the selected staff member.']);
        }

        // Create a new appointment
        appointments::create([
            'appointment_title' => $request->input('event_name'),
            'appointment_date' => now()->toDateString(),
            'start_time' => $request->input('event_time_from'),
            'end_time' => $request->input('event_time_end'),
            'status' => 'pending',
            'child_id' => $child->id,
            'staff_id' => $staff->id,
        ]);

        return back()->with('success', 'Appointment created successfully.');
    }
}
