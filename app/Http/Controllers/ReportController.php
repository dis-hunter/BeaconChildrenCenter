<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visits;
use App\Models\Children;
use App\Models\Staff;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;




class ReportController extends Controller
{
   

    public function generateEncounterSummary(Request $request)
    {
        // Log the incoming request
        Log::info('Fetching encounter summary with request data:', $request->all());
    
        try {
            // Validate the request
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'report_type' => 'required|string|in:encounter_summary',
            ]);
    
            // Convert dates to Carbon instances
            $startDate = Carbon::parse($validated['start_date'])->startOfDay();
            $endDate = Carbon::parse($validated['end_date'])->endOfDay();
    
            // Log the date range
            Log::info("Fetching encounters from {$startDate} to {$endDate}");
    
            // Fetch visits
            $visits = Visits::whereBetween('visit_date', [$startDate, $endDate])
                ->with(['child:id,fullname', 'staff:id,fullname'])
                ->get();
    
            if ($visits->isEmpty()) {
                Log::warning("No visits found between {$startDate} and {$endDate}");
            } else {
                Log::info(count($visits) . " visits found.");
            }
    
            // Fetch invoices
            $invoices = Invoice::whereBetween('invoice_date', [$startDate, $endDate])
                ->get()
                ->groupBy(function ($invoice) {
                    return $invoice->child_id . '_' . Carbon::parse($invoice->invoice_date)->toDateString();
                });
    
            // Map encounters
            $encounters = $visits->map(function ($visit) use ($invoices) {
                $visitDate = Carbon::parse($visit->visit_date)->toDateString();
                $invoiceKey = $visit->child_id . '_' . $visitDate;
    
                $invoice = $invoices->get($invoiceKey)?->first();
    
                return [
                    'date' => $visitDate,
                    'child_name' => $this->formatChildFullname($visit->child->fullname ?? 'N/A'),
                    'specialist_name' => $this->formatStaffFullname($visit->staff),
                    'invoice_id' => $invoice ? $invoice->id : 'N/A',
                ];
            })->toArray();
    
            // Log the response
            Log::info('Encounter summary response:', $encounters);
    
            // Return response
            return response()->json([
                'success' => true,
                'message' => 'Encounter summary retrieved successfully',
                'encounters' => $encounters,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'report_type' => $validated['report_type'],
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation Error:', $e->errors());
    
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Error fetching encounters:', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching encounters',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
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
          

            // Decode the specialist_fullname string to access first_name, middle_name, last_name
            $specialistName = json_decode($staff->fullname);
            if ($specialistName) {
              

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
    
           
    
            // Return the performance data
            return response()->json([
                'success' => true,
                'performance' => $performance,
            ]);
        } catch (\Exception $e) {
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
