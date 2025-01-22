<?php

namespace App\Filament\Resources\TriageAssessmentResource\Pages;

use App\Filament\Resources\TriageAssessmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTriageAssessments extends ListRecords
{
    protected static string $resource = TriageAssessmentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
