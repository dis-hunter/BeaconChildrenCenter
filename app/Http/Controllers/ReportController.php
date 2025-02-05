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
    
        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];
    
        // Log the validated data
        Log::info('Validated request data for encounter summary report', [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    
        // Eager load child, staff, and invoice relationships, reducing query complexity
        $visits = Visits::whereBetween('visit_date', [$startDate, $endDate])
            ->with(['child:id,fullname', 'staff:id,fullname'])  // No need to eager load invoice here, we handle it separately
            ->get();
    
        // Process visits and format encounters data
        $encounters = $visits->map(function ($visit) {
            // Get the corresponding invoice based on child_id and visit_date
            $invoice = Invoice::where('child_id', $visit->child_id)
                ->where('invoice_date', $visit->visit_date)
                ->first();
    
            // Format the encounter data
            return [
                'date' => $visit->visit_date,
                'child_name' => $this->formatChildFullname($visit->child->fullname ?? null),
                'specialist_name' => $this->formatStaffFullname($visit->staff),
                'invoice_id' => $invoice ? $invoice->id : 'N/A',  // If invoice exists, fetch its id; otherwise, return 'N/A'
            ];
        })->toArray();  // Convert collection to array
    
        // Log the number of encounters processed
        Log::info('Encounter summary generated', [
            'encounter_count' => count($encounters)
        ]);
    
        // Return the response with the encounters data
        return response()->json([
            'success' => true,
            'encounters' => $encounters,
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


    //Staff Perfomance
    public function generateStaffPerformance(Request $request)
    {
        try {
            Log::info('Generating Staff Performance Report', $request->all());
    
            // Validate input
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
    
            $startDate = $validated['start_date'];
            $endDate = $validated['end_date'];
    
            // Optimize the query by selecting only required fields and reducing the data loaded
            $visits = Visits::whereBetween('visit_date', [$startDate, $endDate])
                ->selectRaw('visit_date, staff_id, visit_type, COUNT(*) as sessions')
                ->groupBy('visit_date', 'staff_id', 'visit_type')
                ->get();  // No eager loading here
    
            Log::info('Fetched Visits Data:', ['visits_count' => $visits->count()]);
    
            // Perform the mapping and formatting
            $performance = $visits->map(function ($visit) {
                // Format the data directly here, instead of doing extra work later
                return [
                    'date' => $visit->visit_date,
                    'staff_name' => $this->formatSpecialistFullname($visit->staff->fullname ?? 'N/A'),
                    'service' => $visit->visitType->visit_type ?? 'Unknown',
                    'number_of_sessions' => $visit->sessions,
                ];
            });
    
            Log::info('Generated Performance Data:', ['performance_count' => $performance->count()]);
    
            // Return the performance data
            return response()->json([
                'success' => true,
                'performance' => $performance,
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating staff performance report: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
/**
 * Format the staff fullname correctly.
 *
 * @param mixed $fullname
 * @return string
 */
private function formatSpecialistFullname($fullname)
{
    // If the staff fullname is an object (stdClass), format it correctly
    if (is_object($fullname)) {
        $firstName = $fullname->first_name ?? '';
        $middleName = $fullname->middle_name ?? '';
        $lastName = $fullname->last_name ?? '';
        return trim($firstName . ' ' . $middleName . ' ' . $lastName);
    }
    
    // If fullname is a JSON string, decode and format it
    if (is_string($fullname)) {
        $decodedName = json_decode($fullname, true);
        if (is_array($decodedName)) {
            $firstName = $decodedName['first_name'] ?? '';
            $middleName = $decodedName['middle_name'] ?? '';
            $lastName = $decodedName['last_name'] ?? '';
            return trim($firstName . ' ' . $middleName . ' ' . $lastName);
        }
    }

    return 'N/A';
}



}
