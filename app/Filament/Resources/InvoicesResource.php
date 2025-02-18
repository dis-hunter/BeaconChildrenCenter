<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoicesResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

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

                BadgeColumn::make('invoice_status')
                    ->label('Invoice Status')
                    ->enum([
                        true => 'Paid',
                        false => 'Pending',
                    ])
                    ->colors([
                        'success' => true,
                        'warning' => false,
                    ])
                    ->sortable()
            ])
            ->filters([
                // Child ID Filter
                Filter::make('child_id')
                    ->form([
                        TextInput::make('child_id')
                            ->label('Child ID')
                            ->numeric()
                            ->placeholder('Enter Child ID'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['child_id'],
                            fn (Builder $query, $value): Builder => $query->where('child_id', $value)
                        );
                    }),

                // Invoice Status Filter
                SelectFilter::make('invoice_status')
                    ->label('Payment Status')
                    ->options([
                        '1' => 'Paid',
                        '0' => 'Pending',
                    ]),

                // Price Range Filter
                Filter::make('amount_range')
                    ->form([
                        TextInput::make('amount_from')
                            ->label('Minimum Amount')
                            ->numeric()
                            ->placeholder('Min Amount'),
                        TextInput::make('amount_to')
                            ->label('Maximum Amount')
                            ->numeric()
                            ->placeholder('Max Amount'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['amount_from'],
                                fn (Builder $query, $amount): Builder => $query->where('total_amount', '>=', $amount)
                            )
                            ->when(
                                $data['amount_to'],
                                fn (Builder $query, $amount): Builder => $query->where('total_amount', '<=', $amount)
                            );
                    }),

                // Date Range Filter
                Filter::make('invoice_date_range')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('From Date'),
                        DatePicker::make('date_to')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('invoice_date', '>=', $date)
                            )
                            ->when(
                                $data['date_to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('invoice_date', '<=', $date)
                            );
                    }),

                // Exact Date Filter
                Filter::make('exact_date')
                    ->form([
                        DatePicker::make('date')
                            ->label('Exact Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['date'],
                            fn (Builder $query, $date): Builder => $query->whereDate('invoice_date', '=', $date)
                        );
                    }),
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