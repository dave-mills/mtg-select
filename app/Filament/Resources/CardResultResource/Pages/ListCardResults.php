<?php

namespace App\Filament\Resources\CardResultResource\Pages;

use App\Filament\Resources\CardResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardResults extends ListRecords
{
    protected static string $resource = CardResultResource::class;

    protected ?string $heading = 'Count of Wants or Not Wants per Card';


    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
