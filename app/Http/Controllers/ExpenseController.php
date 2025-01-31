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
        ]);

        // Convert dates to Carbon instances
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay(); // Start of the day (00:00:00)
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay(); // End of the day (23:59:59)

        // Log request details
        Log::info("Fetching expenses between {$startDate} and {$endDate}");

        // Fetch expenses within the date range
        $expenses = Expense::whereBetween('created_at', [$startDate, $endDate])->get();

        // Log the retrieved records
        Log::info('Expenses Retrieved:', ['count' => $expenses->count(), 'data' => $expenses]);

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Expenses retrieved successfully',
            'data' => $expenses
        ]);
    }
}
