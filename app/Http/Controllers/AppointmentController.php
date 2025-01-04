<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorSpecialization; // Add the correct model here
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Store the appointment
    public function store(Request $request)
    {
        // Validate inputs
        $validatedData = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_title' => 'required|string',
            'child_id' => 'required|exists:children,id',
            'doctor_id' => 'required|integer',
            'end_time' => 'required|date_format:H:i',
            'staff_id' => 'required|exists:staff,id',
            'start_time' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);
    
        // Get the appointment details
        $appointmentDate = $validatedData['appointment_date'];
        $startTime = $validatedData['start_time'];
        $endTime = $validatedData['end_time'];
        $staffId = $validatedData['staff_id'];
        $doctor_id = $validatedData['doctor_id'];
        $appointmentTitle = $validatedData['appointment_title'];
        $childId = $validatedData['child_id'];
        $status = $validatedData['status'];
    
        // Check if the daily limit for this doctor is reached (assuming limit is 10)
        $doctorAppointmentCount = Appointment::where('staff_id', $staffId)
            ->where('appointment_date', $appointmentDate)
            ->count();
    
        $dailyLimit = 10; // You can adjust this if it's dynamic
    
        if ($doctorAppointmentCount >= $dailyLimit) {
            // Return a structured error response when the daily limit is reached
            return response()->json([
                'success' => false,
                'message' => 'Maximum booking limit reached for this doctor on this day.'
            ]);
        }
    
        // Check if the doctor is already booked during the selected time
        $doctorBookingConflict = Appointment::where('staff_id', $staffId)
            ->where('appointment_date', $appointmentDate)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();
    
        if ($doctorBookingConflict) {
            // Return a structured error response when there's a booking conflict
            return response()->json([
                'success' => false,
                'message' => 'This doctor is already booked during the selected time. Please choose another time or date.'
            ]);
        }
    
        // Create the appointment
        $appointment = new Appointment();
        $appointment->appointment_title = $appointmentTitle;
        $appointment->appointment_date = $appointmentDate;
        $appointment->start_time = $startTime;
        $appointment->end_time = $endTime;
        $appointment->staff_id = $staffId;
        $appointment->child_id = $childId;
        $appointment->status = $status;
        $appointment->doctor_id = $doctor_id;
        $appointment->save();
    
        // Optionally, send SMS or email notifications for the appointment
        // event(new AppointmentBooked($appointment));
    
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully'
        ]);
    }
    

    // Show the form to create a new appointment
    public function create()
    {
        return view('calendar'); // Adjust to your form view
    }

    // Create the appointment with initial date
    public function createAppointment()
    {
        $initialDate = date('Y-m-d');
        // Debugging to ensure it's passed
        dd($initialDate);
        return view('appointments.create', compact('initialDate'));
    }

    // Get doctors by specialization
    public function getDoctors($specialization_id)
    {
        // Log the received specialization_id to check if it's correct
        \Log::info('Received specialization_id: ' . $specialization_id);

        // Try fetching doctors from the database
        $doctors = DB::table('staff')
            ->join('doctor_specialization', 'staff.specialization_id', '=', 'doctor_specialization.id')
            ->where('doctor_specialization.id', $specialization_id)
            ->select(
                'staff.id',
                DB::raw("CONCAT(staff.fullname->>'first_name', ' ', staff.fullname->>'middle_name', ' ', staff.fullname->>'last_name') AS full_name")
            )
            ->get();

        // If no doctors found, log that as well
        if ($doctors->isEmpty()) {
            \Log::info('No doctors found for specialization_id: ' . $specialization_id);
            return response()->json(['message' => 'We currently don\'t have any specialists for this specialization.']);
        }

        return response()->json($doctors);
    }

    // Check doctor availability for a given date and time
    public function checkAvailability(Request $request)
    {
        $staffId = $request->doctor_id;  // Assuming doctor_id corresponds to staff_id in appointments
        $appointmentDate = $request->date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        // Check if the doctor is available for the selected time
        $isAvailable = Appointment::where('staff_id', $staffId)
            ->where('appointment_date', $appointmentDate)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->doesntExist();

        return response()->json(['available' => $isAvailable]);
    }

    // Show the form for appointment creation with a child_id from the query string
    public function create_2(Request $request)
    {
        $childId = $request->query('child_id', null);  // Get child_id from the URL query string
        return view('appointments.create', compact('childId'));
    }
}
