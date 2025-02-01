<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Appointments;
use App\Models\children;
use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $dashboard = new stdClass();
        $dashboard->appointments = Appointments::whereDate('appointment_date',Carbon::today())->get();

        $dashboard->totalAppointments = Appointments::count();
        $dashboard->ongoingAppointments = Appointments::where('status','ongoing')->count();
        $dashboard->pendingAppointments = Appointments::where('status','pending')->count();
        $dashboard->rejectedAppointments = Appointments::where('status','rejected')->count();

        $dashboard->activeUsers = User::getActiveUsers();
        return view('reception.dashboard', compact('dashboard'));
    }

    public function search($id = null)
    {
        $children = $id ? children::where('id', $id)->get() : null;
        return view('reception.visits', compact('children'));
    }

    public function calendar()
    {
        $doctorSpecializations = Specialization::all();
        return view('reception.reception_calendar', compact('doctorSpecializations'));
    }
}
