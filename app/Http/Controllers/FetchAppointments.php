<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\ChildParent;
use App\Models\ParentModel;

class FetchAppointments extends Controller
{
    public function getAppointments(Request $request)
{
    // Validate the date input to ensure it's in a valid format
    $validated = $request->validate([
        'date' => 'required|date_format:Y-m-d', // Ensure the date is in 'YYYY-MM-DD' format
    ]);
    
    // Get the date from the query parameter
    $date = $validated['date'];

    try {
        // Fetch appointments for the given date with related parent details
        $appointments = Appointment::leftJoin('child_parent', 'appointments.child_id', '=', 'child_parent.child_id')
            ->leftJoin('parents', 'child_parent.parent_id', '=', 'parents.id')
            ->leftJoin('staff', 'appointments.staff_id', '=', 'staff.id')
            ->leftJoin('children', 'appointments.child_id', '=', 'children.id')
            ->select(
                'appointments.id as appointmentId',
                'appointments.appointment_date',
                'appointments.start_time',
                'appointments.end_time',
                'appointments.appointment_title',
                'parents.fullname as parent_name',
                'parents.telephone as parent_phone',
                'parents.email as parent_email',
                'children.fullname as child_name',
                'staff.fullname as staff_name'
            )
            ->where('appointments.appointment_date', $date)
            ->get();

        // Log the fetched appointments for debugging
        Log::info("Fetched appointments for date: $date", ['appointments' => $appointments]);

        // Return as JSON
        return response()->json($appointments);

    } catch (\Exception $e) {
        // Log the error
        Log::error("Error fetching appointments for date: $date", ['error' => $e->getMessage()]);
        
        // Return a 500 error with the message
        return response()->json(['error' => 'An error occurred while fetching appointments.'], 500);
    }
}

}
