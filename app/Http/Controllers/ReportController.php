<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visits;
use App\Models\Children;
use App\Models\Staff;
use App\Models\Invoice;



class ReportController extends Controller
{
   

    public function generateEncounterSummary(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|string|in:encounter_summary',
        ]);
    
        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];
    
        // Fetch visits within the date range
        $visits = Visits::whereBetween('visit_date', [$startDate, $endDate])
            ->with(['child:id,fullname', 'staff:id,fullname'])
            ->get();
    
        // Group invoices by child_id and date (without time)
        $invoices = Invoice::whereBetween('invoice_date', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($invoice) {
                return $invoice->child_id . '_' . \Carbon\Carbon::parse($invoice->invoice_date)->toDateString();
            });
    
    
        // Process visits and match them to invoices
        $encounters = $visits->map(function ($visit) use ($invoices) {
            $visitDate = \Carbon\Carbon::parse($visit->visit_date)->toDateString();
            $invoiceKey = $visit->child_id . '_' . $visitDate;
    
            // Find the invoice for this visit
            $invoice = $invoices->get($invoiceKey)?->first();
    
    
            return [
                'date' => $visitDate,
                'child_name' => $this->formatChildFullname($visit->child->fullname ?? null),
                'specialist_name' => $this->formatStaffFullname($visit->staff),
                'invoice_id' => $invoice ? $invoice->id : 'N/A',
            ];
        })->toArray();
    
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
