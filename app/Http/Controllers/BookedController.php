<?php

// app/Http/Controllers/AppointmentController.php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Staff;  // Assuming your staff model is named "Staff"
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookedController extends Controller
{
    public function getTodaysAppointments()
{
    // Get the logged-in doctor's staff_id
    $doctor = Auth::user(); // Assuming the logged-in user is the doctor
    $staff_id = $doctor->id;

    // Get today's date
    $today = Carbon::today()->toDateString();

    // Fetch today's appointments for the logged-in doctor
    $appointments = Appointment::where('staff_id', $staff_id)
        ->whereDate('appointment_date', $today) // Filter appointments by today’s date
        ->get();

    // Map appointments with child name and appointment times
    $appointmentsWithChildNames = $appointments->map(function ($appointment) {
        // Get child's name from the children table
        $child = Child::find($appointment->child_id); // Assuming child_id exists in the appointment table

        return [
            'appointment_start_time' => $appointment->start_time,
            'appointment_end_time' => $appointment->end_time,
            'child_name' => $child ? implode(' ', json_decode($child->fullname)) : 'Unknown Child'
        ];
    });

    return view('doctorDash', compact('appointmentsWithChildNames'));
}


}
