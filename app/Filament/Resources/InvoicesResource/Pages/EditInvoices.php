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
                    ->required()
                    ->formatStateUsing(function ($state) {
                        // Convert the object to a JSON string
                        return is_array($state) || is_object($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        $lines = explode("\n", $state);
                        $data = [];
                        
                        foreach ($lines as $line) {
                            if (strpos($line, ':') !== false) {
                                [$service, $amount] = array_map('trim', explode(':', $line, 2));
                                $data[$service] = $amount;
                            }
                        }
                        
                        return json_encode($data);
                    }),
            ]);
    }
}