<?php

namespace App\Filament\Resources\RelationshipsResource\Pages;

use App\Filament\Resources\RelationshipsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRelationships extends CreateRecord
{
    protected static string $resource = RelationshipsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
