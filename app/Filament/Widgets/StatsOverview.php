<?php

namespace App\Filament\Widgets;

use App\Models\children;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Patients',children::count())
                ->description('Increase in Patients')
                ->descriptionIcon('heroicon-o-trending-up')
                ->color('success')
                ->chart([0,7,4,9,15]),
        ];
    }
}
