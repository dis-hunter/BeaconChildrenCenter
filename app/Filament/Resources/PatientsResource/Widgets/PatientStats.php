<?php

namespace App\Filament\Resources\PatientsResource\Widgets;

use App\Models\children;
use Filament\Forms\Components\Card;
use Filament\Widgets\Widget;

class PatientStats extends Widget
{
    protected static string $view = 'filament.resources.patients-resource.widgets.patient-stats';

    protected function getCards(): array
    {
        // Get the total number of patients
        $patientCount = children::count();

        return [
            Card::make($patientCount)
                ->label('Total Patients')
                ->description('Number of patients in the system')
                ->descriptionIcon('heroicon-s-users')
                ->color('primary'),
        ];
    }
}
