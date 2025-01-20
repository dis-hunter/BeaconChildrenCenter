<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitTypeResource\Pages;
use App\Filament\Resources\VisitTypeResource\RelationManagers;
use App\Models\VisitType;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitTypeResource extends Resource
{
    protected static ?string $model = VisitType::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationGroup(): ?string{
        return 'Static Data';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('visit_type')
                    ->required()
                    ->unique(ignoreRecord:true),
                TextInput::make('normal_price')
                    ->rules(['required','numeric','min:0'])
                    ->step(0.01)
                    ->columnSpan(2),
                TextInput::make('sponsored_price')
                    ->rules(['required','numeric','min:0'])
                    ->step(0.01)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('visit_type'),
                TextColumn::make('normal_price')->money('KES',true)->sortable(),
                TextColumn::make('sponsored_price')->money('KES',true)->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitTypes::route('/'),
            'create' => Pages\CreateVisitType::route('/create'),
            'edit' => Pages\EditVisitType::route('/{record}/edit'),
        ];
    }    
}
