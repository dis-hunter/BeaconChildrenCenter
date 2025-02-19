<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Appointments;
use App\Models\children;
use App\Models\Parents;
use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use stdClass;

class ReceptionController extends Controller
{
    public function dashboard(): View
    {
        // Initial load just returns the view with minimal data
        return view('reception.dashboard');
    }

    public function getAppointmentStats(): JsonResponse
    {
        $appointmentStats = Appointments::whereDate('appointment_date', Carbon::today())
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'ongoing' THEN 1 ELSE 0 END) as ongoing,
                SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as success,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            ")->first();

        return response()->json([
            'totalAppointments' => $appointmentStats->total ?? '-',
            'ongoingAppointments' => $appointmentStats->ongoing ?? '-',
            'pendingAppointments' => $appointmentStats->pending ?? '-',
            'rejectedAppointments' => $appointmentStats->rejected ?? '-',
            'successfulAppointments' => $appointmentStats->success ?? '-',
        ]);
    }

    public function getTodayAppointments(): JsonResponse
    {
        $appointments = Appointments::whereDate('appointment_date', Carbon::today())->get();

        return response()->json([
            'appointments' => $appointments
        ]);
    }

    public function getActiveUsers() : JsonResponse
    {
        return response()->json([
            'activeUsers' => User::getActiveUsers()
        ]);
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

    public function finishAppointment($id = null)
    {
        if (!$id) {
            return redirect()->back();
        }

        $appointment = Appointments::where('child_id', $id)
            ->whereDate('appointment_date', Carbon::today())
            ->first();

        if (!$appointment) {
            return redirect()->back();
        }
        $appointment->update(['status' => 'success']);

        return redirect()->route('patients.search', ['id' => $id]);
    }

}
