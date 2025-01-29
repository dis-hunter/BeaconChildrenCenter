<?php

namespace App\Filament\Resources\InvoicesResource\Pages;

use App\Filament\Resources\InvoicesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;

class EditInvoices extends EditRecord
{
    protected static string $resource = InvoicesResource::class;

    protected function getActions(): array
    {
        // Remove the Delete action
        return [];
    }

    protected function getFormActions(): array
    {
        // Remove the Save action and rename the Cancel button to Back
        return [
            Actions\Action::make('cancel')
                ->label('Back')
                ->url($this->previousUrl ?? static::getResource()::getUrl())
                ->color('secondary'),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('invoice_details')
                    ->label('Invoice Details')
                    ->rows(5)
                    ->required()
                    ->formatStateUsing(function ($state) {
                        // Convert the object to a JSON string
                        return is_array($state) || is_object($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        return json_decode($state, true);
                    }),
            ]);
    }
}