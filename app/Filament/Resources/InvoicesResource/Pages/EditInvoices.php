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
        return [];
    }

    protected function getFormActions(): array
    {
        $invoice = $this->record; // Get the current invoice record

        $actions = [
            Actions\Action::make('cancel')
                ->label('Back')
                ->url($this->previousUrl ?? static::getResource()::getUrl())
                ->color('secondary'),
        ];

        // Show the Edit button only if invoice_status is false (Pending)
        if (!$invoice->invoice_status) {
            $actions[] = Actions\EditAction::make()
                ->label('Edit')
                ->color('primary');
        }

        return $actions;
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
                        return is_array($state) || is_object($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        return json_decode($state, true);
                    }),
            ]);
    }
}
