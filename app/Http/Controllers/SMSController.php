<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    public function sendAppointmentReminder($phone, $childName, $doctorName, $appointmentDate)
    {
        // Africa's Talking API credentials
        $username = env('AT_USERNAME'); // Your Africa’s Talking username
        $apiKey = env('AT_API_KEY'); // Your Africa’s Talking API Key

        // Message content
        $message = "Reminder: Your child, $childName, has an appointment with Dr. $doctorName on $appointmentDate.";

        // Log the message before sending
        Log::info("Sending SMS to: $phone | Message: $message");

        try {
            // Make the HTTP POST request with correct parameter names
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'apiKey' => $apiKey,
            ])->post('https://api.africastalking.com/version1/messaging/bulk', [
                'username' => $username,
                'phoneNumbers' => [$phone], // ✅ Ensure phone numbers are in an array
                'message' => $message,
                'enqueue' => true,
            ]);

            // Decode JSON response
            $responseData = $response->json();

            // Ensure the response is an array before logging
            if (!is_array($responseData)) {
                $responseData = ['error' => 'Invalid response format', 'raw' => $response->body()];
            }

            // Log the response from Africa's Talking
            Log::info("SMS API Response: ", $responseData);

            return response()->json([
                'message' => 'SMS Sent Successfully',
                'response' => $responseData
            ]);
        } catch (\Exception $e) {
            // Log any error
            Log::error("SMS Sending Failed: " . $e->getMessage());
            return response()->json(['error' => 'SMS Sending Failed: ' . $e->getMessage()]);
        }
    }
}

