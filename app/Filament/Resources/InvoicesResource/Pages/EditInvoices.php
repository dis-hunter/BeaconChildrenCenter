<?php

namespace App\Filament\Resources\InvoicesResource\Pages;

use App\Filament\Resources\InvoicesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form; // Import the correct Form class

class EditInvoices extends EditRecord
{
    protected static string $resource = InvoicesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('invoice_details')
                    ->label('Invoice Details')
                    ->rows(5)
                    ->required(),
            ]);
    }
}