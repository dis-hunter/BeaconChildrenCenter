<?php

namespace App\Filament\Resources\InvoicesResource\Pages;

use App\Filament\Resources\InvoicesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;

class EditInvoices extends EditRecord
{
    protected static string $resource = InvoicesResource::class;
    public $insuranceAmounts = [];

    public function mount($record): void
{
    parent::mount($record); // Call the parent mount method

    // Ensure $this->record is an object
    if (!is_object($this->record)) {
        throw new \Exception('Invalid record type. Expected object, received: ' . gettype($this->record));
    }

    // Ensure `invoice_details` is treated as an array
    $invoiceDetails = (array) ($this->record->invoice_details ?? []);

    $this->insuranceAmounts = [];
    foreach ($invoiceDetails as $service => $amount) {
        if ($service === 'total_remaining') continue;
        $this->insuranceAmounts[$service] = 0; // Default to 0
    }
}


    private function getAmountValue($value)
    {
        if (is_object($value)) {
            $value = (array) $value;
        }
        if (is_array($value)) {
            return floatval($value['original'] ?? $value);
        }
        return floatval($value);
    }

    protected function getHeaderActions(): array
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

                $actions[] = Actions\Action::make('submitInsurance')
                ->label('Submit Insurance')
                ->color('primary')
                ->action(function () use ($invoice) {
                    $currentDetails = (array) $invoice->invoice_details;
                    $updatedDetails = [];
                    $totalRemaining = 0;
                    
                    \Log::info('Insurance Amounts Before Processing:', $this->insuranceAmounts);
                    
                    foreach ($currentDetails as $service => $amount) {
                        if ($service === 'total_remaining') continue;
                        
                        $originalAmount = $this->getAmountValue($amount);
                        $insuranceAmount = floatval($this->insuranceAmounts[$service] ?? 0);
            
                        // Validation: Ensure insurance amount does not exceed the original amount
                        if ($insuranceAmount > $originalAmount) {
                            $this->notify('danger', "Insurance amount for {$service} cannot be greater than the original amount (Ksh " . number_format($originalAmount, 2) . ").");
                            return;
                        }
            
                        $remainingAmount = $originalAmount - $insuranceAmount;
                        
                        $updatedDetails[$service] = [
                            'original' => $originalAmount,
                            'insurance' => $insuranceAmount,
                            'remaining' => $remainingAmount
                        ];
                        
                        $totalRemaining += $remainingAmount;
                    }
                    
                    $updatedDetails['total_remaining'] = $totalRemaining;
                    
                    \Log::info('Updated Invoice Details:', $updatedDetails);
                    
                    $invoice->invoice_details = $updatedDetails;
                    $invoice->total_amount = $totalRemaining; // **Update total_amount**
                    $invoice->save();
                    
                    $this->notify('success', 'Insurance amounts processed successfully. Total Remaining: Ksh' . number_format($totalRemaining, 2));
                    return redirect()->to(static::getResource()::getUrl());
                })
                ->requiresConfirmation()
                ->modalHeading('Submit Insurance Amounts')
                ->modalSubheading('Are you sure you want to submit these insurance amounts?')
                ->modalButton('Yes, submit');
            
            
        }

        return $actions;
    }

    public function form(Form $form): Form
    {
        $invoice = $this->record;
        $invoiceDetails = (array) $invoice->invoice_details;

        $originalDetailsCard = Card::make()
            ->schema([
                Textarea::make('invoice_details')
                    ->label('Invoice Details')
                    ->rows(5)
                    ->disabled()
                    ->formatStateUsing(function ($state) {
                        if (is_string($state)) {
                            $state = json_decode($state, true);
                        }
                        $state = (array) $state;
                        if (isset($state['total_remaining'])) {
                            unset($state['total_remaining']);
                        }
                        return json_encode($state, JSON_PRETTY_PRINT);
                    }),
            ]);

        $insuranceFields = [];
        foreach ($invoiceDetails as $service => $amount) {
            if ($service === 'total_remaining') continue;

            $originalAmount = $this->getAmountValue($amount);

            $insuranceFields[] = TextInput::make("insuranceAmounts.{$service}")
    ->label(ucwords($service))
    ->numeric()
    ->rules(['numeric', "max:$originalAmount"])
    ->placeholder("Enter insurance amount for {$service}")
    ->helperText("Original amount: " . number_format($originalAmount, 2))
    ->reactive()
    ->afterStateUpdated(fn ($state) => $this->insuranceAmounts[$service] = floatval($state));

        }

        $insuranceCard = Card::make()
            ->label('Insurance Details')
            ->schema($insuranceFields);

        return $form->schema([
            Grid::make()
                ->schema([
                    $originalDetailsCard,
                    $insuranceCard,
                ])
                ->columns(1),
        ]);
    }
}
