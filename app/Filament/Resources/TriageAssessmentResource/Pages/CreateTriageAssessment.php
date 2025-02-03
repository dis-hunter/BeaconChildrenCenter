<?php

namespace App\Filament\Resources\TriageAssessmentResource\Pages;

use App\Filament\Resources\TriageAssessmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTriageAssessment extends CreateRecord
{
    protected static string $resource = TriageAssessmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
