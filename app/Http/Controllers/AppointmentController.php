<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorSpecialization; // Add the correct model here
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Appointments;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

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

    // Extract validated inputs
    $appointmentDate = $validatedData['appointment_date'];
    $startTime = $validatedData['start_time'];
    $endTime = $validatedData['end_time'];
    $staffId = $validatedData['staff_id'];
    $doctorId = $validatedData['doctor_id'];
    $appointmentTitle = $validatedData['appointment_title'];
    $childId = $validatedData['child_id'];
    $status = $validatedData['status'];

    // Check if the daily limit for the doctor is reached
    $doctorAppointmentCount = Appointment::where('staff_id', $staffId)
        ->where('appointment_date', $appointmentDate)
        ->count();

    $dailyLimit = 10; // You can adjust this dynamically
    if ($doctorAppointmentCount >= $dailyLimit) {
        return response()->json([
            'success' => false,
            'message' => 'Maximum booking limit reached for this doctor on this day.',
        ]);
    }

    // Check if the doctor is booked during the requested time
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
        return response()->json([
            'success' => false,
            'message' => 'This doctor is already booked during the selected time. Please choose another time or date.',
        ]);
    }

    // Check if the child has overlapping appointments
    $childBookingConflict = Appointment::where('child_id', $childId)
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

    if ($childBookingConflict) {
        return response()->json([
            'success' => false,
            'message' => 'The child is already booked for an appointment for the given time and date, kindly check the booked appointment records.',
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
    $appointment->doctor_id = $doctorId;
    $appointment->save();

    // Return success response
    return response()->json([
        'success' => true,
        'message' => 'Appointment created successfully',
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

    public function therapistAppointments()
{
    $today = Carbon::today()->toDateString();
    $therapistSpecializations = DoctorSpecialization::whereIn('specialization', [
        'Speech Therapy', 'Occupational Therapy', 'Physiotherapy', 'ABA', 'Nutrition'
    ])->pluck('id');

    $appointments = Appointment::join('staff', 'appointments.staff_id', '=', 'staff.id')
    ->whereIn('staff.specialization_id', $therapistSpecializations)
    ->where('appointments.appointment_date', $today)
    ->join('doctor_specialization', 'staff.specialization_id', '=', 'doctor_specialization.id')
    ->join('children', 'appointments.child_id', '=', 'children.id') 
    ->select(
        'appointments.id',
        DB::raw("CONCAT(children.fullname->>'first_name', ' ', children.fullname->>'middle_name', ' ', children.fullname->>'last_name') as child_name"), 
        'appointments.doctor_id',
        'staff.fullname as staff_name',
        'doctor_specialization.specialization',
        'appointments.appointment_date',
        'appointments.start_time',
        'appointments.end_time'
    )
    ->get();

return response()->json($appointments);
}


public function index()
{
    return view('calendar'); // Make sure the path matches your actual view folder structure
}



}
