<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    /**
     * Fetch expenses between specified start and end dates.
     */
    public function getExpensesByDateRange(Request $request)
    {
        // Log the incoming request
        Log::info('Fetching expenses with request data:', $request->all());

        try {
            // Validate the request
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'report_type' => 'required|string|in:expense_breakdown',
            ]);

            // Convert dates to Carbon instances
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

            // Log date range
            Log::info("Fetching expenses from {$startDate} to {$endDate}");

            // Fetch expenses
            $expenses = Expense::whereBetween('created_at', [$startDate, $endDate])
                ->select('id','category','amount', 'description', 'created_at','payment_method')
                ->get();

            // Log if no expenses found
            if ($expenses->isEmpty()) {
                Log::warning("No expenses found between {$startDate} and {$endDate}");
            } else {
                Log::info(count($expenses) . " expenses found.");
            }

            Log::info('Response sent to front end:', $expenses->toArray());


            // Return response
            return response()->json([
                'success' => true,
                'message' => 'Expenses retrieved successfully',
                'data' => $expenses,
                'report_type' => $request->input('report_type'),
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
            Log::error('Error fetching expenses:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching expenses',
            ], 500);
        }
    }
}
