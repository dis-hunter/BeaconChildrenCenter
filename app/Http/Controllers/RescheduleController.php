<?php


namespace App\Http\Controllers;



use App\Models\Appointment; // Import the Appointment model

use Illuminate\Support\Facades\DB; // Ensure this line is at the top
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class RescheduleController extends Controller
{
    //

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
    public function rescheduleAppointment(Request $request)
    { try{
        // Validate the incoming data
        $validatedData = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'new_date' => 'required|date',
            'new_start_time' => 'required|date_format:H:i',
            'new_end_time' => 'required|date_format:H:i',
        ]);

        // Get the appointment to reschedule
        $appointment = Appointment::find($validatedData['appointment_id']);

        // Check if the doctor is available on the new date/time
        $doctorId = $appointment->staff_id;
        $newDate = $validatedData['new_date'];
        $newStartTime = $validatedData['new_start_time'];
        $newEndTime = $validatedData['new_end_time'];

        // Check if the doctor is already booked during the new time
        $doctorBookingConflict = Appointment::where('staff_id', $doctorId)
            ->where('appointment_date', $newDate)
            ->where(function ($query) use ($newStartTime, $newEndTime) {
                $query->whereBetween('start_time', [$newStartTime, $newEndTime])
                    ->orWhereBetween('end_time', [$newStartTime, $newEndTime])
                    ->orWhere(function ($query) use ($newStartTime, $newEndTime) {
                        $query->where('start_time', '<=', $newStartTime)
                            ->where('end_time', '>=', $newEndTime);
                    });
            })
            ->exists();

        if ($doctorBookingConflict) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor is already booked during the selected time.'
            ]);
        }

        // Check if the new time exceeds the doctor's daily limit
        $dailyLimit = 10; // Adjust based on the doctor's daily limit
        $doctorAppointmentCount = Appointment::where('staff_id', $doctorId)
            ->where('appointment_date', $newDate)
            ->count();

        if ($doctorAppointmentCount >= $dailyLimit) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor has reached the daily appointment limit for this date.'
            ]);
        }

        // Reschedule the appointment
        $appointment->appointment_date = $newDate;
        $appointment->start_time = $newStartTime;
        $appointment->end_time = $newEndTime;
        $appointment->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully rescheduled.'
        ]);
       } catch (\Exception $e) {
        Log::error('Error rescheduling appointment: ' . $e->getMessage(), [
            'appointmentId' => $appointmentId,
            'error' => $e->getTraceAsString()
        ]);
        return response()->json(['success' => false, 'message' => 'Error occurred while rescheduling.'], 500);
    }

    

}}  

