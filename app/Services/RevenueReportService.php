<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\PaymentMode;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RevenueReportService
{
    public function generateFinancialSummary(string $startDate, string $endDate): array
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $invoices = Invoice::with(['visit.paymentMode'])
            ->select(['id', 'visit_id', 'invoice_date', 'total_amount', 'invoice_details'])
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->get();

        return [
            'summary' => [
                'total_revenue' => $invoices->sum('total_amount'),
                'average_daily_revenue' => $invoices->average('total_amount'),
                'transaction_count' => $invoices->count(),
                'peak_day' => $this->getPeakRevenueDay($invoices),
            ],
            'charts' => [
                'daily_trend' => $this->calculateDailyRevenue($invoices),
                'payment_modes' => $this->calculatePaymentModeRevenue($invoices),
                'services' => $this->calculateSpecializationRevenue($invoices)
            ]
        ];
    }

    public function generateRevenueBreakdown(string $startDate, string $endDate): array
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $invoices = Invoice::with(['visit.paymentMode', 'visit.visitType'])
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->get();

        return [
            'by_service' => $this->calculateSpecializationRevenue($invoices),
            'by_payment_mode' => $this->calculatePaymentModeRevenue($invoices),
            'by_visit_type' => $this->calculateVisitTypeRevenue($invoices),
            'sponsored_vs_normal' => $this->calculateSponsoredVsNormalRevenue($invoices)
        ];
    }

    private function getPeakRevenueDay(Collection $invoices): array
    {
        return $invoices
            ->groupBy(fn ($invoice) => $invoice->invoice_date->format('Y-m-d'))
            ->map(fn ($group) => [
                'date' => $group->first()->invoice_date->format('Y-m-d'),
                'amount' => $group->sum('total_amount'),
                'transactions' => $group->count()
            ])
            ->sortByDesc('amount')
            ->first();
    }

    private function calculateVisitTypeRevenue(Collection $invoices): array
    {
        return $invoices
            ->groupBy('visit.visit_type.visit_type')
            ->map(fn ($group) => $group->sum('total_amount'))
            ->toArray();
    }

    private function calculateSponsoredVsNormalRevenue(Collection $invoices): array
    {
        return [
            'sponsored' => $invoices
                ->where('visit.payment_mode_id', PaymentMode::NCPWD_ID)
                ->sum('total_amount'),
            'normal' => $invoices
                ->where('visit.payment_mode_id', '!=', PaymentMode::NCPWD_ID)
                ->sum('total_amount')
        ];
    }
    public function generateReport(string $startDate, string $endDate): array
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $invoices = Invoice::with(['visit.paymentMode'])
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->get();

        return [
            'daily_revenue' => $this->calculateDailyRevenue($invoices),
            'specialization_revenue' => $this->calculateSpecializationRevenue($invoices),
            'payment_mode_revenue' => $this->calculatePaymentModeRevenue($invoices),
            'total_revenue' => $invoices->sum('total_amount'),
        ];
    }

    private function calculateDailyRevenue(Collection $invoices): array
    {
        return $invoices
            ->groupBy(fn ($invoice) => $invoice->invoice_date->format('Y-m-d'))
            ->map(fn ($group) => $group->sum('total_amount'))
            ->toArray();
    }

    private function calculateSpecializationRevenue(Collection $invoices): array
    {
        $specializationRevenue = [];

        foreach ($invoices as $invoice) {
            $details = $invoice->invoice_details;
            foreach ($details as $service => $amount) {
                if (!isset($specializationRevenue[$service])) {
                    $specializationRevenue[$service] = 0;
                }
                $specializationRevenue[$service] += $amount;
            }
        }

        return $specializationRevenue;
    }

    private function calculatePaymentModeRevenue(Collection $invoices): array
    {
        return $invoices
            ->groupBy('visit.payment_mode.payment_mode')
            ->map(fn ($group) => $group->sum('total_amount'))
            ->toArray();
    }
}
?>