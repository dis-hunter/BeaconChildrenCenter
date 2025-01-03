<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'child_id' => 'required|exists:children,id',
            'doctor_id' => 'required|exists:staff,id',
            'visit_type' => 'required|integer',
        ]);

        // Assign values to the new appointment
        $appointment = new Appointments();
        $appointment->child_id = $validatedData['child_id']; // Retrieved from button click
        $appointment->doctor_id = $validatedData['doctor_id']; // Retrieved from doctor select
        $appointment->staff_id = 2; // Default staff ID
        $appointment->appointment_date = Carbon::now()->format('Y-m-d'); // Today's date
        $appointment->status = 'pending'; // Default status
        $appointment->created_at = Carbon::now(); // Current timestamp
        $appointment->updated_at = Carbon::now(); // Current timestamp
        $appointment->start_time = Carbon::now()->format('H:i:s'); // Current time
        $appointment->end_time = Carbon::now()->addHour()->format('H:i:s'); // Time after 1 hour
        $appointment->appointment_title = 'Default Title'; // Default title

        // Save the appointment to the database
        $appointment->save();

        // Redirect with success message
        return redirect()->back()->with('success', 'Appointment successfully created!');
    }
}
