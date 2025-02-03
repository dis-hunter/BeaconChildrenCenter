<?php

namespace App\Filament\Resources\PatientsResource\RelationManagers;

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
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParentRelationManager extends RelationManager
{
    protected static string $relationship = 'parents';

    protected static ?string $recordTitleAttribute = 'fullname->last_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                KeyValue::make('fullname')
                    ->disableAddingRows()
                    ->disableEditingKeys()
                    ->keyLabel('Name')
                    ->required(),

                Select::make('relationship_id')
                    ->relationship('relationship', 'relationship')
                    ->preload()
                    ->required(),

                DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->required(),

                Select::make('gender_id')
                    ->relationship('gender', 'gender')
                    ->preload()
                    ->required(),

                TextInput::make('telephone')
                    ->label('Phone Number')
                    ->tel()
                    ->placeholder('0712345678')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rules(['required', 'string', 'max:10']),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('national_id')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->minLength(15),

                TextInput::make('employer')
                    ->nullable()
                    ->rules(['string', 'max:255']),

                TextInput::make('insurance')
                    ->nullable()
                    ->rules(['string', 'max:255']),

                TextInput::make('referer')
                    ->nullable()
                    ->rules(['string', 'max:255']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->formatStateUsing(fn($state) => is_string($state) ? $state : trim("{$state->last_name} {$state->first_name} {$state->middle_name}")),

                TextColumn::make('relationship.relationship')
                    ->label('Relationship'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
