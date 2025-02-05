<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

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

        // Convert dates to Carbon instances (only once)
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

       
        // Fetch expenses within the date range and select only necessary columns
        $expenses = Expense::whereBetween('created_at', [$startDate, $endDate])
            ->select('id', 'amount', 'description', 'created_at') // Only fetch necessary columns to reduce data load
            ->get();

       

        // Return response with report_type included
        return response()->json([
            'success' => true,
            'message' => 'Expenses retrieved successfully',
            'data' => $expenses,
            'report_type' => $request->input('report_type'),
        ]);
    }
}
