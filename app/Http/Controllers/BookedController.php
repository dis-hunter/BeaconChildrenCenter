<?php

// app/Http/Controllers/AppointmentController.php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Staff;  // Assuming your staff model is named "Staff"
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookedController extends Controller
{
    public function getBookedPatients(Request $request)
    {
        // Get the search term
        $searchTerm = $request->input('search', '');

        // Search for the doctor in the staff table based on the search term (name or telephone)
        $doctor = Staff::where(function ($query) use ($searchTerm) {
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(fullname, '$.first_name')) LIKE ?", ['%' . $searchTerm . '%'])
                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(fullname, '$.middle_name')) LIKE ?", ['%' . $searchTerm . '%'])
                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(fullname, '$.last_name')) LIKE ?", ['%' . $searchTerm . '%'])
                ->orWhere('telephone', 'like', '%' . $searchTerm . '%');
        })->first(); // Get the first doctor matching the search term

        // If no doctor is found, return an error message
        if (!$doctor) {
            return view('doctorDash', ['error' => 'Doctor not found']);
        }

        // Get the doctor's staff_id
        $staff_id = $doctor->id;

        // Get today's date
        $today = Carbon::today()->toDateString();

        // Retrieve appointments for the doctor using the staff_id and today's date
        $appointments = Appointment::with(['child.parent']) // Eager load child and parent relationships
            ->where('staff_id', $staff_id)  // Get appointments for this doctor based on staff_id
            ->whereDate('appointment_date', $today)  // Filter by today's date
            ->get();

        // Return the appointments view
        return view('doctorDash', compact('appointments', 'doctor'));
    }

}
