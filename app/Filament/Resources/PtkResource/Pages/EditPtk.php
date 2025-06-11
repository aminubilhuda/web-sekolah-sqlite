<?php

namespace App\Filament\Resources\PtkResource\Pages;

use App\Filament\Resources\PtkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPtk extends EditRecord
{
    protected static string $resource = PtkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
