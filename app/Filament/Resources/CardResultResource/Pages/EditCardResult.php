<?php

namespace App\Filament\Resources\CardResultResource\Pages;

use App\Filament\Resources\CardResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardResult extends EditRecord
{
    protected static string $resource = CardResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
