<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RelationshipsResource\Pages;
use App\Filament\Resources\RelationshipsResource\RelationManagers;
use App\Models\Relationship;
use App\Models\Relationships;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RelationshipsResource extends Resource
{
    protected static ?string $model = Relationship::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string{
        return 'Static Data';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('relationship')
                    ->required()
                    ->unique(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('relationship'),
                TextColumn::make('created_at')->dateTime('d-M-Y H:i')->sortable(),
                TextColumn::make('updated_at')->dateTime('d-M-Y H:i')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRelationships::route('/'),
            'create' => Pages\CreateRelationships::route('/create'),
            'edit' => Pages\EditRelationships::route('/{record}/edit'),
        ];
    }    
}
