<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoicesResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
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
                TextInput::make('child_id')
                    ->label('Child ID')
                    ->required()
                    ->numeric(),

                TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->required()
                    ->numeric(),

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
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
    
                TextColumn::make('child_id')
                    ->label('Child ID')
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
                // Date filter with before/after options
                Tables\Filters\Filter::make('date_filter')
                    ->form([
                        Select::make('date_condition')
                            ->label('Date Condition')
                            ->options([
                                'exact' => 'Exact Date',
                                'before' => 'Before Date',
                                'after' => 'After Date'
                            ])
                            ->required(),
                        DatePicker::make('date')
                            ->label('Select Date')
                            ->required(),
                    ])
                    ->query(function ($query, array $data) {
                        if (isset($data['date']) && isset($data['date_condition'])) {
                            return $query->when($data['date_condition'] === 'exact', function ($query) use ($data) {
                                return $query->whereDate('invoice_date', $data['date']);
                            })
                            ->when($data['date_condition'] === 'before', function ($query) use ($data) {
                                return $query->whereDate('invoice_date', '<=', $data['date']);
                            })
                            ->when($data['date_condition'] === 'after', function ($query) use ($data) {
                                return $query->whereDate('invoice_date', '>=', $data['date']);
                            });
                        }
                        return $query;
                    }),

                // Existing Child ID filter
                Tables\Filters\Filter::make('child_id')
                    ->label('Search by Child ID')
                    ->form([
                        TextInput::make('child_id')
                            ->numeric()
                            ->placeholder('Enter Child ID'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['child_id'],
                            fn ($q, $childId) => $q->where('child_id', $childId)
                        );
                    }),
    
                // Existing Price Range filter
                Tables\Filters\Filter::make('price_range')
                    ->label('Price Range (Max)')
                    ->form([
                        TextInput::make('max_price')
                            ->numeric()
                            ->placeholder('Enter Max Price'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['max_price'],
                            fn ($q, $maxPrice) => $q->where('total_amount', '<=', $maxPrice)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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