<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    public function getAppointments()
    {
        // Fetch all appointments with related parent details
        $appointments = Appointment::join('child_parent', 'appointments.child_id', '=', 'child_parent.child_id')
            ->join('parents', 'child_parent.parent_id', '=', 'parents.id')
            ->select(
                'appointments.appointment_date',
                'appointments.start_time',
                'appointments.end_time',
                'appointments.appointment_title',
                'parents.fullname as parent_name',
                'parents.telephone as parent_phone',
                'parents.email as parent_email'
            )
            ->get();

        // Return as JSON
        return response()->json($appointments);
    }
}
