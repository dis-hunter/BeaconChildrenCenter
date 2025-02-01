<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Fetch expenses between specified start and end dates.
     */
    public function getExpensesByDateRange(Request $request)
    {
        // Validate the request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|string|in:expense_breakdown', // Add validation for report_type
        ]);

        // Retrieve the report type from the request
        $reportType = $request->input('report_type');

        // Convert dates to Carbon instances
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay(); // Start of the day (00:00:00)
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay(); // End of the day (23:59:59)

        // Log request details including the report_type
        Log::info("Fetching expenses between {$startDate} and {$endDate} for report type: {$reportType}");

        // Fetch expenses within the date range
        $expenses = Expense::whereBetween('created_at', [$startDate, $endDate])->get();

        // Log the retrieved records
        Log::info('Expenses Retrieved:', ['count' => $expenses->count(), 'data' => $expenses]);

        // Return response with report_type included
        return response()->json([
            'success' => true,
            'message' => 'Expenses retrieved successfully',
            'data' => $expenses,
            'report_type' => $reportType, // Include report_type in the response
        ]);
    }
}
