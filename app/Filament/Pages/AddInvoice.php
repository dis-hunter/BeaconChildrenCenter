<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AddInvoice extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationLabel = 'Add Invoice';
    protected static ?string $navigationGroup = 'Finance';
    protected static string $view = 'filament.pages.add-invoice';
}
