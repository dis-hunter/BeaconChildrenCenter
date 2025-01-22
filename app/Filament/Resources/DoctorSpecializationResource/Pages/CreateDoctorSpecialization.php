<?php

namespace App\Filament\Resources\DoctorSpecializationResource\Pages;

use App\Filament\Resources\DoctorSpecializationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctorSpecialization extends CreateRecord
{
    protected static string $resource = DoctorSpecializationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
