<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientsResource\Pages;
use App\Filament\Resources\PatientsResource\RelationManagers;
use App\Filament\Resources\PatientsResource\RelationManagers\ParentRelationManager;
use App\Filament\Resources\PatientsResource\Widgets\PatientStats;
use App\Models\children;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientsResource extends Resource
{
    protected static ?string $model = children::class;

    public static function getModelLabel(): string
    {
        return 'Patient';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Patients';
    }

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function canCreate(): bool
    {
        return false;
    }

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
                    ->relationship('gender', 'gender')
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
                TextColumn::make('registration_number')
                    ->sortable(),

                TextColumn::make('fullname')
                    ->formatStateUsing(fn($state) => is_string($state) ? $state : trim("{$state->last_name} {$state->first_name} {$state->middle_name}")),

                TextColumn::make('dob')
                    ->label('Date of Birth'),

            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ParentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatients::route('/create'),
            'edit' => Pages\EditPatients::route('/{record}/edit'),
        ];
    }
}
