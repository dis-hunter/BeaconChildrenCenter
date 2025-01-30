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
            // ->where('visits.completed', true)
            ->whereBetween('visits.visit_date', [$startDate, $endDate]);

        if ($specialization) {
            $query->where('visit_type.id', $specialization);
        }

        // Calculate daily revenue with proper date handling
        $dailyRevenue = $query->clone()
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

        // Calculate service breakdown
        $services = $query->clone()
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

        // Calculate summary with separate normal and sponsored payments
        // $summary = [
        //     'total_revenue' => $query->clone()
        //         ->selectRaw('SUM(CASE 
        //             WHEN visits.payment_mode_id = 3 THEN visit_type.sponsored_price 
        //             ELSE visit_type.normal_price 
        //         END) as total')
        //         ->value('total'),
        //     'normal_payment' => $query->clone()
        //         ->where('visits.payment_mode_id', '!=', 3)
        //         ->sum('visit_type.normal_price'),
        //     'sponsored_payment' => $query->clone()
        //         ->where('visits.payment_mode_id', 3)
        //         ->sum('visit_type.sponsored_price')
        // ];
        // Calculate summary with separate normal and sponsored payments
$normalPayment = $query->clone()
->where('visits.payment_mode_id', '!=', 3)
->sum('visit_type.normal_price');

$sponsoredPayment = $query->clone()
->where('visits.payment_mode_id', 3)
->sum('visit_type.sponsored_price');

$summary = [
'normal_payment' => $normalPayment,
'sponsored_payment' => $sponsoredPayment,
'total_revenue' => $normalPayment + $sponsoredPayment // Calculate total as sum of both
];

        // Log the queries for debugging
        Log::info('Revenue Queries', [
            'total' => $summary['total_revenue'],
            'normal' => $summary['normal_payment'],
            'sponsored' => $summary['sponsored_payment'],
            'daily_count' => $dailyRevenue->count(),
            'services_count' => $services->count()
        ]);

        return response()->json([
            'daily' => $dailyRevenue->values(),
            'services' => $services->values(),
            'summary' => $summary
        ]);
    }
}