<?php

namespace App\Filament\Resources\GuardiansResource\Pages;

use App\Filament\Resources\GuardiansResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuardians extends ListRecords
{
    protected static string $resource = GuardiansResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
