<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinanceController extends Controller
{
  
    /*
public function getFinanceData()
{
    $startDate = Carbon::now()->subDays(30);
    $endDate = Carbon::now();

    $dailyRevenue = DB::table('payments')
        ->select(DB::raw("TO_CHAR(payment_date, 'YYYY-MM-DD') as day"), DB::raw('CAST(SUM(amount) AS DECIMAL(10,2)) as revenue'))
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->groupBy('day')
        ->orderBy('day')
        ->pluck('revenue', 'day');

    $dailyExpenses = DB::table('expenses')
        ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"), DB::raw('CAST(SUM(amount) AS DECIMAL(10,2)) as expenses'))
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('day')
        ->orderBy('day')
        ->pluck('expenses', 'day');

    // Generate last 30 days labels
    $dates = [];
    $revenueData = [];
    $expensesData = [];

    for ($i = 30; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->format('Y-m-d');
        $dates[] = $date;
        $revenueData[] = (float) ($dailyRevenue[$date] ?? 0);
        $expensesData[] = (float) ($dailyExpenses[$date] ?? 0);
    }

    return response()->json([
        'labels' => $dates,
        'revenue' => $revenueData,
        'expenses' => $expensesData
    ]);
} */

public function getFinanceData(Request $request)
{
    $period = $request->query('period', 'weekly');
    $startDate = match ($period) {
        'weekly' => Carbon::now()->subDays(7),
        'monthly' => Carbon::now()->subDays(30),
        'annually' => Carbon::now()->startOfYear(),
        default => Carbon::now()->subDays(7),
    };

    // Prepare a list of all months in the current year (for annual data)
    $allMonths = collect(range(1, 12))->map(fn($month) => Carbon::createFromDate(null, $month, 1)->format('Y-m'));

    // Adjust revenue and expense query based on the period
    if ($period === 'annually') {
        // Group by month (YYYY-MM) for annually
        $dailyRevenue = DB::table('payments')
            ->select(DB::raw("TO_CHAR(payment_date, 'YYYY-MM') as month"), DB::raw('SUM(amount) as revenue'))
            ->whereBetween('payment_date', [$startDate, Carbon::now()])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        $dailyExpenses = DB::table('expenses')
            ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"), DB::raw('SUM(amount) as expenses'))
            ->whereBetween('created_at', [$startDate, Carbon::now()])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('expenses', 'month');

        // Merge all months and set missing months to 0
        $labels = $allMonths->toArray();
        $revenue = $allMonths->map(fn($month) => $dailyRevenue->get($month, 0))->toArray();
        $expenses = $allMonths->map(fn($month) => $dailyExpenses->get($month, 0))->toArray();
    } else {
        // For weekly or monthly period, handle dates and ensure both data types match up
        $dailyRevenue = DB::table('payments')
            ->select(DB::raw("TO_CHAR(payment_date, 'YYYY-MM-DD') as day"), DB::raw('SUM(amount) as revenue'))
            ->whereBetween('payment_date', [$startDate, Carbon::now()])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('revenue', 'day');

        $dailyExpenses = DB::table('expenses')
            ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"), DB::raw('SUM(amount) as expenses'))
            ->whereBetween('created_at', [$startDate, Carbon::now()])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('expenses', 'day');

        // Collect the unique dates from both revenue and expenses to ensure all dates are accounted for
        $allLabels = collect(array_merge($dailyRevenue->keys()->toArray(), $dailyExpenses->keys()->toArray()))
            ->unique()
            ->sort()
            ->toArray();

        // Get revenue and expense data for each date
        $revenue = collect($allLabels)->map(fn($date) => $dailyRevenue->get($date, 0))->toArray();
        $expenses = collect($allLabels)->map(fn($date) => $dailyExpenses->get($date, 0))->toArray();

        $labels = $allLabels;
    }

    return response()->json([
        'labels' => array_values($labels),  // Convert to array
        'revenue' => array_values($revenue), // Convert to array
        'expenses' => array_values($expenses), // Convert to array
    ]);
    
}





    //
}
