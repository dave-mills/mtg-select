<?php

namespace App\Filament\Resources\CardColourResource\Pages;

use App\Filament\Resources\CardColourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardColours extends ListRecords
{
    protected static string $resource = CardColourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
