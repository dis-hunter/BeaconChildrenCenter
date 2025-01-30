<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Expenses extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-add';
    protected static ?string $navigationLabel = 'Expenses';
    protected static ?string $navigationGroup = 'Finance';
    protected static string $view = 'filament.pages.expenses';
}
