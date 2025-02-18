<?php

namespace App\Filament\Resources\VisitTypeResource\Pages;

use App\Filament\Resources\VisitTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitTypes extends ListRecords
{
    protected static string $resource = VisitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
