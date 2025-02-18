<?php

namespace App\Filament\Resources\GuardiansResource\Pages;

use App\Filament\Resources\GuardiansResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuardians extends EditRecord
{
    protected static string $resource = GuardiansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
