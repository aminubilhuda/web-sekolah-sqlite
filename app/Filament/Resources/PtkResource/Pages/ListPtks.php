<?php

namespace App\Filament\Resources\PtkResource\Pages;

use App\Filament\Resources\PtkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPtks extends ListRecords
{
    protected static string $resource = PtkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
