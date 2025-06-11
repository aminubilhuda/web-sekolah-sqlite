<?php

namespace App\Filament\Resources\HubinResource\Pages;

use App\Filament\Resources\HubinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHubin extends EditRecord
{
    protected static string $resource = HubinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
