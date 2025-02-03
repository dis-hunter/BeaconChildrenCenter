<?php

namespace App\Filament\Resources\DoctorSpecializationResource\Pages;

use App\Filament\Resources\DoctorSpecializationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctorSpecializations extends ListRecords
{
    protected static string $resource = DoctorSpecializationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
