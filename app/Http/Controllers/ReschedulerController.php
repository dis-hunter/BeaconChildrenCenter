<?php

namespace App\Http\Controllers;



use App\Models\Appointment; // Import the Appointment model

use Illuminate\Support\Facades\DB; // Ensure this line is at the top
use Illuminate\Http\Request;

class ReschedulerController extends Controller
{
    //

    public function cancelAppointment($id) {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->delete(); // Delete the appointment
            return response()->json(['message' => 'Appointment canceled successfully.'], 200);
        } else {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }
    }
    public function reschedule(Request $request, $id)
{
    $request->validate([
        'new_date' => 'required|date', // Validate the new date
    ]);

    $appointment = Appointment::findOrFail($id);
    $appointment->date = $request->new_date; // Update the date
    $appointment->save();

    return response()->json(['message' => 'Appointment rescheduled successfully.']);

}
}
