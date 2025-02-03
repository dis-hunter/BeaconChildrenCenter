<?php

namespace App\Filament\Resources\DoctorSpecializationResource\Pages;

use App\Filament\Resources\DoctorSpecializationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoctorSpecialization extends EditRecord
{
    protected static string $resource = DoctorSpecializationResource::class;

    protected function getActions(): array
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
