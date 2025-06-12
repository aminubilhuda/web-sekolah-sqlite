<?php

namespace App\Filament\Resources\KontakResource\Pages;

use App\Filament\Resources\KontakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKontak extends EditRecord
{
    protected static string $resource = KontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Jika status diubah menjadi "Sudah Dibaca" dan belum ada waktu dibaca
        if ($this->record->status === 'Sudah Dibaca' && !$this->record->dibaca_at) {
            $this->record->tandaiDibaca();
        }

        // Jika status diubah menjadi "Dibalas" dan ada balasan
        if ($this->record->status === 'Dibalas' && $this->record->balasan) {
            $this->record->balas($this->record->balasan);
        }
    }
} 