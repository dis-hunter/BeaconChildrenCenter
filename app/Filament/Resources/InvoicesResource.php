<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoicesResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class InvoicesResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-tax';

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('invoice_details')
                    ->label('Invoice Details')
                    ->rows(5)
                    ->required(),

                DatePicker::make('invoice_date')
                    ->label('Invoice Date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Invoice ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('child_id')
                    ->label('Child ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('child.fullname')
                    ->label('Child Name')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return implode(' ', array_values($state));
                        }
                        if (is_object($state)) {
                            return implode(' ', array_values((array)$state));
                        }
                        try {
                            $decoded = json_decode($state, true);
                            if ($decoded && is_array($decoded)) {
                                return implode(' ', array_values($decoded));
                            }
                        } catch (\Exception $e) {
                            return 'N/A';
                        }
                        return $state ?? 'N/A';
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->sortable(),

                TextColumn::make('invoice_date')
                    ->label('Invoice Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable(),
            ])
            ->filters([
                // Add your filters here
            ])
            ->actions([
                EditAction::make()->label('More Details'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoices::route('/create'),
            'edit' => Pages\EditInvoices::route('/{record}/edit'),
        ];
    }
}