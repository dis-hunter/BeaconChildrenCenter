<?php

namespace App\Filament\Resources\RelationshipsResource\Pages;

use App\Filament\Resources\RelationshipsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRelationships extends EditRecord
{
    protected static string $resource = RelationshipsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
