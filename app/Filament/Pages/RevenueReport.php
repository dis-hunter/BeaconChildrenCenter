<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Services\RevenueReportService;


class RevenueReport extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static string $view = 'filament.pages.revenue-report';
    protected static ?string $title = 'Revenue Report';

    public $startDate;
    public $endDate;
    public $reportData = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Report Parameters')
                ->schema([
                    DatePicker::make('startDate')
                        ->label('Start Date')
                        ->required(),
                    DatePicker::make('endDate')
                        ->label('End Date')
                        ->required()
                        ->afterOrEqual('startDate'),
                ]),
        ];
    }

    public function generateReport(): void
    {
        $this->validate();
        
        $this->reportData = app(RevenueReportService::class)->generateReport(
            $this->startDate,
            $this->endDate
        );
    }
}
?>