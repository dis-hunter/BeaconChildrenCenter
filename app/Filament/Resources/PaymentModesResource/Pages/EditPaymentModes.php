<?php

namespace App\Filament\Resources\PaymentModesResource\Pages;

use App\Filament\Resources\PaymentModesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentModes extends EditRecord
{
    protected static string $resource = PaymentModesResource::class;

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
