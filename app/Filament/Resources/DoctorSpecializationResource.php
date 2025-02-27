<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorSpecializationResource\Pages;
use App\Filament\Resources\DoctorSpecializationResource\RelationManagers;
use App\Models\DoctorSpecialization;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\DeleteAction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorSpecializationResource extends Resource
{
    protected static ?string $model = DoctorSpecialization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string{
        return 'Static Data';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('specialization')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('role_id')
                    ->searchable()
                    ->nullable()
                    ->preload()
                    ->relationship('role', 'role'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('specialization'),
                TextColumn::make('role.role')
                    ->color('primary'),
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
            'index' => Pages\ListDoctorSpecializations::route('/'),
            'create' => Pages\CreateDoctorSpecialization::route('/create'),
            'edit' => Pages\EditDoctorSpecialization::route('/{record}/edit'),
        ];
    }
}
