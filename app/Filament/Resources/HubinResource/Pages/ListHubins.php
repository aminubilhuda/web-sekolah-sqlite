<?php

namespace App\Filament\Resources\HubinResource\Pages;

use App\Filament\Resources\HubinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHubins extends ListRecords
{
    protected static string $resource = HubinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
