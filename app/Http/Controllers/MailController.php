<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentReminderMail;
use App\Models\Appointment;
use App\Models\Staff;
use App\Models\Children;
use App\Models\ChildParent;
use App\Models\Parents;
use Carbon\Carbon;

class MailController extends Controller
{
    public function sendReminder()
    {


        // Get current date and calculate 3 days from now
        $targetDate = Carbon::now()->addDays(3)->toDateString();


        // Fetch appointments that are due in 3 days or less
        $appointments = Appointment::whereBetween('appointment_date', [Carbon::now()->toDateString(), $targetDate])->get();


        if ($appointments->isEmpty()) {
            Log::info('No appointments to send reminders for.');
            return response()->json(['message' => 'No reminders to send.']);
        }

        foreach ($appointments as $appointment) {
            try {

                // Fetch child details
                $child = Children::find($appointment->child_id);
                if (!$child) {
                    Log::warning("⚠️ No child found for child_id: " . $appointment->child_id);
                    continue;
                }

                // Handle fullname as object or string
                $childName = $this->extractFullName($child->fullname);

                // Fetch doctor details
                $doctor = Staff::find($appointment->doctor_id);
                if (!$doctor) {
                    Log::warning("⚠️ No doctor found for doctor_id: " . $appointment->doctor_id);
                    continue;
                }

                // Handle doctor fullname as object or string
                $doctorName = $this->extractFullName($doctor->fullname);


                // Fetch parent details
                $childParent = ChildParent::where('child_id', $appointment->child_id)->first();
                if (!$childParent) {
                    Log::warning("⚠️ No parent found for child_id: " . $appointment->child_id);
                    continue;
                }

                $parent = Parents::find($childParent->parent_id);
                if (!$parent) {
                    Log::warning("⚠️ No parent details found for parent_id: " . $childParent->parent_id);
                    continue;
                }
                $parentEmail = $parent->email;


                // Send the reminder email

                Mail::to($parentEmail)->send(new AppointmentReminderMail($childName, $doctorName, $appointment->appointment_date));

                Log::info('Appointment Reminder Email sent to ' . $parentEmail);


            } catch (\Exception $e) {
                Log::error("❌ Error processing appointment ID " . $appointment->id . ": " . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Reminder emails sent successfully.']);
    }

    /**
     * Extracts full name whether stored as an object or a string
     */
    private function extractFullName($fullname)
    {
        if (is_object($fullname)) {
            return "{$fullname->first_name} {$fullname->last_name}";
        }

        if (is_string($fullname)) {
            $decoded = json_decode($fullname, true);
            if (is_array($decoded) && isset($decoded['first_name'], $decoded['last_name'])) {
                return "{$decoded['first_name']} {$decoded['last_name']}";
            }
            return $fullname; // Return raw string if JSON decode fails
        }

        return "Unknown Name";
    }
}
