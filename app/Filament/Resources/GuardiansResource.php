<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuardiansResource\Pages;
use App\Filament\Resources\GuardiansResource\RelationManagers;
use App\Filament\Resources\GuardiansResource\RelationManagers\ChildrenRelationManager;
use App\Models\Guardians;
use App\Models\Parents;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
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

class GuardiansResource extends Resource
{
    protected static ?string $model = Parents::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return 'Guardian';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Guardians';
    }

    public static function canCreate(): bool
    {
        return false;
    }

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

                TextColumn::make('gender.gender')
                    ->label('Gender'),

                TextColumn::make('telephone'),
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
            ChildrenRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardians::route('/create'),
            'edit' => Pages\EditGuardians::route('/{record}/edit'),
        ];
    }    
}
