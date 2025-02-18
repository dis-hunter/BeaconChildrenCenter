<?php

namespace App\Filament\Resources\RelationshipsResource\Pages;

use App\Filament\Resources\RelationshipsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRelationships extends ListRecords
{
    protected static string $resource = RelationshipsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
