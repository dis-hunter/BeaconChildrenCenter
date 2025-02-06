<?php

namespace App\Filament\Widgets;

use App\Models\Role;
use App\Models\User;
use Filament\Widgets\PieChartWidget;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UsersChartWidget extends PieChartWidget
{
    protected static ?string $heading = 'User Classification';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $roles = Role::pluck('role', 'id')->toArray();

        $userCounts = User::select('role_id', DB::raw('count(*) as count'))
            ->whereIn('role_id', array_keys($roles))
            ->groupBy('role_id')
            ->pluck('count', 'role_id')
            ->toArray();

        $data = [];
        foreach($roles as $roleId => $role){
            $data[]= $userCounts[$roleId] ?? 0;
        }

        return [
            'labels' => array_values($roles),
            'datasets' => [
                [
                    'label' => 'User Roles',
                    'data' => $data,
                    'backgroundColor' => $this->generateColors(count($roles)),
                ],
            ],
        ];
    }

    private function generateColors($count): array
    {
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#8D6E63', '#26A69A'];
        return array_slice(array_merge($colors, $this->generateRandomColors($count - count($colors))), 0, $count);
    }

    private function generateRandomColors($count): array
    {
        $randomColors = [];
        for ($i = 0; $i < $count; $i++) {
            $randomColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        return $randomColors;
    }
}
