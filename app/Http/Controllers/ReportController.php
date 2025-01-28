<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visits;
use App\Models\Children;
use App\Models\Staff;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function generateEncounterSummary(Request $request)
    {
        // Log the incoming request data
        Log::info('Received request for generating encounter summary', [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
    
        // Validate incoming request
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:encounter_summary,financial_summary,expenses_breakdown,revenue_breakdown,staff_performance',
        ]);
    
        // Extract validated data
        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];
    
        // Log the validated data
        Log::info('Validated request data for encounter summary report', [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    
        // Query the encounters and process them into an array
        $encounters = Visits::whereBetween('visit_date', [$startDate, $endDate])
            ->get()
            ->map(function ($visit) use ($startDate, $endDate) {
                // Retrieve related child, staff, and invoice information
                $child = Children::find($visit->child_id);
                $staff = Staff::find($visit->doctor_id);
                $invoice = Invoice::where('child_id', $visit->child_id)
                    ->where('invoice_date', $visit->visit_date)
                    ->first();
    
                // Log each encounter processing step with staff object logging
                Log::info('Processing encounter', [
                    'visit_date' => $visit->visit_date,
                    'child_id' => $visit->child_id,
                    'doctor_id' => $visit->doctor_id,
                    'child_fullname' => $child ? $this->formatChildFullname($child->fullname) : 'N/A',
                    'staff_object' => $staff ? $staff->toArray() : 'N/A', // Log staff as an array if available
                    'specialist_fullname' => $staff ? $this->formatStaffFullname($staff) : 'N/A',
                ]);
    
                // Process and format child name
                $formattedChildName = $this->formatChildFullname($child ? $child->fullname : null);
                
                // Process and format specialist (doctor) name
                $formattedStaffName = $this->formatStaffFullname($staff);
    
                // Handle invoice ID
                $invoiceId = $invoice ? $invoice->id : 'N/A';
    
                // Return the encounter as an array
                return [
                    'date' => $visit->visit_date,
                    'child_name' => $formattedChildName,
                    'specialist_name' => $formattedStaffName,
                    'invoice_id' => $invoiceId,
                ];
            })
            ->toArray();  // Convert the collection to an array here
    
        // Log the number of encounters processed
        Log::info('Encounter summary generated', [
            'encounter_count' => count($encounters)  // Using count function to get the number of encounters
        ]);
    
        // Log the response data being sent back to the view
        Log::info('Sending response for encounter summary', [
            'success' => true,
            'encounters' => $encounters,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    
        // Return the response with the encounters data in the desired format
        return response()->json([
            'success' => true,
            'encounters' => $encounters,  // Encounters will be an array of associative arrays
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }
    
    // Helper method to format names, added check to ensure only strings are processed
    private function formatFullname($fullname)
    {
        if (is_string($fullname)) {
            return ucfirst(strtolower($fullname));
        }
        return 'N/A';
    }
    
    // Helper method to format child's full name (if applicable)
    private function formatChildFullname($fullname)
    {
        // If the child fullname is an object (stdClass), format it correctly
        if (is_object($fullname)) {
            $firstName = $fullname->first_name ?? '';
            $middleName = $fullname->middle_name ?? '';
            $lastName = $fullname->last_name ?? '';
            return trim($firstName . ' ' . $middleName . ' ' . $lastName);
        }
        return 'N/A';
    }

    // Helper method to format specialist (staff) full name correctly
    private function formatStaffFullname($staff)
    {
        if ($staff && $staff->fullname) {
            // Log the raw fullname before decoding
            Log::info('Raw staff fullname:', ['fullname' => $staff->fullname]);

            // Decode the specialist_fullname string to access first_name, middle_name, last_name
            $specialistName = json_decode($staff->fullname);
            if ($specialistName) {
                // Log the decoded specialist name object
                Log::info('Decoded staff fullname:', ['specialistName' => $specialistName]);

                return ucfirst(strtolower($specialistName->first_name . ' ' . $specialistName->middle_name . ' ' . $specialistName->last_name));
            }
            return 'N/A';
        }
        return 'N/A';
    }
}
