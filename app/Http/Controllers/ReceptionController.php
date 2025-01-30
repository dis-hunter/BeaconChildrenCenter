<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\children;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;
use Carbon\Carbon;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $dashboard = new \stdClass();
        
        // Fetch only today's appointments
        $dashboard->appointments = appointments::whereDate('appointment_date', Carbon::today())->get();

        // Default values for counts (ensuring zero if no records exist)
        $dashboard->totalAppointments = $dashboard->appointments->count() ;
        $dashboard->pendingAppointments = $dashboard->appointments->where('status', 'pending')->count();
        $dashboard->ongoingAppointments = $dashboard->appointments->where('status', 'on-going')->count() ?? 0;
        $dashboard->rejectedAppointments = $dashboard->appointments->where('status', 'rejected')->count() ?? 0;

        // Fetch active users
        $dashboard->activeUsers = User::getActiveUsers();
        
        return view('reception.dashboard', compact('dashboard'));
    }

    public function search($id = null)
    {
        $children = $id ? children::where('id',$id)->get() : null;
        return view('reception.visits', compact('children'));
    }

    public function calendar()
{
    return view('reception.reception_calendar'); // Path to your Blade file
}

}
