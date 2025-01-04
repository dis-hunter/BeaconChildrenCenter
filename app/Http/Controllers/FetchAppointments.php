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
        // Get the date from the query parameter
        $date = $request->input('date');
        
        // Fetch appointments for the given date with related parent details
        $appointments = Appointment::join('child_parent', 'appointments.child_id', '=', 'child_parent.child_id')
            ->join('parents', 'child_parent.parent_id', '=', 'parents.id')
            ->select(
                'appointments.id as appointmentId',
                'appointments.appointment_date',
                'appointments.start_time',
                'appointments.end_time',
                'appointments.appointment_title',
                'parents.fullname as parent_name',
                'parents.telephone as parent_phone',
                'parents.email as parent_email'
            )
            ->where('appointments.appointment_date', $date)
            ->get();


        // Return as JSON

        Log::info("Fetched appointments:", ['appointments' => $appointments]);
        return response()->json($appointments);
    }
}
