<?php

namespace App\Filament\Resources\GuardiansResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $recordTitleAttribute = 'fullname->lastname';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('registration_number')
                ->disabled(),

                KeyValue::make('fullname')
                ->disableAddingRows()
                ->disableEditingKeys()
                ->keyLabel('Name')
                ->required(),

                Select::make('genderId')
                ->relationship('gender','gender')
                ->preload()
                ->required(),

                DatePicker::make('dob')
                ->label('Date of Birth')
                ->required(),

                TextInput::make('birth_cert')
                ->label('Birth Certificate')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->formatStateUsing(fn($state) => is_string($state) ? $state : trim("{$state->last_name} {$state->first_name} {$state->middle_name}")),
                
                    TextColumn::make('gender.gender')
                    ->label('Gender'),

                    TextColumn::make('dob')
                    ->label('Date of Birth'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
