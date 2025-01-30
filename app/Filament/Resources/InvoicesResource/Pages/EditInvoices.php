<?php

namespace App\Filament\Resources\InvoicesResource\Pages;

use App\Filament\Resources\InvoicesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvoices extends EditRecord
{
    protected static string $resource = InvoicesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
