<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Fetch the child ID using the registration number directly from the database
        $child = DB::table('children')
            ->where('registration_number', $registrationNumber)
            ->select('id', 'fullname')
            ->first();

        if (!$child) {
            return response()->json([
                'message' => 'Child not found',
                'count' => 0,
            ], 404);
        }

        // Get today's date (without the time)
        $today = Carbon::now()->toDateString();

        // Fetch visits for today, including visit type and prices
        $visits = DB::table('visits')
            ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
            ->where('visits.child_id', $child->id)
            ->whereDate('visits.visit_date', $today)
            ->select(
                'visit_type.visit_type as visit_type_name',
                'visit_type.sponsored_price',
                'visit_type.normal_price',
                'visits.payment_mode_id'
            )
            ->get();

        // Initialize total amount and prepare invoice details
        $totalAmount = 0;
        $invoiceDetails = [];

        // Log the visit types with associated prices and calculate the total amount
        foreach ($visits as $visit) {
            $price = ($visit->payment_mode_id == 3) ? $visit->sponsored_price : $visit->normal_price;
            $invoiceDetails[$visit->visit_type_name] = $price; // Store visit type and price in invoice details
            logger("Visit Type: {$visit->visit_type_name}, Price: {$price}");
            $totalAmount += $price;
        }

        // Log the total amount
        logger("Total Amount: {$totalAmount}");

        // Check if an invoice already exists for today
        $existingInvoice = DB::table('invoices')
            ->where('child_id', $child->id)
            ->whereDate('invoice_date', $today) // Use `whereDate` for date comparison only
            ->first();

        if ($existingInvoice) {
            // Update the existing invoice
            DB::table('invoices')
                ->where('id', $existingInvoice->id)
                ->update([
                    'invoice_details' => json_encode($invoiceDetails),
                    'total_amount' => $totalAmount,
                ]);

            return response()->json([
                'message' => 'Invoice updated successfully',
                'invoice_id' => $existingInvoice->id,
                'total_amount' => $totalAmount,
                'invoice_details' => $invoiceDetails,
                'child_fullname' => $child->fullname,
            ]);
        } else {
            // Insert a new invoice
            $invoiceId = DB::table('invoices')->insertGetId([
                'child_id' => $child->id,
                'invoice_details' => json_encode($invoiceDetails),
                'total_amount' => $totalAmount,
                'invoice_date' => $today, // Only date (no time)
            ]);

            return response()->json([
                'message' => 'Invoice generated successfully',
                'invoice_id' => $invoiceId,
                'total_amount' => $totalAmount,
                'invoice_details' => $invoiceDetails,
                'child_fullname' => $child->fullname,
            ]);
        }
    }
}
