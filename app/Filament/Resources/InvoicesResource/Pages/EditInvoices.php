<?php

namespace App\Filament\Resources\InvoicesResource\Pages;

use App\Filament\Resources\InvoicesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Illuminate\Database\Eloquent\Model;

class EditInvoices extends EditRecord
{
    protected static string $resource = InvoicesResource::class;

    protected function getActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        $invoice = $this->record;

        $actions = [
            Actions\Action::make('cancel')
                ->label('Back')
                ->url($this->previousUrl ?? static::getResource()::getUrl())
                ->color('secondary'),
        ];

        // Show the Payment button only if invoice_status is false (Pending)
        if (!$invoice->invoice_status) {
            $actions[] = Actions\Action::make('markAsPaid')
                ->label('Mark as Paid')
                ->color('success')
                ->action(function () use ($invoice) {
                    $invoice->invoice_status = true;
                    $invoice->save();
                    
                    $this->notify('success', 'Invoice marked as paid successfully.');
                    return redirect()->to(static::getResource()::getUrl());
                })
                ->requiresConfirmation()
                ->modalHeading('Mark Invoice as Paid')
                ->modalSubheading('Are you sure you want to mark this invoice as paid? This action cannot be undone.')
                ->modalButton('Yes, mark as paid');
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
                    ->disabled() // Make the field read-only
                    ->formatStateUsing(function ($state) {
                        return is_array($state) || is_object($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        return json_decode($state, true);
                    }),
            ]);
    }
}