<?php

namespace App\Filament\Resources\PaymentModesResource\Pages;

use App\Filament\Resources\PaymentModesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentModes extends ListRecords
{
    protected static string $resource = PaymentModesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
