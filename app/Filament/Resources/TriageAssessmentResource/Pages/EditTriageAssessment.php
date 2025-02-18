<?php

namespace App\Filament\Resources\TriageAssessmentResource\Pages;

use App\Filament\Resources\TriageAssessmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTriageAssessment extends EditRecord
{
    protected static string $resource = TriageAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
