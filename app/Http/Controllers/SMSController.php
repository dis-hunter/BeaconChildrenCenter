<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use App\Models\Staff;
use App\Models\Children;
use App\Models\ChildParent;
use App\Models\Parents;
use Carbon\Carbon;

class SMSController extends Controller
{
    public function sendReminder()
    {
        Log::info("⏳ Fetching appointments for SMS reminders...");
    
        // Get appointments for tomorrow
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');
    
        $appointments = Appointment::whereDate('appointment_date', $tomorrow)->get();
    
        if ($appointments->isEmpty()) {
            Log::info("✅ No appointments for tomorrow.");
            return response()->json(['message' => 'No SMS reminders to send.']);
        }
    
        foreach ($appointments as $appointment) {
            try {
                // Fetch child details
                $child = Children::find($appointment->child_id);
                if (!$child) {
                    Log::warning("⚠️ No child found for child_id: " . $appointment->child_id);
                    continue;
                }
                $childName = $this->extractFullName($child->fullname);
    
                // Fetch doctor details
                $doctor = Staff::find($appointment->doctor_id);
                if (!$doctor) {
                    Log::warning("⚠️ No doctor found for doctor_id: " . $appointment->doctor_id);
                    continue;
                }
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
    
                // ✅ Get parent's full name
                $parentName = $this->extractFullName($parent->fullname);
                $phone = $parent->telephone ?? '0740034499'; // ✅ Default phone
    
                // ✅ Get appointment times
                $startTime = $appointment->start_time ?? '00:00:00';
                $endTime = $appointment->end_time ?? '00:00:00';
    
                // ✅ Send SMS with time details
                $this->sendSms($phone, $parentName, $childName, $doctorName, $appointment->appointment_date, $startTime, $endTime);
            } catch (\Exception $e) {
                Log::error("❌ Error processing appointment ID " . $appointment->id . ": " . $e->getMessage());
            }
        }
    
        return response()->json(['message' => 'SMS reminders sent successfully.']);
    }
    


private function sendSms($phone, $parentName, $childName, $doctorName, $appointmentDate, $startTime, $endTime)
{
    $username = env('AT_USERNAME');
    $apiKey = env('AT_API_KEY');

    $formattedDate = Carbon::parse($appointmentDate)->format('l, d M Y');
    $formattedStartTime = Carbon::parse($startTime)->format('h:i A'); // Convert to 12-hour format
    $formattedEndTime = Carbon::parse($endTime)->format('h:i A'); // Convert to 12-hour format

    // ✅ Improved friendly message
    $message = "Hello $parentName, \n\n"
             . "This is a reminder from Beacon Children Center - Kiambu.\n\n"
             . "Your child, $childName, has an appointment with Dr. $doctorName\n"
             . "on $formattedDate from $formattedStartTime to $formattedEndTime.\n\n"
             . "Thank you.";

    Log::info("📩 Sending SMS to: $phone | Message: $message");

    try {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'apiKey' => $apiKey,
        ])->post('https://api.africastalking.com/version1/messaging/bulk', [
            'username' => $username,
            'phoneNumbers' => [$phone], // ✅ Ensure phone numbers are in an array
            'message' => $message,
            'enqueue' => true,
        ]);

        Log::info("📩 Full API Response: " . json_encode($response->json()));

        if ($response->failed()) {
            Log::error("❌ API Request Failed: " . json_encode($response->json()));
        }

    } catch (\Exception $e) {
        Log::error("❌ SMS Sending Failed: " . $e->getMessage());
    }
}



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
            return $fullname;
        }

        return "Unknown Name";
    }
}
