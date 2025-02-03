<?php

namespace App\Filament\Resources\VisitTypeResource\Pages;

use App\Filament\Resources\VisitTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitType extends CreateRecord
{
    protected static string $resource = VisitTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
