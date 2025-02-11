<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Child;
use App\Models\Children;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;


class InvoiceController extends Controller
{
    /**
     * Count today's visits for a child based on the registration number
     * and log the visit types with their associated prices and total amount,
     * then save to the database or update the existing record if it already exists.
     *
     * @param string $registrationNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function countVisitsForToday($registrationNumber)
    {
        Log::info('Received Registration Number: ' . $registrationNumber);
    
        // Fetch the child ID using the registration number
        $child = DB::table('children')
            ->where('registration_number', $registrationNumber)
            ->select('id')
            ->first();
    
        if (!$child) {
            return response()->json([
                'message' => 'Child not found',
                'count' => 0,
            ], 404);
        }
    
        // Get today's date
        $today = Carbon::now()->toDateString();
    
        // Fetch visits for today, including visit type, prices, copay amount, and payment mode
        $visits = DB::table('visits')
            ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
            ->join('payment_modes', 'visits.payment_mode_id', '=', 'payment_modes.id')
            ->where('visits.child_id', $child->id)
            ->whereDate('visits.visit_date', $today)
            ->select(
                'visit_type.visit_type as visit_type_name',
                'visit_type.sponsored_price',
                'visit_type.normal_price',
                'visits.payment_mode_id',
                'visits.copay_amount',
                'payment_modes.payment_mode as payment_method'
            )
            ->get();
    
        if ($visits->isEmpty()) {
            return response()->json([
                'message' => 'No visit for today',
            ], 200);
        }
    
        // Initialize invoice details
        $invoiceDetails = [];
    
        // Populate invoice details and calculate the total amount
        foreach ($visits as $visit) {
            $price = ($visit->payment_mode_id == 3) 
                ? $visit->sponsored_price 
                : $visit->normal_price;
    
            $invoiceDetails[$visit->visit_type_name] = [
                'price' => $price,
                'copay_amount' => !is_null($visit->copay_amount) ? $visit->copay_amount : 0
            ];
        }
    
        // Get the payment method (assume first visit's payment mode is used)
        $paymentMethod = $visits->first()->payment_method;
    
        // Calculate the total amount (excluding copay from the calculation)
        $totalAmount = array_sum(array_column($invoiceDetails, 'price'));
    
        // Check if an invoice already exists for today
        $existingInvoice = DB::table('invoices')
            ->where('child_id', $child->id)
            ->whereDate('invoice_date', $today)
            ->first();
    
        if ($existingInvoice) {
            // Update the existing invoice
            DB::table('invoices')
                ->where('id', $existingInvoice->id)
                ->update([
                    'invoice_details' => json_encode($invoiceDetails),
                    'total_amount' => $totalAmount,
                    'payment_method' => $paymentMethod,
                ]);
    
            return response()->json([
                'message' => 'Invoice updated successfully',
                'invoice_id' => $existingInvoice->id,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'invoice_details' => $invoiceDetails,
            ]);
        } else {
            // Insert a new invoice with `invoice_status = false`
            $invoiceId = DB::table('invoices')->insertGetId([
                'child_id' => $child->id,
                'invoice_details' => json_encode($invoiceDetails),
                'total_amount' => $totalAmount,
                'invoice_date' => $today,
                'invoice_status' => false, // Always set to false (or 0)
                'payment_method' => $paymentMethod,
            ]);
    
            return response()->json([
                'message' => 'Invoice generated successfully',
                'invoice_id' => $invoiceId,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'invoice_details' => $invoiceDetails,
            ]);
        }
    }
    

    
    public function getInvoices()
{
    $today = now()->format('Y-m-d');

    $invoices = DB::table('invoices')
        ->whereDate('invoice_date', $today)
        ->get();

    $invoicesWithNames = $invoices->map(function ($invoice) {
        $child = DB::table('children')->where('id', $invoice->child_id)->first();
        $fullName = json_decode($child->fullname);

        $invoice->patient_name = trim(($fullName->first_name ?? '') . ' ' . ($fullName->middle_name ?? '') . ' ' . ($fullName->last_name ?? ''));

        return $invoice;
    });
    log::info('Fetched Invoices Data:', ['invoices' => $invoicesWithNames]);

    return view('reception.invoice', ['invoices' => $invoicesWithNames]);
}

public function getInvoiceContent($invoiceId)
{
    // Fetch the invoice
    $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
    Log::info("Fetched Invoice:", ['invoice' => $invoice]);

    if (!$invoice) {
        Log::error("Invoice not found with ID: $invoiceId");
        return redirect()->back()->withErrors(['error' => 'Invoice not found.']);
    }

    // Get child details
    $child = DB::table('children')->where('id', $invoice->child_id)->first();
    Log::info("Fetched Child:", ['child' => $child]);

    $gender = DB::table('gender')->where('id', $child->gender_id)->first()->gender ?? 'Unknown';
    Log::info("Fetched Gender:", ['gender' => $gender]);

    // Decode child name
    $fullName = json_decode($child->fullname);
    Log::info("Decoded Full Name:", ['fullName' => $fullName]);

    $child->full_name = trim(($fullName->first_name ?? '') . ' ' . ($fullName->middle_name ?? '') . ' ' . ($fullName->last_name ?? ''));
    Log::info("Constructed Child Full Name:", ['full_name' => $child->full_name]);

    // Decode invoice details
    $invoice->invoice_details = json_decode($invoice->invoice_details, true);
    Log::info("Decoded Invoice Details:", ['invoice_details' => $invoice->invoice_details]);

    return view('reception.invoice-details', [
        'invoice' => $invoice,
        'child' => $child,
        'gender' => $gender,
    ]);
}

// Method to fetch invoice dates for a child
public function getInvoiceDates($childId)
{
    try {
        // Log the incoming request
        Log::info('Fetching invoices for child ID: ' . $childId);
        
        // Validate child exists
        $child = Children::findOrFail($childId);
        Log::info('Found child:', ['child_id' => $child->id]);
        
        // Get invoice dates
        $dates = Invoice::getInvoicesByChild($childId);
        Log::info('Found invoice dates:', ['dates' => $dates->toArray()]);
        
        // Return empty array if no dates found
        if ($dates->isEmpty()) {
            return response()->json([]);
        }
        
        return response()->json($dates);
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Child not found: ' . $childId);
        return response()->json(['error' => 'Child not found'], 404);
        
    } catch (\Exception $e) {
        Log::error('Error fetching invoice dates:', [
            'child_id' => $childId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
public function getInvoiceDetails($childId)
{
    try {
        $date = request()->get('date');
        
        // Validate child exists
        $child = Child::find($childId);
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }
        
        $invoice = Invoice::where('child_id', $childId)
            ->whereDate('invoice_date', $date)
            ->first();
            
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }
        
        return response()->json($invoice);
    } catch (\Exception $e) {
        Log::error('Error fetching invoice details: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
}




  
