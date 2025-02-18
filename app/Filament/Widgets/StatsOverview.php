<?php

namespace App\Filament\Widgets;

use App\Models\children;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;
    
    protected function getCards(): array
    {
        return [
            Stat::make('Total Patients', children::count())
                ->description('Increase in Patients')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->chart((children::selectRaw('COUNT(*) as count, EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month')
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->pluck('count'))
                    ->toArray()),

            Stat::make('Total App Users', User::count())
                ->description('Increase in Users')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->chart((User::selectRaw('COUNT(*) as count, EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month')
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->pluck('count'))
                    ->toArray()),
        ];
    }
}
