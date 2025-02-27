<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\DoctorSpecialization;
use App\Models\User;
use App\Services\RegistrationNumberManager;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->schema([
                        KeyValue::make('fullname')
                            ->addable(false)
                            ->editableKeys(false)
                            ->keyLabel('Name')
                            ->default([
                                'first_name' => '',
                                'middle_name' => '',
                                'last_name' => ''
                            ]),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('telephone')
                            ->label('Phone Number')
                            ->tel()
                            ->placeholder('0712345678')
                            ->unique(ignoreRecord: true)
                            ->rules(['required', 'string', 'max:10']),
                        Select::make('gender_id')
                            ->relationship('gender', 'gender')
                            ->preload()
                            ->required(),
                        Select::make('role_id')
                            ->relationship('role', 'role')
                            ->preload()
                            ->required()
                            ->reactive(),
                        Select::make('specialization_id')
                            ->options(function (callable $get) {
                                if(!$get('role_id')) return [];
                                return DoctorSpecialization::where('role_id', $get('role_id'))->pluck('specialization', 'id')->toArray();
                            })
                            ->preload(false)
                            ->required()
                            ->visible(function ($get) {
                                $allowedRoles = [2, 5];
                                return in_array($get('role_id'), $allowedRoles);
                            }),
                        TextInput::make('staff_no')
                            ->label('Staff Number')
                            ->default(function () {
                                return (new RegistrationNumberManager('staff', 'staff_no'))->generateUniqueRegNumber();
                            })
                            ->disabled()
                            ->dehydrated(),
                        Toggle::make('is_admin')
                            ->helperText('Administrator role is OFF by default for all Users')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(fn ($get) => $get('role_id') == 1)
                            ->reactive(),

                    ])->columns(2),

                Section::make('Password Management')
                    ->description('Only to be used when user is unable to operate their Settings')
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                        ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('staff_no')
                //     ->sortable(),
                TextColumn::make('fullname')
                    ->formatStateUsing(function ($state) {
                        if (is_string($state)) return $state;
                        $last = $state->last_name ?? '';
                        $first = $state->first_name ?? '';
                        $middle = $state->middle_name ?? '';

                        return trim("{$last} {$first} {$middle}");
                    })
                    ->searchable(),
                TextColumn::make('role.role')
                    ->color('primary'),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('telephone')
                    ->searchable(),
                IconColumn::make('is_admin')
                    ->boolean()
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('role', 'role')
                    ->multiple()
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
