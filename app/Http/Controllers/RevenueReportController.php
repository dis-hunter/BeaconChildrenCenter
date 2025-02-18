<?php
namespace App\Http\Controllers;

use App\Services\RevenueReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\VisitType;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RevenueReportController extends Controller
{
    public function __construct(
        private RevenueReportService $revenueReportService
    ) {}

    public function generateRevenueReport(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $specialization = $request->specialization;

        // Base query for visits
        $query = DB::table('visits')
            ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
            ->whereBetween('visits.visit_date', [$startDate, $endDate]);

        if ($specialization) {
            $query->where('visit_type.id', $specialization);
        }

        // Calculate daily revenue
        $dailyRevenue = $this->calculateDailyRevenue($query);

        // Calculate service breakdown
        $services = $this->calculateServiceBreakdown($query);

        // Calculate paid invoices
        $paidInvoices = $this->calculatePaidInvoices($startDate, $endDate);

        // Calculate summary
        $summary = $this->calculateSummary($query, $startDate, $endDate);

        return response()->json([
            'daily' => $dailyRevenue->values(),
            'services' => $services->values(),
            'summary' => $summary,
            'paidInvoices' => $paidInvoices
        ]);
    }

    private function calculateDailyRevenue($query)
    {
        return $query->clone()
            ->select(
                DB::raw('DATE(visits.visit_date) as date'),
                DB::raw('SUM(CASE 
                    WHEN visits.payment_mode_id = 3 THEN visit_type.sponsored_price 
                    ELSE visit_type.normal_price 
                END) as revenue')
            )
            ->groupBy(DB::raw('DATE(visits.visit_date)'))
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('Y-m-d'),
                    'revenue' => (float)$item->revenue
                ];
            });
    }

    private function calculateServiceBreakdown($query)
    {
        return $query->clone()
            ->select(
                'visit_type.visit_type as service',
                DB::raw('SUM(CASE 
                    WHEN visits.payment_mode_id = 3 THEN visit_type.sponsored_price 
                    ELSE visit_type.normal_price 
                END) as revenue')
            )
            ->groupBy('visit_type.id', 'visit_type.visit_type')
            ->orderBy('revenue', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'service' => $item->service,
                    'revenue' => (float)$item->revenue
                ];
            });
    }

    private function calculatePaidInvoices($startDate, $endDate)
    {
        return DB::table('invoices')
            ->select(
                DB::raw('DATE(invoice_date) as date'),
                DB::raw('SUM(total_amount) as amount')
            )
            ->where('invoice_status', true)
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(invoice_date)'))
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('Y-m-d'),
                    'amount' => (float)$item->amount
                ];
            });
    }

    private function calculateSummary($query, $startDate, $endDate)
    {
        $normalPayment = $query->clone()
            ->where('visits.payment_mode_id', '!=', 3)
            ->sum('visit_type.normal_price');

        $sponsoredPayment = $query->clone()
            ->where('visits.payment_mode_id', 3)
            ->sum('visit_type.sponsored_price');

        $paidInvoicesTotal = DB::table('invoices')
            ->where('invoice_status', true)
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->sum('total_amount');

        return [
            'normal_payment' => $normalPayment,
            'sponsored_payment' => $sponsoredPayment,
            'total_revenue' => $normalPayment + $sponsoredPayment,
            'paid_invoices_total' => $paidInvoicesTotal
        ];
    }
}