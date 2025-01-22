<?php

namespace App\Filament\Resources\PaymentModesResource\Pages;

use App\Filament\Resources\PaymentModesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentModes extends CreateRecord
{
    protected static string $resource = PaymentModesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
